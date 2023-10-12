<?php
namespace App\Modules\Product\Services;

use App\Modules\Product\Models\Product;

class ProductsService {
	public function create(array $data) {
		return Product::create($data);
	}

	public function findByUniqueID($uniqueID = null) {
		return Product::whereUniqueId($uniqueID)->first();
	}
}