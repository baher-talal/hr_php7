<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPunchNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_punch_notifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('punch_user_fk');
			$table->date('punch_date');
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
		Schema::drop('tb_punch_notifications');
	}

}
