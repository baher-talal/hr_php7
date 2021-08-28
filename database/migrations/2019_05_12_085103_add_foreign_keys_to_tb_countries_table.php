<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_countries', function(Blueprint $table)
		{
			$table->foreign('account_manager_id')->references('id')->on('tb_users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_countries', function(Blueprint $table)
		{
			$table->dropForeign('tb_countries_account_manager_id_foreign');
		});
	}

}
