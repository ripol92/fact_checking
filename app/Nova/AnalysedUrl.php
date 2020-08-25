<?php

namespace App\Nova;

use App\Nova\Actions\AddAndAnalyseUrl;
use App\Nova\Actions\AnalyzeUrls;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;

class AnalysedUrl extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AnalysedUrl::class;

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
        'url'
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
            ID::make("id")->exceptOnForms()->hideFromIndex(),

            Text::make("Url", function (\App\Models\AnalysedUrl $model) {
                $url = $model->url;
                return "<a href=\"$url\" target=\"_blank\">$url</a>";
            })->asHtml(),

            Text::make("Article", function (\App\Models\AnalysedUrl $model) {
                $article = $model->article;
                return strlen($article) > 80 ?
                    mb_substr($article, 0, 80) . "..."
                    : $article;
            })->exceptOnForms(),

            Code::make("Text Ru (plagiat urls)", "text_ru")
                ->language("javascript")
                ->exceptOnForms()->hideFromIndex(),

            Image::make("Images", function (\App\Models\AnalysedUrl $model) {
                $imageLinks = $model->image_links;
                return last($imageLinks);
            })->exceptOnForms(),

            HasMany::make("Image Check", "imageChecks", ImageCheck::class),
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
            (new AnalyzeUrls()),
            (new AddAndAnalyseUrl())
        ];
    }
}
