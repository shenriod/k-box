<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AsyncQueue extends Migration
{

        //migration needed for the async queue
        /**
         * Run the migrations.
         *
         * @return void
         */
    public function up()
    {
        Schema::create('laq_async_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->default(0);
            $table->integer('retries')->default(0);
            $table->integer('delay')->default(0);
            $table->longText('payload')->nullable();
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
        Schema::dropIfExists('laq_async_queue');
    }
}
