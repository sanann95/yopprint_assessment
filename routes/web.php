<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('', function() {
	return redirect()->route('bulk-uploads');
});
Route::get('bulk-upload', 'App\Http\Controllers\BulkUploadController@index')->name('bulk-uploads');
Route::post('bulk-upload', 'App\Http\Controllers\BulkUploadController@upload')->name('bulk-upload.create');
Route::get('/get-updated-files', 'App\Http\Controllers\BulkUploadController@getUpdatedFiles')->name('get-updated-files');