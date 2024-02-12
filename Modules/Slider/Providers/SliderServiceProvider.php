<?php

namespace Modules\Slider\Providers;

use Modules\RolePermissions\Models\Permission;
use Modules\Slider\Models\Slide;
use Modules\Slider\Policies\SlidePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SliderServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private string $namespace = "Modules\Slider\Http\Controllers";

    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/slider_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'Slider');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(__DIR__ . "/../Routes/slider_routes.php");

        Gate::policy(Slide::class, SlidePolicy::class);
    }

    public function boot(): void
    {
        config()->set('sidebar.items.slider', [
            "icon"       => "i-courses",
            "title"      => __("slider"),
            "url"        => route('slides.index'),
            "permission" => [
                Permission::PERMISSION_MANAGE_SLIDES,
            ]
        ]);
    }
}
