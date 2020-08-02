<?php

namespace App\Listeners;

use App\Events\RequestToTextRuSent;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiveTextRuResponse implements ShouldQueue {
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
     * @param RequestToTextRuSent $event
     * @return void
     */
    public function handle($event) {
        sleep(10);
        $url = env("TEXT_RU_URL");
        $client = new Client(['base_uri' => $url]);
        $data = [
            'uid' => $event->getUid(),
            'userkey' => env("TEXT_RU_KEY")
        ];

        $response = $client->request('POST','',[
            "form_params" => $data
        ]);

        $textRuResponse = $response->getBody()->getContents();
        $analysedUrl = $event->getAnalysedUrl();
        $analysedUrl->text_ru = $textRuResponse;
        $analysedUrl->save();
    }
}
