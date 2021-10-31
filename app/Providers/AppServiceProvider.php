<?php

namespace App\Providers;

use App\Configuration;
use Illuminate\Support\Facades\View;
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
    /*
    public function boot()
    {
        $connection = Configuration::orderBy('id', 'desc')->first();
        View::share('connection', $connection);
    }
    */
}
