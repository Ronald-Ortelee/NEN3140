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
        Schema::table('duts', function (Blueprint $table) {
            $table->foreign(['brand_id'], 'device_under_tests_brand_id_foreign')->references(['id'])->on('brands')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['location_id'], 'device_under_tests_location_id_foreign')->references(['id'])->on('locations')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['devicetype_id'])->references(['id'])->on('device_types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['safety_class_id'])->references(['id'])->on('safety_classes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['type_id'])->references(['id'])->on('types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('duts', function (Blueprint $table) {
            $table->dropForeign('device_under_tests_brand_id_foreign');
            $table->dropForeign('device_under_tests_location_id_foreign');
            $table->dropForeign('duts_devicetype_id_foreign');
            $table->dropForeign('duts_safety_class_id_foreign');
            $table->dropForeign('duts_type_id_foreign');
            $table->dropForeign('duts_user_id_foreign');
        });
    }
};
