<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbCommitmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_commitments', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'tb_commitments_ibfk_1')->references('id')->on('tb_contracts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('department_id', 'tb_commitments_ibfk_2')->references('id')->on('tb_departments')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('priority', 'tb_commitments_ibfk_3')->references('id')->on('priorities')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('project_id', 'tb_commitments_ibfk_4')->references('id')->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_commitments', function(Blueprint $table)
		{
			$table->dropForeign('tb_commitments_ibfk_1');
			$table->dropForeign('tb_commitments_ibfk_2');
			$table->dropForeign('tb_commitments_ibfk_3');
			$table->dropForeign('tb_commitments_ibfk_4');
		});
	}

}
