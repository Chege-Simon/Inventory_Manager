<?php

namespace App\Providers;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
//use NascentAfrica\Jetstrap\JetstrapFacade;
use NascentAfrica\Jetstrap\src\Jetstrap\Console\JetstrapFacade;

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
        JetstrapFacade::useCoreUi3();
        Paginator::useBootstrap();
    }
}
