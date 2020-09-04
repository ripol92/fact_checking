<?php

namespace App\Services;

use App\Models\RssFeedResource;
use Feed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RssFeedService {

    public static function allRssFeedNews() {

        $news = [];
        $rssFeedResources = RssFeedResource::with("language")->get();

        foreach ($rssFeedResources as $rssFeedResource) {

            try {
                $rss = Feed::loadRss($rssFeedResource->link);
            } catch (\Exception $e) {
                // Здесь логируем ошибки
                Log::error($e->getMessage());
                continue;
            }
            foreach ($rss->item as $item) {
                $img = "no image";
                $firstFeed = reset($item->{"content:encoded"});
                if ($firstFeed) {
                    $all = [];
                    preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $firstFeed, $all);
                    if (sizeof($all) > 0) {
                        $img = reset($all);
                    }
                }
                $news[] = [
                    "title" => strip_tags($item->title),
                    "description" => strip_tags($item->description),
                    "link" => strip_tags($item->link),
                    "date" => date("Y-m-d h:i:sa", strip_tags($item->timestamp)),
                    "lang" => $rssFeedResource->language->name,
                    "html_encoded" => $firstFeed,
                    "source" => $rssFeedResource->display_name,
                    "img" => $img,
                ];
            }
        }

        DB::table("marked_items")->insertOrIgnore($news);

        $news = DB::table("marked_items");
        return $news;
    }
}
