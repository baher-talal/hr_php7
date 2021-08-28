<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcquisitionRegionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acquisition_region', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->index('country_id');
			$table->string('operators_ids');
			$table->integer('acquisition_id')->index('acquisition_id');
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
		Schema::drop('acquisition_region');
	}

}
