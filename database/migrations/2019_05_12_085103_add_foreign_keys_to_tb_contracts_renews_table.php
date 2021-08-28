<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbContractsRenewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_contracts_renews', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'tb_contracts_renews_ibfk_1')->references('id')->on('tb_contracts')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_contracts_renews', function(Blueprint $table)
		{
			$table->dropForeign('tb_contracts_renews_ibfk_1');
		});
	}

}
