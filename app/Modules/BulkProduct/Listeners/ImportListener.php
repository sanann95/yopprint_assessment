<?php

namespace App\Modules\BulkProduct\Listeners;

use App\Modules\BulkProduct\Events\BulkProductCreatedEvent;
use App\Modules\BulkProduct\Jobs\ImportJob;

class ImportListener {
    public function handle(BulkProductCreatedEvent $event)
    {
        $bulkProduct = $event->getBulkProduct();

        dispatch(new ImportJob($bulkProduct));
    }
}