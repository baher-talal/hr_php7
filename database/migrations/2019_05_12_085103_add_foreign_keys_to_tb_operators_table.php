<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbOperatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_operators', function(Blueprint $table)
		{
			$table->foreign('country_id', 'tb_operators_ibfk_1')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_operators', function(Blueprint $table)
		{
			$table->dropForeign('tb_operators_ibfk_1');
		});
	}

}
