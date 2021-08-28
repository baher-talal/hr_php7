<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbContractsRenewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_contracts_renews', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contract_id')->index('country_id');
			$table->date('start_date');
			$table->date('end_date');
			$table->date('renew_date');
			$table->timestamps();
			$table->integer('entry_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_contracts_renews');
	}

}
