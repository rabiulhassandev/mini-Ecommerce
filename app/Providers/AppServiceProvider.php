<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(120);
        Paginator::useBootstrap();
    }


    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
