<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgManagersTable extends Migration
{
    public function up()
    {
        Schema::create('rg_managers', function (Blueprint $table) {
            $table->id();
            $table->string('fio');
            $table->string('email');
            $table->string('password');
            $table->string('tel');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_managers');
    }
}
