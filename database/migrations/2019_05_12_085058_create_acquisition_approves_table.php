<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcquisitionApprovesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acquisition_approves', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('acquisition_id')->index('acquisition_id');
			$table->integer('user_id')->index('user_id');
			$table->boolean('approve')->comment('0:no action yet / 1:yes / 2:no /3:semi approve');
			$table->text('description', 65535);
			$table->boolean('notified_action')->comment('0:no action yet / 1:yes / 2:no ');
			$table->text('notified_description', 65535);
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
		Schema::drop('acquisition_approves');
	}

}
