<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAudioTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audio_tracks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('sound_title', 160);
			$table->integer('provider_id')->index('provider_id');
			$table->integer('original_content_id')->index('original_content_id');
			$table->integer('country_id')->index('country_id');
			$table->integer('operators_id')->index('operators_id');
			$table->integer('cont_categories_id')->index('cont_categories_id');
			$table->string('sound_path', 200);
			$table->string('sound_meta_data', 100);
			$table->string('sound_rbt_code', 20);
			$table->boolean('sound_status')->default(0);
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
		Schema::drop('audio_tracks');
	}

}
