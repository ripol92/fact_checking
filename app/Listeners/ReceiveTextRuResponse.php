<?php

namespace App\Listeners;

use App\Events\RequestToTextRuSent;
use App\FactChecking\Services\TextRu\ReceiveTextRuResponseJob;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiveTextRuResponse implements ShouldQueue {

    /**
     * Handle the event.
     *
     * @param RequestToTextRuSent $event
     * @return void
     * @throws Exception
     */
    public function handle($event) {
        printf($event->getAnalysedUrlId(), $event->getUid());
        dispatch(new ReceiveTextRuResponseJob($event->getAnalysedUrlId(), $event->getUid()));
    }
}
