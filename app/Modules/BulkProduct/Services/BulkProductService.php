<?php

namespace App\Modules\BulkProduct\Services;

use App\Modules\BulkProduct\Models\BulkProduct;
use Carbon\Carbon;

class BulkProductService extends BulkProductBaseService {
	public function create(array $data) {
		$uploadedFile = $this->handleFileUpload();
        if (!$uploadedFile) {
            return null;
        }

		return BulkProduct::create([
			'filename' => $uploadedFile['path'],
            'original_filename' => $uploadedFile['original_filename'] 
		]);
	}

	public function searchBuilder() {
		return BulkProduct::orderBy('created_at', 'DESC')->get();
	}

	public function handleFileUpload() {
        if (request()->hasFile('file')) {
            $file = request()->file('file');
            $path = $file->store('uploads');

            return [
                'path' => $path,
                'original_filename' => $file->getClientOriginalName(),
            ];
        }

        return null;
    }

    public function update($params = []){
        return $this->bulkProduct->update($params);
    }

    public function updateStatus($status, $withDate = null){
        $data = compact('status');
        if(!is_null($withDate)) $data[$withDate] = Carbon::now();

        return $this->update($data);
    }

    public function updateStatusInProgress(){
        $data = $this->updateStatus(BulkProduct::STATUS_PROCESSING);

        return $data;
    }

    public function updateStatusCompleted(){
        return $this->updateStatus(BulkProduct::STATUS_COMPLETED, 'completed_at');
    }
}