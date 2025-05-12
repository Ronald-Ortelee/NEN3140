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

        Schema::create('device_under_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->comment('Foreign key of the type table');
            $table->unsignedBigInteger('location_id')->comment('Foreign key of the location table');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->unsignedBigInteger('brand_type_id')->comment('Foreign key of brand_model table');
            $table->foreign('brand_type_id')->references('id')->on('brand_type');
            $table->unsignedBigInteger('safety_class_id')->comment('Foreign key of safety_class table');
            $table->foreign('safety_class_id')->references('id')->on('safety_classes');
            $table->unsignedBigInteger('test_frequency_id')->comment('Foreign key of test_frequency table');
            $table->foreign('test_frequency_id')->references('id')->on('test_frequencies');
            $table->date('date_in_use')->comment('Known date when the DUT was brought into use');
            $table->date('date_out_of_use')->comment('Date when DUT was taken out of use due to failed from test');
            $table->integer('crea_objectnumber')->comment('CREA assigned objectnumber marked at the DUT');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_under_tests');
    }
};
