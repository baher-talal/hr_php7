<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('provider_type_id')->default(2)->index('provider_type_id');
			$table->string('company_name', 100);
			$table->string('company_phone', 20);
			$table->string('company_post_office', 50);
			$table->string('company_address', 200);
			$table->string('company_cr_no', 20);
			$table->date('company_cr_date');
			$table->string('company_cr_file', 100);
			$table->string('company_tc_no', 20);
			$table->string('company_tc_file', 100);
			$table->string('company_agent_name', 20);
			$table->string('company_agent_file', 100);
			$table->string('company_admin_name');
			$table->string('company_admin_email', 50);
			$table->string('company_admin_mobile', 20);
			$table->timestamps();
			$table->integer('entry_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companies');
	}

}
