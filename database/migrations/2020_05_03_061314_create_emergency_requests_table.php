<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('reports');
            $table->string('reports_file')->nullable();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('emergency_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('emergency_id')->references('id')->on('emergency_serviceds');
            $table->softDeletes();
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
        Schema::dropIfExists('emergency_requests');
    }
}
