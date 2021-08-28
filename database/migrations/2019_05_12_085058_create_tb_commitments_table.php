<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbCommitmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_commitments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contract_id')->nullable()->index('contract_id');
			$table->integer('department_id')->index('department_id');
			$table->text('commitment', 65535);
			$table->text('notes', 65535);
			$table->boolean('seen')->comment('0:not seen yet , 1:seen');
			$table->boolean('approve')->comment('1:approved');
			$table->text('disaprove_reason', 65535);
			$table->decimal('working_hours');
			$table->timestamps();
			$table->integer('entry_by');
			$table->integer('priority')->nullable()->index('priority');
			$table->integer('project_id')->nullable()->index('tb_commitments_project_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_commitments');
	}

}
