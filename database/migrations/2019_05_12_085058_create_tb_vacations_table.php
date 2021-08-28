<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbVacationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_vacations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id');
			$table->integer('department_id');
			$table->integer('manager_id');
			$table->integer('type_id');
			$table->date('date');
			$table->date('from');
			$table->date('to')->nullable();
			$table->integer('peroid');
			$table->boolean('manager_approved')->nullable()->comment('0 = no , 1 = yes');
			$table->text('manager_reason', 65535)->nullable();
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
		Schema::drop('tb_vacations');
	}

}
