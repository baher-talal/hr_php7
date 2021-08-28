<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbVisaDaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_visa_days', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->index('visa_country_fk');
			$table->integer('no_days');
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
		Schema::drop('tb_visa_days');
	}

}
