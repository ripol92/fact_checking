<?php

namespace App\Nova\Filters;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Filters\Filter;

class UsersMarkedItems extends Filter
{
    /**
     * @var string
     */
    private $tableName;
    /**
     * @var string
     */
    private $filterDisplayName;

    /**
     * UsersMarkedItems constructor.
     * @param $tableName
     * @param $filterDisplayName
     */
    public function __construct($tableName, $filterDisplayName)
    {
        $this->tableName = $tableName;
        $this->filterDisplayName = $filterDisplayName;
    }

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * @return string
     */
    public function name()
    {
        return $this->filterDisplayName;
    }

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $articleIds = DB::table($this->tableName)
            ->where("user_id", $value)
            ->select("marked_item_id")
            ->pluck("marked_item_id")
            ->toArray();

        return $query->whereIn("id", $articleIds);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return Cache::remember("users_id_names", now()->addMinute(), function () {
            // hell, this is gonna slow down app when users amount goes beyond some N
            // refactor it to some "scout-type search" or "dynamic user load"
            return User::all()->pluck("id", "name")->toArray();
        });
    }
}
