<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOccasionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occasions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('occasion_name', 100);
			$table->string('occasion_description');
			$table->date('occasion_date');
			$table->integer('category_id')->index('category_id');
			$table->integer('country_id')->index('country_id');
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
		Schema::drop('occasions');
	}

}
