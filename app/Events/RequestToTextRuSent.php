<?php

namespace App\Events;

use App\AnalysedUrl;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestToTextRuSent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var AnalysedUrl
     */
    private $analysedUrl;

    /**
     * @var string
     */
    private $uid; // uid from text ru

    /**
     * Create a new event instance.
     *
     * @param AnalysedUrl $analysedUrl
     * @param $uid
     */
    public function __construct(AnalysedUrl $analysedUrl, string $uid) {
        //
        $this->analysedUrl = $analysedUrl;
        $this->uid = $uid;
    }

    /**
     * @return AnalysedUrl
     */
    public function getAnalysedUrl(): AnalysedUrl {
        return $this->analysedUrl;
    }

    /**
     * @return string
     */
    public function getUid(): string {
        return $this->uid;
    }
}
