<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractsOperatorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contracts_operator', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contracts_id')->index('country_id');
			$table->string('operator_ids');
			$table->integer('country_id')->nullable()->index('contracts_operator_country_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contracts_operator');
	}

}
