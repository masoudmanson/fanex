<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 8/9/17
 * Time: 1:21 PM
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Need to override the default validator with our own validator
        // We can do that by using the resolver function
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages)
        {
            // This class will hold all our custom validations
            return new CustomValidation($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}