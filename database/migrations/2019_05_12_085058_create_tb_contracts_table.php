<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_contracts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title');
			$table->date('signed_date');
			$table->date('start_date');
			$table->date('end_date');
			$table->boolean('peroid');
			$table->string('first_part_name');
			$table->string('second_part_name');
			$table->integer('first_part_ratio');
			$table->integer('second_part_ratio');
			$table->string('first_part_email');
			$table->string('second_part_email');
			$table->string('min_guarantee');
			$table->string('first_part_address');
			$table->string('second_part_address');
			$table->boolean('location')->comment('1:inside /2:outside');
			$table->string('first_part_phone');
			$table->string('second_part_phone');
			$table->boolean('expire')->comment('1:expired');
			$table->decimal('working_hours');
			$table->timestamps();
			$table->integer('entry_by');
			$table->boolean('notification_period_months');
			$table->integer('brand_manager_id')->nullable();
			$table->integer('expected_time_to_finish_with_days')->nullable();
			$table->integer('template_id')->nullable();
			$table->boolean('operation_approve');
			$table->boolean('finance_approve');
			$table->boolean('legal_approve');
			$table->boolean('ceo_cancel');
			$table->boolean('final_approve');
			$table->boolean('contract_type')->comment('1:New / 2:Draft');
			$table->integer('acqisition_id')->nullable()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_contracts');
	}

}
