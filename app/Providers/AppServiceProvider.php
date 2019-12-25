<?php

namespace App\Providers;

use App\Utils\TimeTraveler;
use App\Utils\TimeTravelerInterface;
use App\Utils\TimeTravelerNull;
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
        if ((env('APP_ENV') === 'local' || env('APP_ENV') === 'testing')
            && env('APP_DEBUG')
        ) {
            $this->app->singleton(TimeTravelerInterface::class, TimeTraveler::class);
        } else {
            $this->app->singleton(TimeTravelerInterface::class, TimeTravelerNull::class);
        }
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
