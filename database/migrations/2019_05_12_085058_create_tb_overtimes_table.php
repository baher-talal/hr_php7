<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbOvertimesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_overtimes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id');
			$table->integer('department_id');
			$table->integer('manager_id');
			$table->date('date');
			$table->string('from');
			$table->string('to');
			$table->string('no_hours');
			$table->text('employee_reason', 65535);
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
		Schema::drop('tb_overtimes');
	}

}
