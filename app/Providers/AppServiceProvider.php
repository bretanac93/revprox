<?php

namespace App\Providers;

use App\NginxRoute;
use App\Observers\NginxRouteObserver;
use App\Observers\ReverseProxyObserver;
use App\ReverseProxy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        NginxRoute::observe(NginxRouteObserver::class);
        ReverseProxy::observe(ReverseProxyObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
