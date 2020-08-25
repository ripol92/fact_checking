<?php

namespace App\Providers;

use App\Models\AnalysedUrl;
use App\Models\ImageCheck;
use App\Models\MarkedItem;
use App\Policies\AnalyseUrlPolicy;
use App\Policies\ImageCheckPolicy;
use App\Policies\NewsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ImageCheck::class => ImageCheckPolicy::class,
        AnalysedUrl::class => AnalyseUrlPolicy::class,
        MarkedItem::class => NewsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
