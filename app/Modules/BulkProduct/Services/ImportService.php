<?php

namespace App\Modules\BulkProduct\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Modules\BulkProduct\Events\BulkProductTotalRowsUpdatedEvent;

class ImportService extends BulkProductBaseService {
    public function importFile() {
        $this->bulkProductService->updateStatusInProgress();
        $this->handle($this->bulkProduct);
        $this->processSaveRow($this->bulkProduct);
        $this->bulkProductService->updateStatusCompleted();
        $this->bulkProduct->save();
    }

    public function handle(&$bulkProduct) {
        $data = $this->parseCSVFile($bulkProduct->full_file_path);
        $total = 0;
        foreach ($data as $row) {
            $total++;
        }

        $bulkProduct->total = $total;
        $bulkProduct->save();
    }

    public function processSaveRow(&$bulkProduct) {
        $data = $this->parseCSVFile($bulkProduct->full_file_path);
        foreach ($data as $row) {
            $this->createOrUpdateProduct($bulkProduct, $row);
            // usleep(2000000);
        }
    }

    public function createOrUpdateProduct(&$bulkProduct, array $data) {
        try {
            $uniqueKey = Arr::get($data, 'UNIQUE_KEY');
            $product = app('products-service')->findByUniqueID($uniqueKey);

            if (!is_null($product)) {
                $product = app('product-service', compact('product'))->update($this->parseData($data));
            } else {
                $product = app('products-service')->create($this->parseData($data));
            }

            $bulkProduct->total_success++;
        } catch (\Exception $e) {
            $bulkProduct->total_failed++;
        }

        $bulkProduct->save();
    }

    protected function parseData($data) {
        return [
            'unique_id' => Arr::get($data, 'UNIQUE_KEY'),
            'title' => Arr::get($data, 'PRODUCT_TITLE'),
            'description' => Arr::get($data, 'PRODUCT_DESCRIPTION'),
            'style' => Arr::get($data, 'STYLE#'),
            'sanmar_mainframe_color' => Arr::get($data, 'SANMAR_MAINFRAME_COLOR'),
            'size' => Arr::get($data, 'SIZE'),
            'color_name' => Arr::get($data, 'COLOR_NAME'),
            'piece_price' => Arr::get($data, 'PIECE_PRICE'),
        ];
    }

    protected function parseCSVFile($filePath) {
        $header = null;
        $data = array_map(function ($row) use (&$header) {
            if (!$header) {
                $header = $this->sanitizeRow(array_map('trim', $row));
                return null;
            }

            $rowData = $this->sanitizeRow(array_map('trim', $row));

            return array_combine($header, $rowData);
        }, array_map('str_getcsv', file($filePath)));

        // Remove any null values from the data array
        return array_filter($data);
    }

    protected function sanitizeRow($data) {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedKey = $this->removeNonUTF8AndStrangeCharacters($key);
            $sanitizedValue = $this->removeNonUTF8AndStrangeCharacters($value);

            $sanitizedData[$sanitizedKey] = $sanitizedValue;
        }
        return $sanitizedData;
    }

    protected function removeNonUTF8AndStrangeCharacters($string) {
        $plainText = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $plainText = preg_replace('/[^\x{0000}-\x{007F}]+/u', '', $plainText);
        
        return $plainText;
    }
}
