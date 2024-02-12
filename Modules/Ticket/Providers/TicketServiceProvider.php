<?php

namespace Modules\Ticket\Providers;

use Modules\Ticket\Models\Reply;
use Modules\Ticket\Models\Ticket;
use Modules\Ticket\Policies\ReplyPolicy;
use Modules\Ticket\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{

    /**
     * @var string
     */
    public string $namespace = "Modules\Ticket\Http\Controllers";

    /**
     * @return void
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Tickets");
        $this->loadMigrationsFrom(__DIR__ . "/../Database/Migrations");
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(__DIR__ . '/../Routes/web.php');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(Reply::class, ReplyPolicy::class);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        config()->set('sidebar.items.tickets', [
            "icon"  => "i-tickets",
            "title" => "تیکت های پشتیبانی",
            "url"   => route('tickets.index'),
        ]);
    }
}
