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
     * @param string $analysedUrlId
     * @param $uid
     */
    public function __construct($analysedUrlId, string $uid) {
        //
        $this->analysedUrl = $analysedUrlId;
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getAnalysedUrlId() {
        return $this->analysedUrl;
    }

    /**
     * text.ru UUID
     * @return string
     */
    public function getUid(): string {
        return $this->uid;
    }
}
