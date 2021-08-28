<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGetAudioDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('get_audio_details', function(Blueprint $table)
		{
			$table->foreign('country_id', 'get_audio_details_ibfk_1')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('operators_id', 'get_audio_details_ibfk_2')->references('id')->on('tb_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('cont_categories_id', 'get_audio_details_ibfk_3')->references('id')->on('specs_cont_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('cont_media_file_sizes', 'get_audio_details_ibfk_4')->references('id')->on('specs_cont_media_file_sizes')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('get_audio_details', function(Blueprint $table)
		{
			$table->dropForeign('get_audio_details_ibfk_1');
			$table->dropForeign('get_audio_details_ibfk_2');
			$table->dropForeign('get_audio_details_ibfk_3');
			$table->dropForeign('get_audio_details_ibfk_4');
		});
	}

}
