<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_Electrics')->create('electrics', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->float('amount');
            $table->date('next_period');
            $table->tinyInteger('pay_state');
            $table->tinyInteger('city_number');

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
