<?php

namespace Rotha\PhoneCatalog;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rotha\PhoneCatalog\Http\Livewire\PhoneCatalog;

class PhoneCatalogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        // Load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'phone-catalog');
        
        // Register Livewire components
        Livewire::component('phone-catalog', PhoneCatalog::class);
        
        // Publish assets
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/phone-catalog'),
        ], 'views');
        
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register package services here
    }
}