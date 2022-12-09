<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('rg_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('rg_managers');
            $table->bigInteger('ac_id')->nullable();
            $table->foreignId('template_id')->constrained('rg_applications_templates');
            $table->string('pin_code')->nullable();
            $table->string('comment')->nullable();
            $table->string('action_type')->nullable();
            $table->string('store_number')->nullable();
            $table->string('status');
            $table->timestamp('certificate_produced_at')->nullable();
            $table->string('serial_number_certificate', 50)->nullable();
            $table->string('replace_serial_key', 50)->nullable();
            $table->timestamp('certificate_finished_at')->nullable();
            $table->string('ac_login')->nullable();
            $table->string('ac_pass')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_applications');
    }
}
