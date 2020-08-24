<?php

namespace App\FactChecking\Services\TextRu;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReceiveTextRuResponseJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    const ANALYSED_URLS_TABLE_NAME = 'analysed_urls';
    public $tries = 3;
    public $retryAfter = 3;
    /**
     * @var string
     */
    private $analysedUrlId;
    private $textRuUUid;

    /**
     * Create a new job instance.
     *
     * @param string $analysedUrlId
     * @param $textRuUUid
     */
    public function __construct($analysedUrlId, $textRuUUid) {
        //
        $this->analysedUrlId = $analysedUrlId;
        $this->textRuUUid = $textRuUUid;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle() {
        sleep(env('TEXT_RU_PENDING_SLEEP', 10));
        $url = env("TEXT_RU_URL");
        $data = [
            'uid' => $this->textRuUUid,
            'userkey' => env("TEXT_RU_KEY")
        ];

        $response = Http::asForm()->post($url, $data);

        $respBody = $response->body();
        $responseObject = json_decode($respBody);
        if (isset($responseObject->error_code)) {
            throw new Exception(isset($responseObject->error_desc) ? $responseObject->error_desc : "Error with receiving text ru response");
        }

        $resCheck = json_decode($respBody, true);
        DB::table(self::ANALYSED_URLS_TABLE_NAME)
            ->where('id', $this->analysedUrlId)
            ->update(['text_ru' => $resCheck["result_json"]]);
    }
}
