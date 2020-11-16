<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_doctor_profile', function (Blueprint $table) {
            $table->bigIncrements('doctor_id');
            $table->integer('user_id');
            $table->integer('district_id');
            $table->string('type');
            $table->string('doctor_name');
            $table->string('speciality_id');
            $table->string('gender');
            $table->string('email');
            $table->string('phone');
            $table->string('bmdc_no');
            $table->string('image');
            $table->string('remarks');
            $table->integer('status');
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
        Schema::dropIfExists('tbl_doctor_profile');
    }
}
