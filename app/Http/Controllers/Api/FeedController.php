<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarkedItem;
use App\Models\UserAnalyzedItem;
use App\Models\UserMarkedItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    CONST FACT_CHECK_SOURCE_NAME = 'FactCheckTj';

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\Paginator
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getNews(Request $request)
    {
        $this->validate($request, [
            "lang" => "string|nullable",
            "per_page" => "integer|nullable",
        ]);

        $language =  $request->get("lang") ? $request->get("lang") : "ru";
        $perPage =  $request->get("per_page") ? $request->get("per_page") : 50;

        $news = DB::table('marked_items')->where('source', '!=',self::FACT_CHECK_SOURCE_NAME)
            ->where('lang', $language)->orderBy('date','desc')
            ->simplePaginate($perPage);

        return $news;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getFactCheckTjNews(Request $request)
    {
        $language =  $request->get("lang") ? $request->get("lang") : "ru";
        $perPage =  $request->get("per_page") ? $request->get("per_page") : 40;

        $news = DB::table('marked_items')->where('source', self::FACT_CHECK_SOURCE_NAME)
            ->where('lang', $language)->orderBy('date','desc')
            ->simplePaginate($perPage);

        return $news;
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function likeItem(Request $request)
    {
        $this->validate($request, [
            "link" => "required|string",
            "title" => "required|string",
            "description" => "string|nullable",
            "date" => "date|required",
            "lang" => "required|string",
        ]);

        $requestData = $request->all();
        $requestData['date'] = Carbon::parse($request->date)->format('Y-m-d');

        $user = $request->user();

        $item = MarkedItem::where('link', $request->link)->first();

        if ($item) {
            $userMarkedItemExist = UserMarkedItem::where('user_id', $user->id)->where('marked_item_id', $item->id)->exists();
            if($userMarkedItemExist) {
                return response()->json([
                    'msg' => 'Like is already Exist',
                ], 409 );
            }
        }

        $markedItem = DB::transaction(function() use ($user, $requestData, $item) {
            $markedItem = $item ? $item : new MarkedItem($requestData);
            $markedItem->save();

            $userMarkedItem = new UserMarkedItem();
            $userMarkedItem->markedItem()->associate($markedItem);
            $userMarkedItem->user()->associate($user);
            $userMarkedItem->save();

            return $markedItem;
        });

        return response()->json([
                'item' => $markedItem->withCount('userMarkedItem')->get(),
                'msg' => 'Stored Successful'
            ], 200);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function dislikeItem(Request $request)
    {
        $this->validate($request, [
            "link" => "required|string"
        ]);

        $user = $request->user();

        $markedItem = MarkedItem::where('link', $request->link)->first();

        if (!$markedItem) {
            return response()->json([
                'msg' => 'The requested Item was not found'
            ], 404);
        }

        UserMarkedItem::where('marked_item_id', $markedItem->id)->where('user_id', $user->id)->delete();

        return response()->json([
            'msg' => 'Item deleted successful'
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserLikedNews(Request $request)
    {
        $user = $request->user();

        $markedNews = UserMarkedItem::with('markedItem')->where('user_id', $user->id)
            ->withCount('markedItem')->get();

        return $markedNews;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function analyzeItem(Request $request)
    {
        $this->validate($request, [
            "link" => "required|string",
            "title" => "required|string",
            "description" => "string|nullable",
            "date" => "date|required",
            "lang" => "required|string",
        ]);

        $requestData = $request->all();
        $requestData['date'] = Carbon::parse($request->date)->format('Y-m-d');

        $user = $request->user();

        $item = MarkedItem::where('link', $request->link)->first();

        if ($item) {
//            if($item->is_analyzed == true) {
//                return response()->json([
//                    'msg' => 'Item is already Analyzed',
//                ], 408 );
//            }
            $userMarkedItemExist = UserAnalyzedItem::where('user_id', 1)->where('marked_item_id', $item->id)->exists();
            if($userMarkedItemExist) {
                return response()->json([
                    'msg' => 'Record is already Exist',
                ], 409 );
            }
        }

        $markedItem = DB::transaction(function() use ($user, $requestData, $item) {
            $markedItem = $item ? $item : new MarkedItem($requestData);
            $markedItem->save();

            $userAnalyzedItem = new UserAnalyzedItem();
            $userAnalyzedItem->analyzedItem()->associate($markedItem);
            $userAnalyzedItem->user()->associate($user);
            $userAnalyzedItem->save();

            return $markedItem;
        });

        return response()->json([
            'item' => $markedItem->withCount('userAnalyzedItem')->get(),
            'msg' => 'Stored Successful'
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserAnalyzedNews(Request $request)
    {
        $user = $request->user();

        $analyzedItems = UserAnalyzedItem::with('analyzedItem')->where('user_id', $user->id)
            ->withCount('analyzedItem')->get();

        return $analyzedItems;
    }

}
