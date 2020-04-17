<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcceptRequestSpecialistsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accept_request_specialists', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('note')->nullable();
            $table->string('recommendation')->nullable();
            $table->integer('rating')->nullable();
            $table->biginteger('doctor_id')->unsigned();
            $table->biginteger('request_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('request_id')->references('id')->on('request_specialists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accept_request_specialists');
    }
}
