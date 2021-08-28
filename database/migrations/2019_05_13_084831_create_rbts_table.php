<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRbtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rbts', function (Blueprint $table) {
          $table->increments('id')->unsigned();

          $table->String('track_title_en')->nullable();

          $table->string('track_title_ar')->nullable();

          $table->string('artist_name_en')->nullable();

          $table->string('artist_name_ar')->nullable();

          $table->string('album_name')->nullable();

          $table->String('code');

          $table->String('social_media_code')->nullable();

          $table->String('owner')->nullable();

          $table->String('track_file')->nullable();

          $table->boolean('type')->default(0)->comment("0=old excel , 1=new excel");
          /**
           * Foreignkeys section
           */

          $table->integer('provider_id')->nullable();
          $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');

          $table->integer('operator_id')->nullable();
          $table->foreign('operator_id')->references('id')->on('tb_operators')->onDelete('cascade');

          $table->integer('occasion_id')->nullable();
          $table->foreign('occasion_id')->references('id')->on('occasions')->onDelete('cascade');

          $table->integer('aggregator_id')->nullable();
          $table->foreign('aggregator_id')->references('id')->on('aggregators')->onDelete('cascade');


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
        Schema::drop('rbts');
    }
}
