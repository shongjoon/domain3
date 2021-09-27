<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_coins', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('account');
            $table->integer('get_no')->unsigned()->nullable();
            $table->string('notice')->nullable();
            $table->string('memo')->nullable();
            $table->integer('account_coin')->nullable();
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
        Schema::dropIfExists('cloud_coins');
    }
}
