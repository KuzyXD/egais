<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId("created_by")->constrained("managers");
            $table->foreignId("created_for")->constrained("companies");
            $table->tinyInteger("type");
            $table->string("firstName", 500)->nullable();
            $table->string("middleName", 500)->nullable();
            $table->string("lastName", 500)->nullable();
            $table->string("applicant_fio", 500)->nullable();
            $table->string("headLastName", 500)->nullable();
            $table->string("headFirstName", 500)->nullable();
            $table->string("headMiddleName", 500)->nullable();
            $table->string("head_fio", 500)->nullable();
            $table->string("HeadPosition", 500)->nullable();
            $table->string("company", 500)->nullable();
            $table->string("position", 500)->nullable();
            $table->string("department", 500)->nullable();
            $table->string("passportSerial", 4)->nullable();
            $table->string("passportNumber", 6)->nullable();
            $table->string("passportDate", 10)->nullable();
            $table->string("passportCode", 6)->nullable();
            $table->string("passportDivision", 500)->nullable();
            $table->char("gender", 1)->nullable();
            $table->string("birthDate", 10)->nullable();
            $table->string("inn", 10)->nullable();
            $table->string("personInn", 12)->nullable();
            $table->string("ogrn", 15)->nullable();
            $table->string("kpp", 9)->nullable();
            $table->string("snils", 11)->nullable();
            $table->string("email")->nullable();
            $table->string("phone", 10)->nullable();
            $table->string("companyPhone", 10)->nullable();
            $table->tinyInteger("countryId")->default(193);
            $table->tinyInteger("region")->nullable();
            $table->string("city", 500)->nullable();
            $table->string("address", 500)->nullable();
            $table->string("index")->nullable();
            $table->boolean("offerJoining")->default(false);
            $table->string("products");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications_template');
    }
}
