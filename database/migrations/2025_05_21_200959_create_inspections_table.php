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
        Schema::create('inspections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dut_id')->index('inspections_dut_id_foreign');
            $table->unsignedBigInteger('user_id')->index('inspections_user_id_foreign')->comment('Foreign key of registered user as tester');
            $table->date('date_of_inspection')->comment('Date when this inspection was performed');
            $table->text('visual_inspection')->comment('Note with respect to the visual condition of the DUT');
            $table->string('visual_inspection_result', 25);
            $table->double('isolation_resistance');
            $table->string('isolation_resistance_result', 25);
            $table->double('earth_conductor_resistance');
            $table->string('earth_conductor_resistance_result', 25);
            $table->double('leakage_current');
            $table->string('leakage_current_type', 25);
            $table->string('leakage_current_result', 25);
            $table->string('functional_test_result', 25);
            $table->text('remarks')->nullable();
            $table->string('inspection_result', 25);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
