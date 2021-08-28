<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_countries', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('country');
			$table->string('currency')->nullable();
			$table->integer('entry_by')->nullable();
			$table->timestamps();
			$table->integer('account_manager_id')->nullable()->index('tb_countries_account_manager_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_countries');
	}

}
