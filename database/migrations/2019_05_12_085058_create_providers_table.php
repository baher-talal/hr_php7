<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('providers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('provider_name', 60);
			$table->string('provider_logo', 200);
			$table->string('provider_address', 100);
			$table->string('provider_po_no', 30);
			$table->string('provider_email', 60);
			$table->string('provider_mobile', 20);
			$table->string('provider_phone', 20);
			$table->string('provider_bank_account_name', 60);
			$table->string('provider_bank_account_no', 25);
			$table->string('provider_admin_name', 60);
			$table->string('provider_admin_email', 60);
			$table->string('provider_admin_mobile', 20);
			$table->boolean('provider_status')->default(1);
			$table->date('provider_joining_date');
			$table->string('provider_identity_no', 40);
			$table->string('provider_identity_file', 40);
			$table->string('provider_commercial_register_no', 60);
			$table->date('provider_commercial_register_date');
			$table->string('provider_commercial_register_file', 100);
			$table->string('provider_tax_card_no', 60);
			$table->string('provider_tax_card_file', 100);
			$table->string('provider_agent_name', 60);
			$table->string('provider_agent_file', 100);
			$table->timestamps();
			$table->integer('entry_by');
			$table->integer('provider_type_id')->index('providers_provider_type_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('providers');
	}

}
