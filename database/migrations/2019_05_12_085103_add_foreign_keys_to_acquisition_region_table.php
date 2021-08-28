<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcquisitionRegionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('acquisition_region', function(Blueprint $table)
		{
			$table->foreign('country_id', 'acquisition_region_ibfk_1')->references('id')->on('tb_countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('acquisition_id', 'acquisition_region_ibfk_2')->references('id')->on('acquisitions')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('acquisition_region', function(Blueprint $table)
		{
			$table->dropForeign('acquisition_region_ibfk_1');
			$table->dropForeign('acquisition_region_ibfk_2');
		});
	}

}
