<?php

namespace App\Services;

use App\Models\Language;
use App\Models\RssFeedResource;
use Feed;
use Illuminate\Support\Facades\Log;

class RssFeedService {

    public static function allRssFeedNews($lang = null, $sources=[]) {
        $news = [];
        $languages = $lang ? Language::where('name', $lang) : Language::all();
        $languages = $languages->pluck('id');
        $rssFeedResources = count($sources)>0 ? $sources : RssFeedResource::whereIn('language_id', $languages)->get();

        foreach ($rssFeedResources as $rssFeedResource) {
            try {
                $rss = Feed::loadRss(isset($rssFeedResource->link) ? $rssFeedResource->link : $rssFeedResource);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                // Здесь можно логировать ошибки, если что
                continue;
            }
            foreach ($rss->item as $item) {
                $img = "no image";
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
                    'lang' => isset($rssFeedResource->language) ? $rssFeedResource->language->name : $lang,
//                    'html_encoded' => $item->{'content:encoded'}
                    "img" => $img
                ];
            }
        }

        return $news;
    }
}
