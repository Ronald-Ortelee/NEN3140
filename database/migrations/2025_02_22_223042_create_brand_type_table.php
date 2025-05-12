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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('brand_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->comment('Foreign key to brands table');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('type_id')->comment('Foreign key to types table');
            $table->foreign('type_id')->references('id')->on('types');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_type');
    }
};
