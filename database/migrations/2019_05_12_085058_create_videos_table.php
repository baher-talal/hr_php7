<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('video_title', 160);
			$table->integer('provider_id')->index('provider_id');
			$table->integer('country_id')->index('country_id');
			$table->integer('operators_id')->index('operators_id');
			$table->string('video_path', 200);
			$table->boolean('video_status')->default(0);
			$table->timestamps();
			$table->integer('entry_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('videos');
	}

}
