<?php

namespace App\Listeners;

use App\Events\ArticleParsed;
use App\Jobs\SendTextRuRequestJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTextRuRequest implements ShouldQueue {
    /**
     * Handle the event.
     *
     * ArticleParsed $event
     * @param ArticleParsed $event
     * @return void
     */
    public function handle(ArticleParsed $event) {
        $analysedUrlId = $event->getAnalysedUrlId();

        dispatch(new SendTextRuRequestJob($analysedUrlId));
    }
}
