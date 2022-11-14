<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgApplicationTemplateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('rg_application_template_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_template_id')->constrained('rg_applications_templates');
            $table->string('type');
            $table->string('name');
            $table->string('path');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_application_template_files');
    }
}
