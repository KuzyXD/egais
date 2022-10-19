<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('rg_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('group');
            $table->bigInteger('manager_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_companies');
    }
}
