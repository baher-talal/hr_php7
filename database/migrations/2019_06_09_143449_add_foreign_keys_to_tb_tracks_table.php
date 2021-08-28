<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_tracks', function(Blueprint $table)
		{
			$table->foreign('album_id', 'tracks_album_fk')->references('id')->on('tb_albums')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_tracks', function(Blueprint $table)
		{
			$table->dropForeign('tracks_album_fk');
		});
	}

}
