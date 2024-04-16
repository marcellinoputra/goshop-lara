<?php

namespace App\Providers;

use App\Interfaces\LocationInterfaces;
use App\Interfaces\ProductInterfaces;
use App\Repositories\LocationRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterfaces::class, ProductRepository::class);
        $this->app->bind(LocationInterfaces::class, LocationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
