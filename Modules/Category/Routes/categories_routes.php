<?php

Route::group(["namespace" => "Modules\Category\Http\Controllers", 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('categories', 'CategoryController');
});
