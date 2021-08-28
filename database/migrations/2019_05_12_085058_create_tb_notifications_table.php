<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_notifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('notifier_id');
			$table->integer('notified_id');
			$table->string('subject');
			$table->string('link', 500);
			$table->boolean('seen')->default(0)->comment('0 =not seen , 1 = seen ');
			$table->integer('entry_user');
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
		Schema::drop('tb_notifications');
	}

}
