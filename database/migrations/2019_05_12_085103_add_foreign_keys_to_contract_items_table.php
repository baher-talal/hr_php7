<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_items', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'contract_items_ibfk_2')->references('id')->on('tb_contracts')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_items', function(Blueprint $table)
		{
			$table->dropForeign('contract_items_ibfk_2');
		});
	}

}
