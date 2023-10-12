<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BulkUploadController extends Controller {
	public function index() {
		$models = app('bulk-product-service')->searchBuilder();

		return view('bulk-upload', compact('models'));
	}

	public function upload(Request $request) {
	 	$request->validate([
	        'file' => 'required|mimes:csv,txt',
	    ]);

	    $file = $request->file('file');

	    app('bulk-product-service')->create($request->all());

	    return redirect()->route('bulk-uploads');
	}

	public function getUpdatedFiles() {
	    $models = app('bulk-product-service')->searchBuilder();

	    return view('files', compact('models'));
	}
}