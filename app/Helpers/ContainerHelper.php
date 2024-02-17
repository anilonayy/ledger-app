<?php

namespace App\Helpers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class ContainerHelper
{
    /**
     * @param Application $app
     * @return void
     */
    public static function registerServices(Application $app): void
    {
        $serviceFolders = glob(app_path('Services/*'));

        foreach ($serviceFolders as $serviceFolder) {
            $serviceName = basename($serviceFolder);

            $app->bind(
                "App\Services\\{$serviceName}\\{$serviceName}ServiceInterface",
                "App\Services\\{$serviceName}\\{$serviceName}Service",
            );
        }
    }

    /**
     * @param Application $app
     * @return void
     */
    public static function registerRepositories(Application $app): void
    {
        $serviceFolders = glob(app_path('Repositories/*'));

        foreach ($serviceFolders as $serviceFolder) {
            $serviceName = basename($serviceFolder);

            $app->bind(
                "App\Repositories\\{$serviceName}\\{$serviceName}RepositoryInterface",
                "App\Repositories\\{$serviceName}\\{$serviceName}Repository",
            );
        }
    }
}
