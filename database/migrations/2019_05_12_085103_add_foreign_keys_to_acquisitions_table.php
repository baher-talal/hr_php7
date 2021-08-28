<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcquisitionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('acquisitions', function(Blueprint $table)
		{
			$table->foreign('brand_manager_id', 'acquisitions_ibfk_1')->references('id')->on('tb_users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('provider_id', 'acquisitions_ibfk_2')->references('id')->on('providers')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('acquisitions', function(Blueprint $table)
		{
			$table->dropForeign('acquisitions_ibfk_1');
			$table->dropForeign('acquisitions_ibfk_2');
		});
	}

}
