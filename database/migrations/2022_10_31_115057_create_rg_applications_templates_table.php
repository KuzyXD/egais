<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRgApplicationsTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('rg_applications_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("created_by")->constrained("managers");
            $table->tinyInteger("type");
            $table->string("firstName")->nullable();
            $table->string("middleName")->nullable();
            $table->string("lastName")->nullable();
            $table->string("applicant_fio")->nullable();
            $table->string("headLastName")->nullable();
            $table->string("headFirstName")->nullable();
            $table->string("headMiddleName")->nullable();
            $table->string("head_fio")->nullable();
            $table->string("HeadPosition")->nullable();
            $table->string("company")->nullable();
            $table->string("position")->nullable();
            $table->string("department")->nullable();
            $table->string("passportSerial", 4)->nullable();
            $table->string("passportNumber", 6)->nullable();
            $table->string("passportDate", 10)->nullable();
            $table->string("passportCode", 6)->nullable();
            $table->string("passportDivision")->nullable();
            $table->char("gender", 1)->nullable();
            $table->string("birthDate", 10)->nullable();
            $table->string("inn", 12)->nullable();
            $table->string("personInn", 12)->nullable();
            $table->string("ogrn", 15)->nullable();
            $table->string("kpp", 9)->nullable();
            $table->string("snils", 11)->nullable();
            $table->string("email")->nullable();
            $table->string("phone", 10)->nullable();
            $table->string("companyPhone", 10)->nullable();
            $table->tinyInteger("countryId")->default(193);
            $table->tinyInteger("region")->nullable();
            $table->string("city")->nullable();
            $table->string("address")->nullable();
            $table->string("index")->nullable();
            $table->boolean("offerJoining")->default(false);
            $table->string("products");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rg_applications_templates');
    }
}
