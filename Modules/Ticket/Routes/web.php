<?php

use Illuminate\Support\Facades\Route;
use Modules\Ticket\Http\Controllers\TicketController;

Route::group(["middleware" => "auth"], function ($router) {
    $router->resource("tickets", "TicketController");
    $router->post("tickets/{ticket}/reply", [TicketController::class, "reply"])->name("tickets.reply");
    $router->get("tickets/{ticket}/close", [TicketController::class, "close"])->name("tickets.close");
});
