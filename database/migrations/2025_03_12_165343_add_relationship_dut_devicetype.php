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
    Schema::table('duts', function(Blueprint $table) {

        $table->foreign('devicetype_id')->references('id')->on('device_types');
    });
}

/**
* Reverse the migrations.
*/
public function down(): void
{
//
}
};
