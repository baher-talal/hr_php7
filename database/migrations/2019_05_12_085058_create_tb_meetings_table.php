<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbMeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_meetings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id');
			$table->integer('department_id');
			$table->integer('manager_id');
			$table->date('date');
			$table->dateTime('from');
			$table->dateTime('to');
			$table->text('location', 65535);
			$table->text('purpose', 65535);
			$table->text('notes', 65535)->nullable();
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
		Schema::drop('tb_meetings');
	}

}
