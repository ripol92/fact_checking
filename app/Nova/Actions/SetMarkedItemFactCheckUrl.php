<?php

namespace App\Nova\Actions;

use App\Models\MarkedItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;

class SetMarkedItemFactCheckUrl extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $url = $fields->get("url");
        foreach ($models as $model) {
            /**@var MarkedItem $model */
            $model->fact_check_url = $url;
            $model->save();
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Fact Check Result Url", "url")
                ->rules("required", "max:255", "url")
        ];
    }
}
