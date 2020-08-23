<?php

namespace App\Nova\Actions;

use App\FactChecking\Services\SendUrlToParser;
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;

class AddAndAnalyseUrl extends DetachedAction
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     * @throws Exception
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $url = $fields->get('url');
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Wrong url");
        }

        $urlToParserSender = new SendUrlToParser();
        $urlToParserSender->send($url);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Url", "url")
        ];
    }
}
