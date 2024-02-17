<?php

namespace App\Providers;

use App\Helpers\ContainerHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ContainerHelper::registerServices($this->app);
        ContainerHelper::registerRepositories($this->app);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
