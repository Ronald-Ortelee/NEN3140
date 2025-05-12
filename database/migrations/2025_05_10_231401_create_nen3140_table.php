<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brand_id')->index('brand_type_brand_id_foreign')->comment('Foreign key to brands table');
            $table->unsignedBigInteger('type_id')->index('brand_type_type_id_foreign')->comment('Foreign key to types table');
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Brand of the DUT');
            $table->timestamps();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('category')->nullable()->comment('Inspection interval category');
            $table->text('category_remark')->nullable()->comment('Category_remark');
            $table->text('example')->nullable()->comment('Array of examples devices in this categoy');
            $table->integer('inspection_interval')->nullable()->comment('Inspection Interval in Years');
            $table->timestamps();
        });

        Schema::create('device_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('name')->comment('Type of Device Under Test');
            $table->unsignedBigInteger('category_id')->index('device_types_category_id_foreign');
        });

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

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

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

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->comment('Location of the DUT');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['tokenable_type', 'tokenable_id']);
        });

        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('safety_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Determined electrical safety class of the DUT');
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('brand_id')->nullable()->comment('Foreign key of brands table');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        Schema::table('device_types', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('categories')->onUpdate('no action')->onDelete('no action');
        });

        Schema::table('duts', function (Blueprint $table) {
            $table->foreign(['brand_id'], 'device_under_tests_brand_id_foreign')->references(['id'])->on('brands')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['location_id'], 'device_under_tests_location_id_foreign')->references(['id'])->on('locations')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['devicetype_id'])->references(['id'])->on('device_types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['safety_class_id'])->references(['id'])->on('safety_classes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['type_id'])->references(['id'])->on('types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });

        Schema::table('inspections', function (Blueprint $table) {
            $table->foreign(['dut_id'])->references(['id'])->on('duts')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropForeign('inspections_dut_id_foreign');
            $table->dropForeign('inspections_user_id_foreign');
        });

        Schema::table('duts', function (Blueprint $table) {
            $table->dropForeign('device_under_tests_brand_id_foreign');
            $table->dropForeign('device_under_tests_location_id_foreign');
            $table->dropForeign('duts_devicetype_id_foreign');
            $table->dropForeign('duts_safety_class_id_foreign');
            $table->dropForeign('duts_type_id_foreign');
            $table->dropForeign('duts_user_id_foreign');
        });

        Schema::table('device_types', function (Blueprint $table) {
            $table->dropForeign('device_types_category_id_foreign');
        });

        Schema::dropIfExists('users');

        Schema::dropIfExists('types');

        Schema::dropIfExists('sessions');

        Schema::dropIfExists('safety_classes');

        Schema::dropIfExists('results');

        Schema::dropIfExists('personal_access_tokens');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('locations');

        Schema::dropIfExists('jobs');

        Schema::dropIfExists('job_batches');

        Schema::dropIfExists('inspections');

        Schema::dropIfExists('failed_jobs');

        Schema::dropIfExists('duts');

        Schema::dropIfExists('device_types');

        Schema::dropIfExists('categories');

        Schema::dropIfExists('cache_locks');

        Schema::dropIfExists('cache');

        Schema::dropIfExists('brands');

        Schema::dropIfExists('brand_type');
    }
};
