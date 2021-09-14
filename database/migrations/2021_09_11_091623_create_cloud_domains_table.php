<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('site');
            $table->integer('account_id');
            $table->string('zone_id');
            $table->string('name');
            $table->string('status');
            $table->string('security_level');
            $table->string('ssl_setting');
            $table->string('ipv6');
            $table->string('name_server1');
            $table->string('name_server2');
            $table->string('plan');
            $table->datetime('expire_date');
            $table->string('get_id');
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
        Schema::dropIfExists('cloud_domains');
    }
}
