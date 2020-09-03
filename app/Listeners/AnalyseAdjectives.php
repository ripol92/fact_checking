<?php

namespace App\Listeners;

use App\Events\ArticleParsed;
use App\Models\AnalysedUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnalyseAdjectives implements ShouldQueue
{
    use Queueable;

    const RU_LANG = "ru";

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
        if (isset($allAdjectives[$lng]) and $lng !== self::RU_LANG) {
            $allGivenLanguageAdjectives = $allAdjectives[$lng];
            foreach ($words as $word) {
                foreach ($allGivenLanguageAdjectives as $adjective) {
                    if(strtolower($word) == strtolower($adjective)) {++$adjectivesCount;}
                }
            }
        } elseif (isset($allAdjectives[$lng]) and $lng === self::RU_LANG) {
            $adjectivesCount = $this->countRussianLanguageAdjectivesInWords($words);
        }
        $analysedAdjectives["adjectives_count"] = $adjectivesCount;
        $analysedUrl->adjectives_analyse = $analysedAdjectives;
        $analysedUrl->save();
    }

    /**
     * @param $words
     * @return int
     */
    public function countRussianLanguageAdjectivesInWords($words) {
        $adjectivesCount = 0;
        $ruAdjectivesEndings = config('ru_adjectives_endings');
        foreach ($words as $word) {
            if (in_array(substr($word, -2, 2), $ruAdjectivesEndings)
                || in_array(substr($word, -3, 3), $ruAdjectivesEndings)
                || in_array(substr($word, -4, 4), $ruAdjectivesEndings)
            ) $adjectivesCount++;
        }

        return $adjectivesCount;
    }
}
