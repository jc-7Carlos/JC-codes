<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LibroService;
use App\Services\PrestamoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LibroService::class, function ($app) {
            return new LibroService();
        });

        $this->app->singleton(PrestamoService::class, function ($app) {
            return new PrestamoService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
