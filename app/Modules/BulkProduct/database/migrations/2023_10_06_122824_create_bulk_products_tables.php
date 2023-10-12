<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\BulkProduct\Models\BulkProduct;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_products', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_filename');
            $table->char('status', 16)->default(BulkProduct::STATUS_NEW)->index();
            $table->integer('total')->default(0);
            $table->integer('total_success')->default(0);
            $table->integer('total_failed')->default(0);
            $table->dateTime('completed_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_products');
    }
};
