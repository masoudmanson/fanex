<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Essentials\Adapter;

class SSOServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Adapter::class, function () {

            return new Adapter(config('services.sso.id'), config('services.sso.secret'));

        });
    }
}
