<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_items', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('item', 65535);
			$table->string('department_id', 200)->nullable()->index('department_id');
			$table->integer('contract_id')->index('contract_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_items');
	}

}
