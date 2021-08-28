<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cont_types', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('cont_type_title', 30)->unique();
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
		Schema::drop('cont_types');
	}

}
