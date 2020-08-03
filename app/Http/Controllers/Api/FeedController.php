<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarkedItem;
use App\Models\UserMarkedItem;
use App\Services\RssFeedService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class FeedController extends Controller
{

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getNews(Request $request)
    {
//        $this->validate($request, [
//            "lang" => "required|in:ru,en,tj",
//            "limit" => "integer|nullable",
//        ]);

        $allRssFeedNews = RssFeedService::allRssFeedNews($request);

        return $allRssFeedNews;
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
}
