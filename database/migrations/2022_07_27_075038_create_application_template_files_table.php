<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('application_template_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_template_id');
            $table->string('type');
            $table->string('path');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('application_template_files');
    }
};