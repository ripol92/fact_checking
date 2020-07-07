<?php

namespace App\Nova;

use App\Nova\Actions\AnalyzeImage;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;

class ImageCheck extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ImageCheck::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'identifier'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
                ->sortable()
                ->exceptOnForms(),

            Text::make("UUID", "identifier")
                ->exceptOnForms()
                ->hideFromIndex(),

            Boolean::make("Analyzed", function (\App\Models\ImageCheck $imgCheck) {
                return $imgCheck->message !== null;
            })->sortable()
                ->exceptOnForms(),

            Image::make("Input Image", function (\App\Models\ImageCheck $imgCheck) {
                return last(explode(DIRECTORY_SEPARATOR, $imgCheck->image_path));
            })
                ->exceptOnForms(),

            Text::make("Message", "message")
                ->exceptOnForms(),

            Image::make("Heatmap", function (\App\Models\ImageCheck $model) {
                return last(explode(DIRECTORY_SEPARATOR, $model->results_path)) . "/heatmap.jpg";
            })
                ->hideFromIndex()
                ->disableDownload(),

            Image::make("Warped", function (\App\Models\ImageCheck $model) {
                return last(explode(DIRECTORY_SEPARATOR, $model->results_path)) . "/warped.jpg";
            })
                ->hideFromIndex()
                ->disableDownload(),

            DateTime::make("Created At")
                ->sortable()
                ->exceptOnForms()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new AnalyzeImage()),
        ];
    }
}
