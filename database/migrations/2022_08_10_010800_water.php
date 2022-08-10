<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Water extends Migration
{
     /**
    * Run the migrations.
    *
    * @return void
    */

   public function up()
   {
       Schema::connection('mysql_water')->create('waters', function (Blueprint $table) {
           $table->id();
           $table->integer('code');
           $table->float('amount');
           $table->date('next_payment');
           $table->tinyInteger('pay_state');
           $table->tinyInteger('city_code');
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
