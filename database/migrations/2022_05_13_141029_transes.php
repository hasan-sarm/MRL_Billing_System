<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_bank')->create('Transes', function (Blueprint $table) {
            $table->id();
            $table->string('Transe_name');
            $table->string('from');
            $table->string('to');
            $table->float('transe_amount',12,2);
            $table->unsignedInteger('bill_id');
            $table->unsignedInteger('user_id');
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
