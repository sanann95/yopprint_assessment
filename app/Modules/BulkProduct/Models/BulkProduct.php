<?php

namespace App\Modules\BulkProduct\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\BulkProduct\Events\BulkProductCreatedEvent;

class BulkProduct extends Model {
	const STATUS_NEW = 'NEW';
	const STATUS_PROCESSING = 'PROCESSING';
	const STATUS_COMPLETED = 'COMPLETED';
	const STATUS_FAILED = 'FAILED';

	protected $fillable = [
		'filename', 
        'original_filename',
		'status',
		'total',
        'total_success',
        'total_failed',
        'completed_at',
	];

	protected $dispatchesEvents = [
        'created' => BulkProductCreatedEvent::class,
    ];

    protected $dates = [
        'completed_at',
    ];

    public function getProgressPercentageAttribute() {
    	if($this->is_status_processing) {
    		$total = $this->total;
            if($total <= 0) $total = 1;
            return round(($this->total_success + $this->total_failed) / $total * 100);
    	}

    	if($this->is_status_completed) { return 100; }
        if($this->is_status_new) { return 0; }

    	return null;
    }

    public function getIsStatusProcessingAttribute() {
    	return $this->status == self::STATUS_PROCESSING;
    }

    public function getIsStatusCompletedAttribute() {
    	return $this->status == self::STATUS_COMPLETED;
    }

    public function getIsStatusNewAttribute() {
        return $this->status == self::STATUS_NEW;
    }

    public function getFullFilePathAttribute() {
    	return storage_path('app/' . $this->filename); 
    }

    public function getCompletedAtStringAttribute() {
        return $this->is_status_completed ? $this->completed_at->format('d M Y h:i:s') : '';
    }
}