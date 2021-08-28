<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommitmentsEscalationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('commitments_escalation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('commitment_id')->index('commitment_id');
			$table->integer('user_id')->index('user_id');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('commitments_escalation');
	}

}
