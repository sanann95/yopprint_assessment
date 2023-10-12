<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $fillable = [
		'unique_id', 
		'title',
		'description',
        'style',
        'sanmar_mainframe_color',
        'size',
        'color_name',
        'piece_price',
	];
}