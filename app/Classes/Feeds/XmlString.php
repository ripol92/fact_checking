<?php

namespace App\Classes\Feeds;

use Feed;
use Illuminate\Support\Facades\Log;

class XmlString
{
    public function manipulate($link, $lang, $source)
    {
        $news = [];
        $now = now()->toDateTimeString();
        try {
            $items = file_get_contents($link);
            $rss = simplexml_load_string($items);
        } catch (\Exception $e) {

            // Здесь логируем ошибки
            Log::error($e->getMessage());
        }

        foreach ($rss->entry as $item) {
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
                preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $item->content, $all);
                if (sizeof($all) > 0) {
                    $img = reset($all);
                } else {
                    preg_match("/(?:http|https|ftp):\/\/\S+\.(?:jpg|jpeg|png)/", $item, $all);
                    if (sizeof($all) > 0) {
                        $img = reset($all);
                    }
                }
            }
//            dd($item->link);
            $news[] = [
                "title" => strip_tags($item->title),
                "description" => strip_tags($item->content),
                "link" => (string)$item->link->attributes()["href"],
                "date" => $now,
                "lang" => $lang,
                "html_encoded" => $firstFeed ? $firstFeed : "no html encoded",
                "source" => $source,
                "img" => $img ?: 'no image',
                "created_at" => $now,
                "updated_at" => $now,
            ];
        }

        return $news;
    }
}
