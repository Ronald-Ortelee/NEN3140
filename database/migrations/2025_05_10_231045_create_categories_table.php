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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('category')->nullable()->comment('Inspection interval category');
            $table->text('category_remark')->nullable()->comment('Category_remark');
            $table->text('example')->nullable()->comment('Array of examples devices in this categoy');
            $table->integer('inspection_interval')->nullable()->comment('Inspection Interval in Years');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
