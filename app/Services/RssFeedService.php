<?php

namespace App\Services;

use App\Classes\Feeds\AsiaPlus;
use App\Classes\Feeds\Factcheck;
use App\Classes\Feeds\Fergana;
use App\Classes\Feeds\Nm;
use App\Classes\Feeds\Standard;
use App\Classes\Feeds\XmlString;
use App\Models\RssFeedResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RssFeedService
{
    protected $resources = [
        'ozodi' => Standard::class,
        'central_asian' => Standard::class,
        'avesta' => Standard::class,
        'asia-plus' => AsiaPlus::class, //without desc, img
        'faraj' => Standard::class, //without img
        'sugdnews' => Standard::class,
//        'khovar' => XmlString::class, //custom
        'cm-1' => Standard::class, //without img
        'current_time' => Standard::class,
        'ussr' => Standard::class,
        'sputnik' => Standard::class,
        'khujand' => Standard::class,
        'sugd' => Standard::class,
        'president' => Standard::class, //without desc, img
        'pressa' => Standard::class, //without img
        'asia-times' => Standard::class,
        'orion' => Standard::class,
        'ittiloot' => Standard::class,
        'nm' => Nm::class, //without img
        'vecherka' => Standard::class, //without img
        'factcheck' => Factcheck::class, //html_encoded тяжёлый текст с кастомными стилями и js кодом, поэтому не беру
        'fergana' => XmlString::class, //custom
        'jumhuriyat' => XmlString::class, //custom
        'vkd' => XmlString::class, //custom
        'mfa' => XmlString::class, //custom
        'oila' => XmlString::class, //custom
        'tajikta' => XmlString::class, //custom
        'top' => XmlString::class, //custom
        'tajikistan_news' => XmlString::class, //custom
        'novosti_tajikistana' => XmlString::class, //custom
    ];

    public function allRssFeedNews()
    {
        $news = [];
        $rssFeedResources = RssFeedResource::with("language")->whereIn('name',
            array_keys($this->resources))->get();

        foreach ($rssFeedResources as $rssFeedResource) {
            try {
                $feeds = (new $this->resources[$rssFeedResource->name])
                    ->manipulate($rssFeedResource->link, $rssFeedResource->language->name, $rssFeedResource->display_name);
                $news = array_merge($news, $feeds);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                continue;
            }
        }
        DB::table("marked_items")->insertOrIgnore($news);
    }
}
