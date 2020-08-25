<?php


namespace App\FactChecking\Services;


use App\Models\AnalysedUrl;
use Exception;
use Illuminate\Support\Facades\Redis;

class SendUrlToParser {
    /**
     * @param string $url
     * @param string $lng
     * @throws Exception
     */
    public function send(string $url, string $lng = "ru") {
        $this->checkUrlResultExistence($url);

        Redis::publish('urls_for_parse', json_encode([
            'url' => $url,
            'lng' => $lng
        ]));
    }

    /**
     * @param string $url
     * @throws Exception
     */
    private function checkUrlResultExistence(string $url) {
        $exist = AnalysedUrl::query()->where('url', $url)->exists();

        if ($exist) {
            throw new Exception("Url $url already added");
        }
    }
}
