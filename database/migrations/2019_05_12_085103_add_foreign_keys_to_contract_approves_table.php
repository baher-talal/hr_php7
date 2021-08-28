<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractApprovesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_approves', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'contract_approves_ibfk_1')->references('id')->on('tb_contracts')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'contract_approves_ibfk_2')->references('id')->on('tb_users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_approves', function(Blueprint $table)
		{
			$table->dropForeign('contract_approves_ibfk_1');
			$table->dropForeign('contract_approves_ibfk_2');
		});
	}

}
