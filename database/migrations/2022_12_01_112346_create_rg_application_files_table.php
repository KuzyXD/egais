<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgApplicationFilesTable extends Migration
{
    public function up()
    {
        Schema::create('rg_application_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('rg_applications');
            $table->string('name');
            $table->string('type');
            $table->string('path');
            $table->string('sig_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_application_files');
    }
}
