<?php

namespace App\Listeners;

use App\Events\RequestToTextRuSent;
use App\Jobs\ReceiveTextRuResponseJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiveTextRuResponse implements ShouldQueue {
    /**
     * Handle the event.
     *
     * @param RequestToTextRuSent $event
     * @return void
     */
    public function handle($event) {
        dispatch(new ReceiveTextRuResponseJob($event->getAnalysedUrlId(), $event->getUid()))->delay(10);
    }
}
