<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReverseProxyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reverse_proxies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('server_ip');
            $table->string('proxy_dns')->unique();
            $table->string('route');
            $table->boolean('has_ssl');

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
        Schema::dropIfExists('reverse_proxies');
    }
}
