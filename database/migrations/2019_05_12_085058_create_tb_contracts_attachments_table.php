<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbContractsAttachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_contracts_attachments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('attachment_path');
			$table->integer('contract_id')->index('country_id');
			$table->timestamps();
			$table->integer('attachment_type_id')->index('tb_contracts_attachments_attachment_type_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_contracts_attachments');
	}

}
