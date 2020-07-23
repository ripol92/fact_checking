<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RssFeedService;
use Illuminate\Http\Request;

class FeedController extends Controller
{

    public function getNews(Request $request)
    {
        $this->validate($request, [
            "lang" => "required|in:ru,en,tj",
            "pagination" => "numeric",
        ]);

        $allRssFeedNews = RssFeedService::allRssFeedNews($request);

        return $allRssFeedNews;
    }
}
