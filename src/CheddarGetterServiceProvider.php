<?php

namespace CheddarGetter;

use Illuminate\Support\ServiceProvider;

class CheddarGetterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $config = $app['services.cheddargetter'];
        $this->app->singleton('CG', function ($config) {
            return new Client($config['url'],
                $config['user'],
                $config['secret'],
                $config['product']);
        });
        //$this->app->alias('CG', 'Cheddargetter\Client');
    }
}
