<?php

namespace MichelMelo\WhatsappNotify;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class WhatsappNotifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('whatsapp.php'),
            ], 'config');

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'whatsapp');

        // Register the main class to use with the facade
        $this->app->singleton(WhatsappNotify::class, function () {
            return new WhatsappNotify;
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('whatsapp', function () {
                return new WhatsappChannel();
            });
        });

    }
}
