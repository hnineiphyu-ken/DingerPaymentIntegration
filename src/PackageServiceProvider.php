<?php

namespace KenNebula\DingerPaymentIntegration;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use KenNebula\DingerPaymentIntegration\Dinger;

class PackageServiceProvider extends ServiceProvider
{
    public function register() : void 
    {
        // Bind the Dinger class to the service container
        $this->app->singleton(Dinger::class, function($app) {
            return new Dinger();
        });
    }

    public function boot() : void 
    {
        if ($this->app->runningInConsole()) {
            // Example: Publishing configuration file
            $this->publishes([
              __DIR__.'/config/config.php' => config_path('dinger.php'),
          ], 'config');
        
          }
    }

}