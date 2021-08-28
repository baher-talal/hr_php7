<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAudioTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('audio_tracks', function(Blueprint $table)
		{
			$table->foreign('provider_id', 'audio_tracks_ibfk_1')->references('id')->on('providers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('original_content_id', 'audio_tracks_ibfk_2')->references('id')->on('original_contents')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('country_id', 'audio_tracks_ibfk_3')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('operators_id', 'audio_tracks_ibfk_4')->references('id')->on('tb_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('cont_categories_id', 'audio_tracks_ibfk_5')->references('id')->on('specs_cont_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('audio_tracks', function(Blueprint $table)
		{
			$table->dropForeign('audio_tracks_ibfk_1');
			$table->dropForeign('audio_tracks_ibfk_2');
			$table->dropForeign('audio_tracks_ibfk_3');
			$table->dropForeign('audio_tracks_ibfk_4');
			$table->dropForeign('audio_tracks_ibfk_5');
		});
	}

}
