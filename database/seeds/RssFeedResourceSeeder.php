<?php

use Illuminate\Database\Seeder;

class RssFeedResourceSeeder extends Seeder
{
    CONST ENGLISH_LANGUAGE_ID = 1;
    CONST RUSSIAN_LANGUAGE_ID = 2;
    CONST TAJIK_LANGUAGE_ID = 3;
    CONST MIXED_LANGUAGE_ID = 4;

    CONST FEEDBURNER_RSS_FEED_TYPE_ID = 1;
    CONST SIMPLE_RSS_FEED_TYPE_ID = 2;
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
                'order' => 2,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'avesta',
                'display_name' => 'Full',
                'link' => 'http://feeds.feedburner.com/avesta/CtfQ',
                'order' => 3,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'asia-plus',
                'display_name' => 'Азия Плюс',
                'link' => 'http://feeds.feedburner.com/TajikistanNewsAsia-plus',
                'order' => 4,
                'language_id' => self::MIXED_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'faraj',
                'display_name' => 'Фараж',
                'link' => 'http://feeds.feedburner.com/faraj/gLRj',
                'order' => 5,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'sugdnews',
                'display_name' => 'SugdNews',
                'link' => 'http://feeds.feedburner.com/sugdnews/pOVA',
                'order' => 6,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'khovar',
                'display_name' => 'Ховар',
                'link' => 'http://feeds.feedburner.com/khovar/oHvG',
                'order' => 7,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'cm-1',
                'display_name' => 'ШТР "СМ-1"',
                'link' => 'http://feeds.feedburner.com/cm-1/tVRr',
                'order' => 8,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'current_time',
                'display_name' => 'Настоящее Время',
                'link' => 'http://feeds.feedburner.com/currenttime/HHsi',
                'order' => 9,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'ussr',
                'display_name' => 'СССР Мо Метавонем!',
                'link' => 'http://feeds.feedburner.com/cccp/cFIY',
                'order' => 10,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'sputnik',
                'display_name' => 'Sputnik',
                'link' => 'http://feeds.feedburner.com/SputnikTajikistanNewsToday',
                'order' => 11,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'khujand',
                'display_name' => 'Хуҷанд',
                'link' => 'http://feeds.feedburner.com/khujand/JWHN',
                'order' => 12,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'sugd',
                'display_name' => 'Мақомоти иҷроияи ҳокимияти давлатии вилояти Суғд',
                'link' => 'http://feeds.feedburner.com/sugd/qvgT',
                'order' => 13,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'president',
                'display_name' => 'Президенти Ҷумҳурии Тоҷикистон',
                'link' => 'http://feeds.feedburner.com/PresidentOfTajikistan',
                'order' => 14,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'pressa',
                'display_name' => 'Тоҷикистон',
                'link' => 'http://feeds.feedburner.com/Pressatj',
                'order' => 15,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'asia-times',
                'display_name' => 'The Asia Times',
                'link' => 'http://feeds.feedburner.com/TheAsiaTimesrss',
                'order' => 16,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'orion',
                'display_name' => 'Ориён',
                'link' => 'http://feeds.feedburner.com/orien/JHFQ',
                'order' => 17,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'ittiloot',
                'display_name' => 'Иттилоот',
                'link' => 'http://feeds.feedburner.com/ittiloot/VWow',
                'order' => 18,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'nm',
                'display_name' => 'Независимое мнение',
                'link' => 'http://feeds.feedburner.com/nm/Brfd',
                'order' => 19,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'fergana',
                'display_name' => 'Fergana Ru',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Siteferganaru',
                'order' => 20,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'jumhuriyat',
                'display_name' => 'Jumhuriyat',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Sitejumhuriyattj',
                'order' => 21,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'central_asian',
                'display_name' => 'Служба Новостей Центральной Азии',
                'link' => 'http://feeds.feedburner.com/CentralAsianTJru',
                'order' => 22,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'vkd',
                'display_name' => 'Vkd TJ',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Sitevkdtj',
                'order' => 23,
                'language_id' => self::MIXED_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'mfa',
                'display_name' => 'MFA TJ',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Sitemfatj',
                'order' => 24,
                'language_id' => self::MIXED_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'oila',
                'display_name' => 'Oila Tj',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Siteoilatj',
                'order' => 25,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'tajikta',
                'display_name' => 'Tajikta TJ',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Sitetajiktatj',
                'order' => 26,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'top',
                'display_name' => 'Top Tj',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-Sitetoptjcom',
                'order' => 27,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'current_time',
                'display_name' => 'Настоящее Время',
                'link' => 'http://feeds.feedburner.com/currenttime/Vgit',
                'order' => 28,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'current_time',
                'display_name' => 'Настоящее Время',
                'link' => 'http://feeds.feedburner.com/currenttime/cYjb',
                'order' => 29,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'tajikistan_news',
                'display_name' => 'Tajikistan News',
                'link' => 'http://feeds.feedburner.com/GoogleAlert-TajikistanNews',
                'order' => 30,
                'language_id' => self::ENGLISH_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'novosti_tajikistana',
                'display_name' => 'Новости Таджикистана',
                'link' => 'http://feeds.feedburner.com/google/AeEa',
                'order' => 31,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'vecherka',
                'display_name' => 'Вечёрка',
                'link' => 'http://feeds.feedburner.com/vecherka/WTlj',
                'order' => 32,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::FEEDBURNER_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'factcheck',
                'display_name' => 'FactCheckTj',
                'link' => 'http://factcheck.tj/ru/feed',
                'order' => 33,
                'language_id' => self::RUSSIAN_LANGUAGE_ID,
                'rss_feed_type_id' => self::SIMPLE_RSS_FEED_TYPE_ID
            ],
            [
                'name' => 'factcheck',
                'display_name' => 'FactCheckTj',
                'link' => 'http://factcheck.tj/feed',
                'order' => 34,
                'language_id' => self::TAJIK_LANGUAGE_ID,
                'rss_feed_type_id' => self::SIMPLE_RSS_FEED_TYPE_ID
            ]

        ];

        \App\Models\RssFeedResource::insert($data);
    }
}
