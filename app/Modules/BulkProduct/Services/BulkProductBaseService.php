<?php

namespace App\Modules\BulkProduct\Services;

use App\Modules\BulkProduct\Models\BulkProduct;

abstract class BulkProductBaseService {
	protected $bulkProduct;
	/** @var BulkContributionService */
    protected $bulkProductService;

	public function __construct(BulkProduct $bulkProduct = null) {
		$this->bulkProduct = $bulkProduct;

		if($this instanceof BulkProductService) {
            $this->bulkProductService = $this;
        } else {
            $this->bulkProductService = app('bulk-product-service', compact('bulkProduct'));
        }
	}
}