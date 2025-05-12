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
        Schema::create('duts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id')->default(1)->index('device_under_tests_type_id_foreign')->comment('Foreign key of the type table');
            $table->unsignedBigInteger('location_id')->index('device_under_tests_location_id_foreign')->comment('Foreign key of the location table');
            $table->unsignedBigInteger('brand_id')->index('device_under_tests_brand_id_foreign')->comment('Foreign key of brand_model table');
            $table->unsignedBigInteger('devicetype_id')->index('device_under_tests_devicetype_id_foreign')->comment('Foreign key of devicetype table');
            $table->date('date_in_use')->comment('Known date when the DUT was brought into use');
            $table->date('date_out_of_use')->nullable()->comment('Date when DUT was taken out of use due to failed from test');
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index('duts_user_id_foreign');
            $table->unsignedBigInteger('safety_class_id')->index('duts_safety_class_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duts');
    }
};
