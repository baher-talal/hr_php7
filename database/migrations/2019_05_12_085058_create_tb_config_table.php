<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_config', function(Blueprint $table)
		{
			$table->integer('cnf_id', true);
			$table->string('cnf_appname')->nullable();
			$table->text('cnf_appdesc', 65535)->nullable();
			$table->string('cnf_comname', 200)->nullable();
			$table->string('cnf_email', 100)->nullable();
			$table->string('cnf_metakey')->nullable();
			$table->text('cnf_metadesc', 65535)->nullable();
			$table->string('cnf_logo')->nullable();
			$table->integer('cnf_vacation_days');
			$table->string('cnf_start_hour', 10)->nullable();
			$table->string('cnf_end_hour', 10)->nullable();
			$table->integer('cnf_tolerance');
			$table->string('cnf_weekdays', 50)->nullable();
			$table->boolean('cnf_show_builder_tool')->nullable()->default(0);
			$table->integer('vacations_per_year')->nullable();
			$table->integer('permissions_per_month')->nullable();
			$table->string('delay_notifications_email');
			$table->string('permissions_hours_per_month')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_config');
	}

}
