<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('providers', function(Blueprint $table)
		{
			$table->foreign('provider_type_id', 'providers_ibfk_1')->references('id')->on('provider_types')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('providers', function(Blueprint $table)
		{
			$table->dropForeign('providers_ibfk_1');
		});
	}

}
