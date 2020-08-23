<?php

namespace App\Listeners;

use App\Events\ArticleParsed;
use App\FactChecking\Services\TextRu\SendTextRuRequestService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTextRuRequest implements ShouldQueue {
    /**
     * Handle the event.
     *
     * ArticleParsed $event
     * @param ArticleParsed $event
     * @return void
     * @throws Exception
     * @throws GuzzleException
     */
    public function handle(ArticleParsed $event) {
        $analysedUrlId = $event->getAnalysedUrlId();

        (new SendTextRuRequestService($analysedUrlId))->send();
    }
}
