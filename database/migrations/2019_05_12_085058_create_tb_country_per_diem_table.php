<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbCountryPerDiemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_country_per_diem', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->index('per_diem_country_fk');
			$table->integer('per_diem_position_id')->index('per_diem_position_fk');
			$table->integer('per_diem_cost');
			$table->integer('entry_by')->nullable();
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
		Schema::drop('tb_country_per_diem');
	}

}
