<?php

namespace App\Console\Commands;

use App\Jobs\GetFeedNewsJob;
use Illuminate\Console\Command;

class GetFeedNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed_news:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'вызывает Job GetFeedNewsJob';

    /**
     * Create a new command instance.
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
        GetFeedNewsJob::dispatch();
    }
}
