<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGetAudioDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('get_audio_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->index('country_id');
			$table->integer('operators_id')->index('operators_id');
			$table->integer('cont_categories_id')->index('cont_categories_id');
			$table->integer('cont_media_file_sizes')->index('cont_media_file_sizes');
			$table->string('track_sample_path');
			$table->string('track_meta_data');
			$table->string('track_duration', 10)->nullable();
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
		Schema::drop('get_audio_details');
	}

}
