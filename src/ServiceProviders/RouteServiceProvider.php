<?php

namespace LaraDevs\AuthRemote\ServiceProviders;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as IlluminateRouteServiceProvider;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends IlluminateRouteServiceProvider
{
    protected $namespace='\LaraDevs\AuthRemote';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }


    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../../routes/web.php');
    }
}