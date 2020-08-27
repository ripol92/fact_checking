<?php

namespace App\Services;

use App\Models\Language;
use App\Models\RssFeedResource;
use Feed;
use Illuminate\Support\Facades\Log;

class RssFeedService {
    public static function allRssFeedNews($lang = null) {
        $news = [];

        $languages = $lang ? Language::where('name', $lang) : Language::all();
        $languages = $languages->pluck('id');
        $rssFeedResources = RssFeedResource::whereIn('language_id', $languages)->get();

        foreach ($rssFeedResources as $rssFeedResource) {
            try {
                $rss = Feed::loadRss($rssFeedResource->link);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                // Здесь можно логировать ошибки, если что
                continue;
            }
            foreach ($rss->item as $item) {
                $img = "";
                $firstFeed = reset($item->{'content:encoded'});
                if ($firstFeed) {
                    $all = [];
                    preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $firstFeed, $all);
                    if (sizeof($all) > 0) {
                        $img = reset($all);
                    }
                }
                $news[] = [
                    'title' => strip_tags($item->title),
                    'description' => strip_tags($item->description),
                    'link' => strip_tags($item->link),
                    'date' => date("Y-m-d h:i:sa", strip_tags($item->timestamp)),
                    'lang' => $rssFeedResource->language->name,
//                    'html_encoded' => $item->{'content:encoded'}
                    "img" => $img
                ];
            }
        }

        return $news;
    }
}
