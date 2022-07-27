<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsListTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->bigInteger('ac_id')->nullable();
            $table->bigInteger('template_id');
            $table->string('pin_code');
            $table->string('comment')->nullable();
            $table->string('action_type')->nullable();
            $table->string('store_number')->nullable();
            $table->string('status');
            $table->timestamp('certificate_produced_at')->nullable();
            $table->string('serial_number_certificate', 50)->nullable();
            $table->string('replace_serial_key', 50)->nullable();
            $table->timestamp('certificate_finished_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('applications_list');
    }
}
