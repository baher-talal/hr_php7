<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_departments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title');
			$table->integer('manager_id');
			$table->string('email')->nullable();
			$table->text('description', 65535)->nullable();
			$table->integer('entry_by')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_departments');
	}

}
