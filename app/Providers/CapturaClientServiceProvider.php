<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CapturaClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Captura\Estoque', function ($app) {
            return new \GuzzleHttp\Client([
                'base_uri' => $app->make('config')->get('app.captura.url')
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
