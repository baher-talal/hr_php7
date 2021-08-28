<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAggregatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aggregators', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('aggregator_name', 100)->unique();
			$table->string('aggregator_phone', 20);
			$table->string('aggregator_mobile', 20);
			$table->string('aggregator_post_office', 50);
			$table->string('aggregator_email', 50);
			$table->string('aggregator_address', 200);
			$table->string('aggregator_admin');
			$table->date('aggregator_join_date');
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
		Schema::drop('aggregators');
	}

}
