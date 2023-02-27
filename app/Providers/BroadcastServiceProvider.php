<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        if (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], 'dashboard')) {
//            Broadcast::routes(['middleware' => ['web', 'auth:admin']]);
//        } else {
//            Broadcast::routes(['middleware' => ['web', 'auth']]);
//        }
        //Broadcast::routes(['middleware' => ['web', 'auth:admin']]);

        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
