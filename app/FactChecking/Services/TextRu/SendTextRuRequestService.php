<?php

namespace App\FactChecking\Services\TextRu;

use App\Models\AnalysedUrl;
use Exception;
use Illuminate\Support\Facades\Http;

class SendTextRuRequestService
{
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
        $this->analysedUrlId = $analysedUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception|GuzzleException
     */
    public function send()
    {
        $analysedUrl = AnalysedUrl::query()->find($this->analysedUrlId);
        if (!$analysedUrl) {
            throw new Exception("Analysed url not found");
        }

        $url = env('TEXT_RU_URL');
        $response = Http::asForm()->post($url, [
            'text' => $analysedUrl->article,
            'userkey' => env('TEXT_RU_KEY')
        ]);

        if ($response->status() >= 200 and $response->status() < 300) {
            $responseContent = json_decode($response->body());
            if (!isset($responseContent->text_uid)) {
                throw new Exception("Request to text.ru failed. Package symbols ended.");
            }
            $text_uid = $responseContent->text_uid;

            dispatch(new ReceiveTextRuResponseJob($this->analysedUrlId, $text_uid));
        } else {
            throw new Exception("Failed to fetch text ru");
        }
    }
}
