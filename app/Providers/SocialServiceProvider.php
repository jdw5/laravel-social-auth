<?php

namespace App\Providers;

use App\Models\UserSocial;
use App\Observers\UserSocialObserver;
use Illuminate\Support\ServiceProvider;

class SocialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        UserSocial::observe(UserSocialObserver::class);
    }
}
