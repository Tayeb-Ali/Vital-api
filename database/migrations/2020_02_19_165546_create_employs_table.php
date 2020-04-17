<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmploysTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('graduation_date');
            $table->date('birth_of_date');
            $table->string('medical_registration_number');
            $table->date('registration_date');
            $table->string('address');
            $table->integer('years_of_experience');
            $table->text('cv');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('medical_field_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('medical_field_id')->references('id')->on('medical_specialties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employs');
    }
}
