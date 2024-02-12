<?php

use Illuminate\Support\Facades\Route;
use Modules\RolePermissions\Http\Controllers\RolePermissionsController;

Route::group(["namespace" => "Modules\RolePermissions\Http\Controllers", 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('role-permissions', RolePermissionsController::class)->middleware('permission:manage role_permissions');
});
