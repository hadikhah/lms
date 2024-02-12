<?php

namespace Modules\Home\Providers;

use Modules\Category\Repositories\CategoryRepo;
use Modules\Course\Repositories\CourseRepo;
use Modules\Slider\Repositories\SlideRepo;
use Illuminate\Support\ServiceProvider;

class HomeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // load home routes
        $this->loadRoutesFrom(__DIR__ . "/../Routes/home_routes.php");
        // load home views
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Home");

        view()->composer('Home::layout.header', function ($view) {
            $categories = (new CategoryRepo())->tree();
            $view->with(compact('categories'));
        });

        view()->composer('Home::layout.latestCourses', function ($view) {
            $latestCourses = (new CourseRepo())->latestCourses();
            $view->with(compact('latestCourses'));
        });

        view()->composer('Home::layout.slider', function ($view) {
            $slides = (new SlideRepo())->all();
            $view->with(compact('slides'));
        });


    }
}
