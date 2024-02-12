<?php

use Illuminate\Support\Facades\Route;
use Modules\Slider\Http\Controllers\SlideController;

Route::group(["middleware" => ["auth"]], function ($router) {
    $router->resource("slides", SlideController::class);
});
