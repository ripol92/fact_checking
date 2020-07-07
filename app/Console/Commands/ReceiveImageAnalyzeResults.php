<?php

namespace App\Console\Commands;

use App\Models\ImageCheck;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ReceiveImageAnalyzeResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:receive-image-analyze-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receives from FALdetector analyze results';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::subscribe("resp", function ($message) {
            $resp = json_decode($message, true);
            $identifier = $resp["identifier"];
            $msg = $resp["message"];

            /**
             * @var ImageCheck $imgCheck
             */
            $imgCheck = ImageCheck::with([])->where("identifier", $identifier)->first();
            if (is_null($imgCheck)) {
                Log::error("no such identifier-uuid($identifier) in image_checks table");
                return;
            }
            $imgCheck->message = $msg;
            $imgCheck->save();
        });
    }
}
