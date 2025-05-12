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

        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_inspection')->comment('Date when this inspection was performed');
            $table->unsignedBigInteger('user_id')->comment('Foreign key of registered user as tester');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('visual_inspection')->comment('Note with respect to the visual condition of the DUT');
            $table->float('isolation_resistance');
            $table->float('earth_conductor_resistance');
            $table->float('real leakage current');
            $table->float('replacement_leakage_current');
            $table->unsignedBigInteger('device_under_test_id');
            $table->foreign('device_under_test_id')->references('id')->on('device_under_tests');
            $table->text('remarks');
            $table->unsignedBigInteger('visual_inspection_result');
            $table->foreign('visual_inspection_result')->references('id')->on('results');
            $table->unsignedBigInteger('isolation_resistance_result');
            $table->foreign('isolation_resistance_result')->references('id')->on('results');
            $table->unsignedBigInteger('earth_conductor_resistance_result');
            $table->foreign('earth_conductor_resistance_result')->references('id')->on('results');
            $table->unsignedBigInteger('real leakage current_result');
            $table->foreign('real leakage current_result')->references('id')->on('results');
            $table->unsignedBigInteger('replacement_leakage_current_result');
            $table->foreign('replacement_leakage_current_result')->references('id')->on('results');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
