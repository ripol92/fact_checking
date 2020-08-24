<?php

namespace App\Nova\Actions;

use App\AnalysedUrl;
use App\FactChecking\Services\SendUrlToParser;
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class AnalyzeUrls extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $urlToParserSender = new SendUrlToParser();
        foreach ($models as $model) {
            /** @var AnalysedUrl $model */
            if (!filter_var($model->url, FILTER_VALIDATE_URL)) {
                continue;
            }
            $url = $model->url;

            $urlToParserSender->send($url);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
