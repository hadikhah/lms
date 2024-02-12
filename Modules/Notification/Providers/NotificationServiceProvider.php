<?php

namespace Modules\Notification\Providers;


use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

    }

    public function boot()
    {

    }
}
