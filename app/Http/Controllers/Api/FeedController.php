<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{

    public function getNews(Request $request)
    {
        $this->validate($request, [
            "lang" => "required|in:ru,en,tj",
            "pagination" => "numeric",
        ]);
        $news = [];
        try {
            $rss = Feed::loadRss("http://feeds.feedburner.com/avesta/CtfQ");
        } catch (\FeedException $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());

        }

        foreach ($rss->item as $item) {
            $news[] = [
                'title' => strip_tags($item->title),
                'description' => strip_tags($item->description),
                'link' => strip_tags($item->link),
                'date' => date("Y-m-d h:i:sa", strip_tags($item->timestamp)),
//                'html_encoded' => $item->{'content:encoded'}
            ];

        }
        return $news;
    }
}
