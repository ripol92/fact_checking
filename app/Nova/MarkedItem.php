<?php

namespace App\Nova;

use App\Nova\Actions\AnalyzeUrls;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

/**
 * @property int $id
 * @property string $link
 * @property string $lang
 * @property string $description
 * @property string $title
 * @property Carbon|string $date
 * @property boolean $is_analyzed
 * @property Carbon|string $updated_at
 * @property Carbon|string $created_at
 * @property string|mixed $html_encoded
 * @property string|null $source
 * @property string $img
 * @property string|null $fact_check_url
 * @property \App\User[]|null $users
 * @property \App\User[]|null $analyzedUsers
 * @property \App\Models\AnalysedUrl|null $analyzedResult
 */
class MarkedItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MarkedItem::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = "id";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        "id", "title", "description"
    ];

    public static $with = [
        "analyzedResult", "users", "analyzedUsers"
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
            ID::make()->sortable(),

            Text::make("Title")->sortable()->hideFromIndex(),

            Text::make("Description")->sortable()->hideFromIndex(),

            Text::make("Image")->sortable()->hideFromIndex(),

            Text::make("Source")->sortable()->hideFromIndex(),

            Text::make("Html Encoded")->sortable()->hideFromIndex(),

            Text::make("FactCheck Url", "fact_check_url")->sortable()->hideFromIndex(),

            Text::make("Link")->sortable(),

            Text::make("Language", "lang")->sortable(),

            Date::make("Date")->sortable(),

            Boolean::make("Is Analyzed")->sortable(),

            HasOne::make("Analysed Result", "analyzedResult", AnalysedUrl::class),

            HasMany::make("Favorites", "users", User::class),

            HasMany::make("Analyses", "analyzedUsers", User::class),

            Boolean::make("For Analyze", function () {
                return count($this->analyzedUsers) > 0;
            }),

            DateTime::make("Created At")
                ->hideFromIndex()
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
            })
        ];
    }
}
