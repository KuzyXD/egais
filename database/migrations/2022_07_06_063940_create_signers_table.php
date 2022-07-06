<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_template_id');
            $table->string('certificate_serial_number', 50);

            $table->string("commonName")->nullable();
            $table->string("organizationName")->nullable();
            $table->string("title")->nullable();
            $table->string("surname")->nullable();
            $table->string("givenName")->nullable();
            $table->string("emailAddress")->nullable();
            $table->string("inn")->nullable();
            $table->string("ogrn")->nullable();
            $table->string("snils")->nullable();
            $table->string("countryName")->nullable();
            $table->string("localityName")->nullable();
            $table->string("stateOrProvinceName")->nullable();
            $table->string("streetAddress")->nullable();
            $table->dateTime("from");
            $table->dateTime("end");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signers');
    }
}
