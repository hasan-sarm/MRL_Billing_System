<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Communication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_communication')->create('communications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('city_code');
            $table->foreign('city_code')->references('id')->on('city_code')->onDelete('cascade');
            $table->integer('number');
            $table->float('amount');
            $table->date('next_payment');
            $table->integer('pay_state');
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
        //
    }
}
