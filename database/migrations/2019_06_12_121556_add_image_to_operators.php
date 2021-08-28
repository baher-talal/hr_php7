<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToOperators extends Migration
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
          $table->string('image',200)->nullable() ;

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
          $table->dropColumn('image');
      });
    }
}
