<?php

namespace App\Console\Commands;

use App\AnalysedUrl;
use App\FactChecking\Helpers\FastImage;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ListenParserResponse extends Command
{
    const RUN_TEXT_RU_JOBS_URL = "/runTextRuJobs";
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
                    $imageSizeCheck = $this->checkImageSize($imageLink);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    continue;
                }
                if (!$imageSizeCheck) {
                    continue;
                }
                try {
                    Storage::disk("public")->put(basename($imageLink), $this->file_get_content_curl($imageLink));
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    continue;
                }
                $imagePaths[] = basename($imageLink);
            }
            $analysedUrl = AnalysedUrl::query()->updateOrCreate(
                ["url" => $url],
                ["article" => $article, "image_links" => $imagePaths]
            );

            /** @var AnalysedUrl $analysedUrl */
            $this->makeBlackMagicRequest($analysedUrl->id);
        });
    }

    /**
     * @param string $url
     * @return bool|string
     */
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

    /**
     * @param string $imageUrl
     * @return bool
     */
    function checkImageSize($imageUrl) {
        $image = new FastImage($imageUrl);
        list($width, $height) = $image->getSize();
        if ($width < 500 || $height < 500) return false;
        return true;
    }

    /**
     * Due to the problem with redis and calling events from redis,
     * we make http request to workaround this problem
     * @param string $uudi
     */
    private function makeBlackMagicRequest(string $uudi) {
        $client = new Client();
        $client->get(env('APP_URL') . "" . self::RUN_TEXT_RU_JOBS_URL . "/" . $uudi);
    }
}
