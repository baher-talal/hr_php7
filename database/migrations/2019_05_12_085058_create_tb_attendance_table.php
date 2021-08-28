<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbAttendanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_attendance', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_finger_id');
			$table->string('employee_name');
			$table->integer('employee_id');
			$table->date('date');
			$table->string('work_day', 20);
			$table->string('day_type', 20);
			$table->string('sign_in', 10)->nullable();
			$table->string('sign_out', 10)->nullable();
			$table->decimal('work_hours', 10)->default(0.00);
			$table->decimal('overtime', 10)->default(0.00);
			$table->decimal('short_minutes', 10)->default(0.00);
			$table->string('leave_type', 20)->nullable();
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
		Schema::drop('tb_attendance');
	}

}
