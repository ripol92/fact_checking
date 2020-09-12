<?php

namespace App\Nova;

use App\FactChecking\Helpers\JSONToHtmlTable;
use App\Nova\Actions\AddAndAnalyseUrl;
use App\Nova\Actions\AnalyzeUrls;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;

/**
 * @property string $id
 * @property string $url
 * @property string $article
 * @property string|mixed $text_ru json
 * @property string[] $image_links
 * @property string $lng
 * @property string|mixed $adjectives_analyse json
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 **/
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
    public static $title = 'url';

    /**
     * @var string
     */
    public static $defaultSortField = "created_at";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'url', 'article'
    ];

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        "imageChecks",
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

            Text::make("Url", function () {
                $url = $this->url;
                return "<a href=\"$url\" target=\"_blank\">$url</a>";
            })->asHtml(),

            Text::make("Article", function () {
                $article = $this->article;
                return strlen($article) > 80 ?
                    mb_substr($article, 0, 80) . "..."
                    : $article;
            })->exceptOnForms(),

            Text::make("Text Ru (plagiat urls)", function (\App\Models\AnalysedUrl $model) {
                $textRuResponse = $model->text_ru;
                try {
                    $htmlTable = (new JSONToHtmlTable())->jsonToTable(json_decode($textRuResponse));
                } catch (Exception $e) {
                    $htmlTable = $model->text_ru;
                }
                return $htmlTable;
            })->onlyOnDetail()->asHtml(),

            Text::make("Adjectives analyse", function (\App\Models\AnalysedUrl $model) {
                $adjectivesAnalyse = $model->adjectives_analyse;
                try {
                    $htmlTable = (new JSONToHtmlTable())->jsonToTable($adjectivesAnalyse);
                } catch (Exception $exception) {
                    $htmlTable = $model->adjectives_analyse;
                }
                return $htmlTable;
            })->onlyOnDetail()->asHtml(),

            Image::make("Images", function (\App\Models\AnalysedUrl $model) {
                $imageLinks = $model->image_links;
                return last($imageLinks);
            })->exceptOnForms(),

            HasMany::make("Image Check", "imageChecks", ImageCheck::class),

            DateTime::make("Created At", "created_at")->onlyOnDetail(),
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
            (new AnalyzeUrls())->canRun(function () {
                return true;
            })->withoutActionEvents(),
            (new AddAndAnalyseUrl())->canRun(function () {
                return true;
            })->withoutActionEvents(),
        ];
    }
}
