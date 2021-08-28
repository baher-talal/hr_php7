<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOperatorMediaVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operator_media_videos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('country_id')->index('operator_media_videos_ibfk_1');
			$table->integer('operators_id')->index('operator_media_videos_ibfk_2');
			$table->integer('cont_category_id');
			$table->integer('cont_type_id');
			$table->integer('cont_media_format_id');
			$table->integer('cont_video_image_size_id');
			$table->integer('cont_video_frame_rate_id');
			$table->integer('cont_video_format_id');
			$table->integer('cont_video_pixel_aspect_ratio_id');
			$table->integer('cont_audio_sample_rate_id');
			$table->integer('cont_audio_bit_rate_id');
			$table->integer('cont_audio_channel_id');
			$table->integer('cont_media_file_size_id');
			$table->time('video_duration');
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
		Schema::drop('operator_media_videos');
	}

}
