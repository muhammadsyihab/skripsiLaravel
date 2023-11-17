<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // config(['app.locale' => 'id']);
	    Carbon::setLocale('id');

        Blade::if('ho', function () {
            return auth()->user() && auth()->user()->role == 0;
        });

        Blade::if('planner', function () {
            return auth()->user() && auth()->user()->role == 1;
        });

        Blade::if('logistik', function () {
            return auth()->user() && auth()->user()->role == 2;
        });

        Blade::if('mekanik', function () {
            return auth()->user() && auth()->user()->role == 3;
        });

        Blade::if('operator', function () {
            return auth()->user() && auth()->user()->role == 4;
        });

        Blade::if('production', function () {
            return auth()->user() && auth()->user()->role == 5;
        });

        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });
    }
}
