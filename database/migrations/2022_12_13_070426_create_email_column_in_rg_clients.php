<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailColumnInRgClients extends Migration
{
    public function up()
    {
        Schema::table('rg_clients', function (Blueprint $table) {
            $table->string('email', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_clients');
    }
}
