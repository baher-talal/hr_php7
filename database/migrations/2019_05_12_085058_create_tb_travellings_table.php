<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTravellingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_travellings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->index('travelling_user_fk');
			$table->integer('department_id')->index('travelling_department_fk');
			$table->integer('manager_id')->index('tb_travellings_manager_fk');
			$table->date('date');
			$table->date('from');
			$table->date('to');
			$table->integer('country_id')->index('travelling_country_id');
			$table->text('reason', 65535);
			$table->text('objectives', 65535);
			$table->boolean('want_visa')->nullable()->default(2)->comment('0 = no , 1 = yes , 2= not set');
			$table->boolean('manager_approved')->nullable()->default(2)->comment('0 = no , 1 = yes , 2= not set');
			$table->text('manager_reason', 65535)->nullable();
			$table->integer('hotel_cost')->nullable();
			$table->integer('airline_ticket_cost')->nullable();
			$table->integer('per_diem_cost')->nullable();
			$table->integer('visa_cost')->nullable();
			$table->integer('total_cost')->nullable();
			$table->boolean('cfo_approve')->nullable()->default(2)->comment('0 = no , 1 = yes , 2= not set');
			$table->text('cfo_reason', 65535)->nullable();
			$table->boolean('ceo_approve')->nullable()->default(2)->comment('0 = no , 1 = yes , 2= not set');
			$table->text('ceo_reason', 65535)->nullable();
			$table->text('admin_notes', 65535)->nullable();
			$table->boolean('manager_escalated')->default(0)->comment('0=no , 1 = yes  ( Escalation to direct manager )');
			$table->boolean('admin_escalated')->default(0)->comment('0=no , 1 =yes');
			$table->boolean('cfo_escalated')->default(0)->comment('0=no , 1=yes');
			$table->boolean('end_escalation')->default(0)->comment('0=n0 , 1 =yes');
			$table->integer('entry_by')->nullable();
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
		Schema::drop('tb_travellings');
	}

}
