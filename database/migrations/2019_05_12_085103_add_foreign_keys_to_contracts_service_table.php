<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractsServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contracts_service', function(Blueprint $table)
		{
			$table->foreign('service_id', 'contracts_service_ibfk_1')->references('id')->on('tb_services')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('contracts_id', 'contracts_service_ibfk_2')->references('id')->on('tb_contracts')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contracts_service', function(Blueprint $table)
		{
			$table->dropForeign('contracts_service_ibfk_1');
			$table->dropForeign('contracts_service_ibfk_2');
		});
	}

}
