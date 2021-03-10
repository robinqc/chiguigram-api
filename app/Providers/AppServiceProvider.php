<?php

namespace App\Providers;

use \App\Models\Like;
use App\Observers\LikesObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Like::observe(LikesObserver::class);
    }
}
