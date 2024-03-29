<?php

use Illuminate\Support\Facades\Route;
use Modules\Common\Http\Controllers\NotificationController;

Route::group(["middleware" => ["auth"]], function (Illuminate\Routing\Router $router) {
    $router->get("/notifications/mark-as-read", [NotificationController::class, "markAllAsRead"])
           ->name("notifications.markAllAsRead");
});
