<?php

namespace App\Events;

use App\AnalysedUrl;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleParsed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var AnalysedUrl
     */
    private $analysedUrl;

    /**
     * Create a new event instance.
     *
     * @param AnalysedUrl|Model $analysedArticle
     */
    public function __construct($analysedArticle)
    {
        //
        $this->analysedUrl = $analysedArticle;
    }
    /**
     * @return AnalysedUrl
     */
    public function getAnalysedUrl(): AnalysedUrl {
        return $this->analysedUrl;
    }
}
