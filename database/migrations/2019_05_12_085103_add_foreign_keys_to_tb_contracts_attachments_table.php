<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbContractsAttachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_contracts_attachments', function(Blueprint $table)
		{
			$table->foreign('attachment_type_id', 'tb_contracts_attachments_ibfk_1')->references('id')->on('attachment_types')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_contracts_attachments', function(Blueprint $table)
		{
			$table->dropForeign('tb_contracts_attachments_ibfk_1');
		});
	}

}
