<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCommitmentsEscalationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commitments_escalation', function(Blueprint $table)
		{
			$table->foreign('commitment_id', 'commitments_escalation_ibfk_1')->references('id')->on('tb_commitments')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'commitments_escalation_ibfk_2')->references('id')->on('tb_users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commitments_escalation', function(Blueprint $table)
		{
			$table->dropForeign('commitments_escalation_ibfk_1');
			$table->dropForeign('commitments_escalation_ibfk_2');
		});
	}

}
