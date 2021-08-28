<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_tasks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('task', 65535);
			$table->integer('commitment_id')->index('commitment_id');
			$table->integer('assign_to_id')->index('assign_to_id');
			$table->float('time', 10, 0);
			$table->boolean('seen');
			$table->boolean('status')->comment('0:not seen,1:initial,2:pending,3:working,4:finished');
			$table->decimal('working_hours', 10);
			$table->timestamps();
			$table->integer('entry_by');
			$table->integer('priority')->nullable()->index('priority');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_tasks');
	}

}
