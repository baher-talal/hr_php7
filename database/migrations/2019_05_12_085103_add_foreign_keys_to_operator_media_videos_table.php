<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOperatorMediaVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('operator_media_videos', function(Blueprint $table)
		{
			$table->foreign('country_id', 'operator_media_videos_ibfk_1')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('operators_id', 'operator_media_videos_ibfk_2')->references('id')->on('tb_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('operator_media_videos', function(Blueprint $table)
		{
			$table->dropForeign('operator_media_videos_ibfk_1');
			$table->dropForeign('operator_media_videos_ibfk_2');
		});
	}

}
