<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouteHelper
{

    /**
     * @return void
     */
    public static function registerApiRoutes(): void
    {
        foreach(glob(base_path('routes/api/*.php')) as $route) {
            $route = basename($route);

            Route::middleware('api')
                ->namespace('App\Http\Controllers')
                ->prefix('api')
                ->group(base_path("routes/api/{$route}"));
        }

    }
}
