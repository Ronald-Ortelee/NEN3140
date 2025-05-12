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
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Schema::table('device_types', function(Blueprint $table) {
            $table->foreign('category_id')
            ->references('id')
            ->on('categories');
           
        });

             DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};


