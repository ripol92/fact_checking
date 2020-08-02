<?php

namespace App\Listeners;

use App\Events\ArticleParsed;
use App\Events\RequestToTextRuSent;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SendTextRuRequest implements ShouldQueue {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param
     * ArticleParsed $event
     * @return void
     * @throws GuzzleException
     */
    public function handle($event) {
        $analysedArticle = $event->getAnalysedUrl();
        // send request to text.ru
        $url = env('TEXT_RU_URL');
        $client = new Client(['base_uri' => $url]);
        $data = [
            'text' => $analysedArticle->article,
            'userkey' => env('TEXT_RU_KEY')
        ];

        $response = $client->request('POST','',[
            "form_params" => $data
        ]);

        if ($response->getStatusCode() >= 200 and $response->getStatusCode() < 300) {
            $responseContent = json_decode($response->getBody()->getContents());
            $text_uid = $responseContent->text_uid;

            event(new RequestToTextRuSent($analysedArticle, $text_uid));
        } else throw new \Exception("Failed to fetch text ru");
    }
}
