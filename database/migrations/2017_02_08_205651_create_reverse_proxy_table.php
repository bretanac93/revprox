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
            $table->integer('route_id')->unsigned();
            $table->foreign('route_id')->references('id')->on('nginx_routes');
            $table->boolean('has_ssl');
            $table->boolean('is_active')->default(true);

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
