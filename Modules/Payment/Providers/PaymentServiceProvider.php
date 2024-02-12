<?php

namespace Modules\Payment\Providers;

use Modules\Payment\Gateways\Gateway;
use Modules\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Modules\Payment\Models\Settlement;
use Modules\Payment\Policies\SettlementPolicy;
use Modules\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public string $namespace = "Modules\Payment\Http\Controllers";

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadMigrationsFrom(base_path("Modules/Payment/Database/Migrations"));
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/payment_routes.php");
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/settlement_routes.php");
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Payment");
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        \Gate::policy(Settlement::class, SettlementPolicy::class);
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();
        });

        config()->set('sidebar.items.payments', [
            "icon" => "i-transactions",
            "title" => "تراکنش ها",
            "url" => route('payments.index'),
            "permission" => [
                Permission::PERMISSION_MANAGE_COURSES,
            ]
        ]);

        config()->set('sidebar.items.my-purchases', [
            "icon" => "i-my__purchases",
            "title" => "خریدهای من",
            "url" => route('purchases.index'),
        ]);

        config()->set('sidebar.items.settlements', [
            "icon" => "i-checkouts",
            "title" => " تسویه حساب ها",
            "url" => route('settlements.index'),
            "permission" => [
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_SETTLEMENTS
            ]
        ]);
        config()->set('sidebar.items.settlementsRequest', [
            "icon" => "i-checkout__request",
            "title" => "درخواست تسویه",
            "url" => route('settlements.create'),
            "permission" => [
                Permission::PERMISSION_TEACH,
            ]
        ]);
    }
}
