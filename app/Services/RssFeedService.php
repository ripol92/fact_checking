<?php

namespace App\Services;

use App\Models\RssFeedResource;
use Feed;

class RssFeedService
{
    public static function allRssFeedNews($attributes)
    {
        $news = [];
        $rssFeedResources = RssFeedResource::all();

        foreach ($rssFeedResources as $rssFeedResource) {
            try {
                $rss = Feed::loadRss($rssFeedResource->link);
            } catch (\Exception $e) {
                continue;
//                return response()->json(["message" => $e->getMessage()], $e->getCode());
            }
            foreach ($rss->item as $item) {
                $news[] = [
                    'title' => strip_tags($item->title),
                    'description' => strip_tags($item->description),
                    'link' => strip_tags($item->link),
                    'date' => date("Y-m-d h:i:sa", strip_tags($item->timestamp)),
                    'lang' => $rssFeedResource->language->name,
//                'html_encoded' => $item->{'content:encoded'}
                ];
            }
        }

        return compact('news');
    }
}
