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
            Schema::table('duts', function(Blueprint $table) {
            $table->foreign('type_id')
            ->references('id')
            ->on('types');
           
        });

            


             DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationship_brands_types_tables_to_duts');
    }
};
