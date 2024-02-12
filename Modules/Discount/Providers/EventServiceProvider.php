<?php

namespace Modules\Discount\Providers;

use Modules\Discount\Listeners\UpdateUsedDiscountsForPayment;
use Modules\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            UpdateUsedDiscountsForPayment::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
