<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*\View::composer('threads.create', function ($view){
           $view->with('channels', \App\Models\Channel::all());
        });*/

        \View::composer(
            '*',
            function ($view) {
                $channels = \Cache::rememberForever(
                    'channels',
                    function () {
                        return Channel::all();
                    }
                );
                $view->with('channels', $channels);
            }
        );

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
