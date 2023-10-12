<?php

namespace App\Modules\BulkProduct\Events;

use App\Modules\BulkProduct\Models\BulkProduct;

abstract class Event extends \App\Events\Event
{
	protected $bulkProduct;

	public function __construct(BulkProduct $bulkProduct) {
        $this->bulkProduct = $bulkProduct;
    }

    /**
     * @return BulkProduct
     */
    public function getBulkProduct() {
        return $this->bulkProduct;
    }
}
