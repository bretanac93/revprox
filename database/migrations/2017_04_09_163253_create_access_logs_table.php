<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
         * +"host": "10.2.64.233"
    +"logname": "-"
    +"user": "-"
    +"stamp": 1486586422
    +"time": Carbon {#612 ▶}
    +"request": "GET /images/links//stack.svg HTTP/1.1"
    +"status": "200"
    +"sentBytes": "3035"
    +"HeaderReferer": "https://intranet.upr.edu.cu/"
    +"HeaderUserAgent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.76 Safari/537.36"*/

        Schema::create('access_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host');
            $table->string('user');
            $table->dateTime('time');
            $table->string('request');
            $table->integer('status');
            $table->string('sent_bytes');
            $table->string('referrer');
            $table->string('user_agent');
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
        Schema::dropIfExists('access_logs');
    }
}
