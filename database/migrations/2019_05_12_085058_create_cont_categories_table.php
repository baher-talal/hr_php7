<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cont_categories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('cont_category_title', 50);
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
		Schema::drop('cont_categories');
	}

}
