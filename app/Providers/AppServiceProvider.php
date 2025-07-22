<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS di production ATAU jika ada FORCE_HTTPS=true
        if ($this->app->environment('production') || config('app.force_https')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
        
        // Khusus untuk Vercel deployment
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
        
        Schema::defaultStringLength(191);

        Livewire::setScriptRoute(function ( $handle ) {
            return Route::get('/livewire/live-wire-js', $handle);
        });
    }
}
