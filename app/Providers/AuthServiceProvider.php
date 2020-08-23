<?php

namespace App\Providers;

use App\AnalysedUrl;
use App\Models\ImageCheck;
use App\Policies\AnalyseUrlPolicy;
use App\Policies\ImageCheckPolicy;
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
        AnalysedUrl::class => AnalyseUrlPolicy::class
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
