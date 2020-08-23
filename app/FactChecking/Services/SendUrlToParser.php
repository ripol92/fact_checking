<?php


namespace App\FactChecking\Services;


use Illuminate\Support\Facades\Redis;

class SendUrlToParser {
    public function send(string $url, string $lng = "ru") {
        Redis::publish('urls_for_parse', json_encode([
            'url' => $url,
            'lng' => $lng
        ]));
    }
}
