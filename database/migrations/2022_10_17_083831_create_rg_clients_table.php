<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgClientsTable extends Migration
{
    public function up()
    {
        Schema::create('rg_clients', function (Blueprint $table) {
            $table->id();
            $table->string('fio');
            $table->string('password');
            $table->string('certificate_serial_number', 50);
            $table->timestamp('certificate_expire_to_date');
            $table->string('note')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_clients');
    }
}
