<?php

namespace App\Jobs;

use App\Services\RssFeedService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GetFeedNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cache::remember('ru-news', now()->addMinutes(10), function () {
            return RssFeedService::allRssFeedNews('ru');
        });
        Cache::remember('tg-news', now()->addMinutes(10), function () {
            return RssFeedService::allRssFeedNews('tg');
        });
        Cache::remember('en-news', now()->addMinutes(10), function () {
            return RssFeedService::allRssFeedNews('en');
        });
        Cache::remember('factcheck-tg-news', now()->addMinutes(10), function () {
            return RssFeedService::allRssFeedNews('tg', ['factcheck.tj/feed']);
        });
        Cache::remember('factcheck-ru-news', now()->addMinutes(10), function () {
            return RssFeedService::allRssFeedNews('ru', ['factcheck.tj/ru/feed']);
        });
    }
}
