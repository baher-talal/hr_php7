<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbDeductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_deductions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('user_id');
			$table->decimal('deducation_period', 10, 1);
			$table->integer('reason_id');
			$table->date('date');
			$table->integer('month');
			$table->integer('year');
			$table->integer('vacation_id')->nullable();
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
		Schema::drop('tb_deductions');
	}

}
