<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function all(Request $request)
    {
        $this->validate($request, [
            "per_page" => "nullable|integer|min:1|max:500",
            "sorting_dir" => "nullable|string|in:DESC,ASC"
        ]);

        /**@var User $user */
        $user = $request->user();
        $perPage = $request->get("per_page", 20);
        $sortingDir = $request->get("sorting_dir", "DESC");

        $selectClause = [
            "fn.id",
            "fn.title",
            "fn.text",
            "fact_check_url",
            "fn.created_at",
            "marked_items.id as news_id",
            "marked_items.date as news_date",
            "marked_items.title as news_title",
            "link as news_link",
        ];

        $notifications = DB::table("firebase_notifications", "fn")
            ->leftJoin("marked_items", "marked_items.id", "=", "fn.marked_item_id")
            ->where("fn.user_id", "=", $user->id)
            ->orderBy("fn.created_at", $sortingDir)
            ->select($selectClause)
            ->simplePaginate($perPage);

        return response()->json($notifications, 200);
    }
}
