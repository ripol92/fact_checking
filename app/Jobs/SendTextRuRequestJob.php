<?php

namespace App\Jobs;

use App\AnalysedUrl;
use App\Events\RequestToTextRuSent;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTextRuRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AnalysedUrl
     */
    private $analysedUrlId;

    /**
     * Create a new job instance.
     *
     * @param string $analysedUrl
     */
    public function __construct($analysedUrl)
    {
        //
        $this->analysedUrlId = $analysedUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $analysedUrl = AnalysedUrl::query()->find($this->analysedUrlId);
        if (!$analysedUrl) throw new Exception("Analysed url not found");
        $url = env('TEXT_RU_URL');
        $client = new Client(['base_uri' => $url]);
        $data = [
            'text' => $analysedUrl->article,
            'userkey' => env('TEXT_RU_KEY')
        ];

        $response = $client->request('POST','',[
            "form_params" => $data
        ]);

        if ($response->getStatusCode() >= 200 and $response->getStatusCode() < 300) {
            $responseContent = json_decode($response->getBody()->getContents());
            if (!isset($responseContent->text_uid)) throw new Exception("Request to text.ru failed. Package symbols ended.");
            $text_uid = $responseContent->text_uid;

            event(new RequestToTextRuSent($analysedUrl, $text_uid));
        } else throw new Exception("Failed to fetch text ru");
    }
}
