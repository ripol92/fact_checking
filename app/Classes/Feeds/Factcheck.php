<?php

namespace App\Classes\Feeds;

use Feed;
use Illuminate\Support\Facades\Log;

class Factcheck
{
    public function manipulate($link, $lang, $source)
    {
        $news = [];
        $now = now()->toDateTimeString();
        try {
            $rss = Feed::loadRss($link);
        } catch (\Exception $e) {

            // Здесь логируем ошибки
            Log::error($e->getMessage());
        }
        foreach ($rss->item as $item) {
            $firstFeed = reset($item->{"content:encoded"});
            $img = null;
            if($firstFeed) {
                $all = [];
                preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $firstFeed, $all);
                if (sizeof($all) > 0) {
                    $img = reset($all);
                }
            } else {
                try {
                    $img = (string)$item->enclosure->attributes()["url"];
                } catch (\Exception $e) {
                }
            }
            if(!$img) {
                $all = [];
                preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $item->description, $all);
                if (sizeof($all) > 0) {
                    $img = reset($all);
                } else {
                    preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $item, $all);
                    if (sizeof($all) > 0) {
                        $img = reset($all);
                    }
                }
            }

            $news[] = [
                "title" => strip_tags($item->title),
                "description" => strip_tags($item->description),
                "link" => strip_tags($item->link),
                "date" => date("Y-m-d h:i:sa", strip_tags($item->timestamp)),
                "lang" => $lang,
                "html_encoded" => "no html encoded",
                "source" => $source,
                "img" => $img ?: 'no image',
                "created_at" => $now,
                "updated_at" => $now,
            ];
        }

        return $news;
    }
}
