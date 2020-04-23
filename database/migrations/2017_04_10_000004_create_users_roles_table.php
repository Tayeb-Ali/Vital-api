<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * User and roles relation table
         */
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');

            /*
             * Add Foreign/Unique/Index
             */
            $table->foreign('user_id', 'foreign_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('role_id', 'foreign_role')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->unique(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_roles', function (Blueprint $table) {
            $table->dropForeign('foreign_user');
            $table->dropForeign('foreign_role');
        });

        /*
         * Drop tables
         */
        Schema::dropIfExists('users_roles');
    }
}
