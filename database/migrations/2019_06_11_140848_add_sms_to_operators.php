<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsToOperators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('tb_operators', function (Blueprint $table) {
             //
             $table->string('rbt_ussd_code',10)->nullable() ;
             $table->integer('rbt_sms_code') ;
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('tb_operators', function (Blueprint $table) {
             //
             $table->dropColumn('rbt_ussd_code');
             $table->dropColumn('rbt_sms_code');
         });
     }
}
