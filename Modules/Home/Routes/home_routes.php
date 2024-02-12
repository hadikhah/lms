<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;

Route::group(['middleware' => ['web'], 'namespace' => 'Modules\Home\Http\Controllers'],
    function ($router) {
        $router->get('/', [HomeController::class, "index"]);
        $router->get('/c-{slug}', [HomeController::class, "singleCourse"])->name('singleCourse');
        $router->get('/tutors/{user}', [HomeController::class, "singleTutor"])->name('singleTutor');
    });
