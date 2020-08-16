<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReceiveTextRuResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const ANALYSED_URLS_TABLE_NAME = 'analysed_urls';

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
    public function __construct($analysedUrlId, $textRuUUid)
    {
        //
        $this->analysedUrlId = $analysedUrlId;
        $this->textRuUUid = $textRuUUid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = env("TEXT_RU_URL");
        $client = new Client(['base_uri' => $url]);
        $data = [
            'uid' => $this->textRuUUid,
            'userkey' => env("TEXT_RU_KEY")
        ];

        $response = $client->request('POST','',[
            "form_params" => $data
        ]);

        sleep(5);
        $textRuResponse = $response->getBody()->getContents();
        DB::table(self::ANALYSED_URLS_TABLE_NAME)
            ->where('id', $this->analysedUrlId)
            ->update(['text_ru' => json_encode($textRuResponse)]);
    }
}
