<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->unique();
            $table->bigInteger('uploaded')->unsigned()->default(0);
            $table->bigInteger('downloaded')->unsigned()->default(0);
            $table->bigInteger('seeding')->unsigned()->default(0);
            $table->bigInteger('account_age')->unsigned()->default(0);

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

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
        Schema::dropIfExists('role_rules');
    }
}
