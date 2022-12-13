<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRgClientsAuth extends Migration
{
    public function up()
    {
        Schema::table('rg_clients', function (Blueprint $table) {
            $table->dropColumn('certificate_serial_number');
            $table->dropColumn('certificate_expire_to_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_clients');
    }
}
