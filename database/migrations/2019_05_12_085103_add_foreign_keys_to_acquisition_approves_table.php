<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAcquisitionApprovesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('acquisition_approves', function(Blueprint $table)
		{
			$table->foreign('acquisition_id', 'acquisition_approves_ibfk_1')->references('id')->on('acquisitions')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'acquisition_approves_ibfk_2')->references('id')->on('tb_users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('acquisition_approves', function(Blueprint $table)
		{
			$table->dropForeign('acquisition_approves_ibfk_1');
			$table->dropForeign('acquisition_approves_ibfk_2');
		});
	}

}
