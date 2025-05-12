<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catagories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_type_id')->comment('Foreign key of device_type table');
            $table->foreign('device_type_id')->references('id')->on('device_types');
            $table->integer('category')->comment('Inspection interval category');
            $table->text('category_remark')->comment('Category_remark');
            $table->jsonb('example')->comment('Array of examples devices in this categoy');
            $table->integer('inspection_interval')->comment('Inspection Interval in Years');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catagories');
    }
};
