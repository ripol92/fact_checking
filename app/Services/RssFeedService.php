<?php

namespace App\Services;

use App\Models\Language;
use App\Models\RssFeedResource;
use Feed;

class RssFeedService
{
    public static function allRssFeedNews($attributes)
    {
        $news = [];

        $languages = $attributes->lang ? Language::where('name', $attributes->lang) : Language::all();
        $languages = $languages->pluck('id');
        $rssFeedResources = RssFeedResource::whereIn('language_id', $languages)->get();

        foreach ($rssFeedResources as $rssFeedResource) {
            try {
                $rss = Feed::loadRss($rssFeedResource->link);
            } catch (\Exception $e) {
                // Здесь можно логировать ошибки, если что
                continue;
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
