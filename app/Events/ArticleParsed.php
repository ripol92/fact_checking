<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class ArticleParsed
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;

    /**
     * @var string
     */
    private $analysedUrlId;

    /**
     * Create a new event instance.
     *
     * @param string $analysedArticleId
     */
    public function __construct($analysedArticleId)
    {
        $this->analysedUrlId = $analysedArticleId;
    }
    /**
     * @return string
     */
    public function getAnalysedUrlId() {
        return $this->analysedUrlId;
    }
}
