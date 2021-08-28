<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {

          $table->increments('id');

          $table->integer('year');

          $table->string('month');

          $table->String('classification');

          $table->string('code');

          $table->string('rbt_name');

          $table->integer('download_no')->nullable();

          $table->decimal('total_revenue',10,2);

          $table->decimal('revenue_share',10,2);


          /**
           * Foreignkeys section
           */
           $table->integer('rbt_id')->unsigned();
           $table->foreign('rbt_id')->references('id')->on('rbts')->onDelete('cascade') ;

           $table->integer('operator_id')->nullable();
           $table->foreign('operator_id')->references('id')->on('tb_operators')->onDelete('cascade');

           $table->integer('provider_id')->nullable();
           $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');

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
        Schema::drop('reports');
    }
}
