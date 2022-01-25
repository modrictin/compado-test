<?php

namespace App\Providers;

use App\Services\Factories\ApiProviderAdapterFactory;
use App\Services\Factories\IApiAdapterFactory;
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
        $this->app->bind(IApiAdapterFactory::class, function ($app) {
            return new ApiProviderAdapterFactory($app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
