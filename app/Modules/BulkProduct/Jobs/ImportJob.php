<?php

namespace App\Modules\BulkProduct\Jobs;

use App\Modules\BulkProduct\Models\BulkProduct;
use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportJob extends Job implements ShouldQueue
{
    use DispatchesJobs;
    use InteractsWithQueue, SerializesModels;

    public $queue = 'bulk-product-import';

    protected $bulkProduct;

    public function __construct(BulkProduct $bulkProduct) {
        $this->bulkProduct = $bulkProduct;
    }

    public function handle(){
        app('bulk-product-import-service', [
            'bulkProduct' => $this->bulkProduct,
        ])->importFile();
    }
}
