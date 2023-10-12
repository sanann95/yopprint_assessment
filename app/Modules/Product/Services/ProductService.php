<?php
namespace App\Modules\Product\Services;

use App\Modules\Product\Models\Product;

class ProductService {
	public $product;

	public function __construct(Product $product) {
		$this->product = $product;
	}

	public function update(array $data) {
		return $this->product->update($data);
	}
}