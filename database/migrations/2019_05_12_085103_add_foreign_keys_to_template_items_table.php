<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTemplateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('template_items', function(Blueprint $table)
		{
			$table->foreign('template_id', 'template_items_ibfk_1')->references('id')->on('templates')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('template_items', function(Blueprint $table)
		{
			$table->dropForeign('template_items_ibfk_1');
		});
	}

}
