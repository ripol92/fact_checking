<?php

use Illuminate\Database\Seeder;

class RssFeedResourceSeeder extends Seeder
{
    CONST ENGLISH_LANGUAGE_ID = 1;
    CONST TAJIK_LANGUAGE_ID = 2;
    CONST RUSSIAN_LANGUAGE_ID = 3;

    CONST FEEDBURNER_RSS_FEED_TYPE_ID = 1;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'ozodi',
                'display_name' => 'Радио Озоди',
                'link' => 'http://feeds.feedburner.com/radioozodirss',
                'order' => 1,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'central_asian',
                'display_name' => 'Служба Новостей Центральной Азии',
                'link' => 'http://feeds.feedburner.com/CentralAsianTJ',
                'order' => 1,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'avesta',
                'display_name' => 'Avesta',
                'link' => 'http://feeds.feedburner.com/avesta/CtfQ',
                'order' => 1,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ]
        ];

        \App\Models\RssFeedResource::insert($data);
    }
}
