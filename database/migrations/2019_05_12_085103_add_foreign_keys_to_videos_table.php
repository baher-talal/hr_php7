<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('videos', function(Blueprint $table)
		{
			$table->foreign('provider_id', 'videos_ibfk_1')->references('id')->on('providers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('country_id', 'videos_ibfk_2')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('operators_id', 'videos_ibfk_3')->references('id')->on('tb_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('videos', function(Blueprint $table)
		{
			$table->dropForeign('videos_ibfk_1');
			$table->dropForeign('videos_ibfk_2');
			$table->dropForeign('videos_ibfk_3');
		});
	}

}
