<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOriginalContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('original_contents', function(Blueprint $table)
		{
			$table->foreign('provider_id', 'original_contents_ibfk_1')->references('id')->on('providers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('content_type_id', 'original_contents_ibfk_2')->references('id')->on('cont_types')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('occasion_id', 'original_contents_ibfk_3')->references('id')->on('occasions')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('original_contents', function(Blueprint $table)
		{
			$table->dropForeign('original_contents_ibfk_1');
			$table->dropForeign('original_contents_ibfk_2');
			$table->dropForeign('original_contents_ibfk_3');
		});
	}

}
