<?php


namespace App\Providers;


use App\Lib\Log;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        app()->configure('app');
        $this->app->bind('logger', function () {
            return new Log();
        });
    }
}
