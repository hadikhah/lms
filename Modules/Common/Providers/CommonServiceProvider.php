<?php


namespace Modules\Common\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private string $namespace = "Modules\Common\Http\Controllers";

    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . "/../Resources", "Common");
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(__DIR__ . '/../Routes/routes.php');
    }

    public function boot(): void
    {
        //  loads --unread notifications-- to views of the Common Module
        view()->composer("Dashboard::layout.header", function ($view) {
            $notifications = auth()->user()->unreadNotifications;
            return $view->with(compact("notifications"));
        });
    }
}
