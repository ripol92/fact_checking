<?php

namespace App\Listeners;

use App\Events\ArticleParsed;
use App\Models\AnalysedUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnalyseAdjectives implements ShouldQueue
{
    use Queueable;

    /**
     * Handle the event.
     *
     * @param ArticleParsed $event
     * @return void
     */
    public function handle(ArticleParsed $event)
    {
        // analyse adjectives
        $analysedUrl = AnalysedUrl::query()->find($event->getAnalysedUrlId());
        /** @var AnalysedUrl $analysedUrl */
        $article = $analysedUrl->article;
        $lng = $analysedUrl->lng;

        $words = explode(" ", $article);
        $adjectivesCount = 0;

        $analysedAdjectives["words_count"] = count($words);
        $allAdjectives = config('adjectives');
        if (isset($allAdjectives[$lng])) {
            $allGivenLanguageAdjectives = $allAdjectives[$lng];
            foreach ($words as $word) {
                foreach ($allGivenLanguageAdjectives as $adjective) {
                    if(strtolower($word) == strtolower($adjective)) {++$adjectivesCount;}
                }
            }
        }
        $analysedAdjectives["adjectives_count"] = $adjectivesCount;
        $analysedUrl->adjectives_analyse = $analysedAdjectives;
        $analysedUrl->save();
    }
}
