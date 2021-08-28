<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbDelayNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_delay_notifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->date('delay_date');
			$table->string('subject');
			$table->text('message', 65535);
			$table->timestamps();
			$table->integer('entry_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_delay_notifications');
	}

}
