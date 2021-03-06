<?php


namespace App\Nova;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

/**
 * Class PersonalAccessToken
 * @package App\Nova
 * @property int $id
 * @property string $name
 * @property string $token
 * @property string|mixed abilities
 * @property Carbon $last_used_at
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class PersonalAccessToken extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PersonalAccessToken::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Secret', 'token')
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'min:16', 'max:80'),

            Select::make("Ability", "abilities")
                ->rules('required')
                ->hideFromIndex()
                ->options(\App\Models\PersonalAccessToken::allTokens()),

            MorphTo::make("User", "tokenable")
                ->types([
                    User::class,
                ]),

            DateTime::make("Last used at", 'last_used_at')
                ->sortable()
                ->exceptOnForms(),

            DateTime::make("Created at", 'created_at')
                ->sortable()
                ->exceptOnForms(),
        ];
    }
}
