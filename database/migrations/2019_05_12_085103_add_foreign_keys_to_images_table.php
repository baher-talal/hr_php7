<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('images', function(Blueprint $table)
		{
			$table->foreign('provider_id', 'images_ibfk_1')->references('id')->on('providers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('country_id', 'images_ibfk_2')->references('id')->on('tb_countries')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('operators_id', 'images_ibfk_3')->references('id')->on('tb_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('images', function(Blueprint $table)
		{
			$table->dropForeign('images_ibfk_1');
			$table->dropForeign('images_ibfk_2');
			$table->dropForeign('images_ibfk_3');
		});
	}

}
