<?php

namespace App\Modules\BulkProduct\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Modules\BulkProduct\Events\BulkProductCreatedEvent' => [
            'App\Modules\BulkProduct\Listeners\ImportListener',
        ],
    ];
}
