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

        Schema::table('inspections', function (Blueprint $table) {
         $table->dropForeign(['crea_objectnumber']);
         
         // $table->foreign(columns:'crea_objectnumber')
         // ->references(columns:'crea_objectnumber')->on(table:'duts')->onUpdate('cascade')->onDelete('cascade');
     });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
