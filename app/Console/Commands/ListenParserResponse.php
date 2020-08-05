<?php

namespace App\Console\Commands;

use App\AnalysedUrl;
use App\Events\ArticleParsed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ListenParserResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listen:parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::subscribe(['parsed_urls'], function ($message) {
            $data = json_decode($message);
            $url = $data->url;
            $article = $data->article;
            $imageLinks = $data->image_links;
            $imagePaths = [];

            foreach ($imageLinks as $imageLink) {
                if (!filter_var($imageLink, FILTER_VALIDATE_URL)) {
                    continue;
                }
                try {
                    $results = getimagesize($imageLink);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    continue;
                }
                if (!$results || empty($results)) {
                    continue;
                }
                if ($results[0] < 500 || $results[1] < 500) {
                    continue;
                }
                Storage::put(basename($imageLink), $this->file_get_content_curl($imageLink));
                $imagePaths[] = Storage::url(basename($imageLink));
            }
            $analysedUrl = AnalysedUrl::query()->create([
                "url" => $url,
                "article" => $article,
                "image_links" => json_encode($imagePaths)
            ]);

            event(new ArticleParsed($analysedUrl));
        });
    }

    function file_get_content_curl($url)
    {
        // Throw Error if the curl function does'nt exist.
        if (!function_exists('curl_init')) {
            die('CURL is not installed!');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
