<?php

namespace App\Providers;

use App\Events\ArticleParsed;
use App\Listeners\ArticleParsedFalDetectorListener;
use App\Listeners\SendTextRuRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ArticleParsed::class => [
            SendTextRuRequest::class,
            ArticleParsedFalDetectorListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
