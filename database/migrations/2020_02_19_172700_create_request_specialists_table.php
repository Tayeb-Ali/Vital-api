<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestSpecialistsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_specialists', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('name');
            $table->string('address');
            $table->date('start_time');
            $table->date('end_time');
            $table->integer('number_of_hour');
            $table->double('price');
            $table->integer('status')->default(1);
            $table->double('longitude');
            $table->double('latitude');
            $table->unsignedBigInteger('medical_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('medical_id')->references('id')->on('medical_specialties');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_specialists');
    }
}
