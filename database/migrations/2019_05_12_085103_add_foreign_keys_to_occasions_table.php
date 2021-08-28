<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOccasionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('occasions', function(Blueprint $table)
		{
			$table->foreign('category_id', 'occasions_ibfk_1')->references('id')->on('cont_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('country_id', 'occasions_ibfk_2')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('occasions', function(Blueprint $table)
		{
			$table->dropForeign('occasions_ibfk_1');
			$table->dropForeign('occasions_ibfk_2');
		});
	}

}
