<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcquisitionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acquisitions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('provider_id')->nullable()->index();
			$table->string('wikipedia')->nullable();
			$table->string('youtube')->nullable();
			$table->string('facebook')->nullable();
			$table->string('twitter')->nullable();
			$table->string('instagram')->nullable();
			$table->text('sample_links', 65535)->nullable();
			$table->boolean('content_type')->comment('1:In / 2:Out');
			$table->text('content_classification', 65535)->nullable();
			$table->string('business_case');
			$table->integer('brand_manager_id')->index('brand_manager_id');
			$table->boolean('operation_approve');
			$table->boolean('finance_approve');
			$table->boolean('legal_approve');
			$table->boolean('ceo_cancel');
			$table->boolean('final_approve');
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
		Schema::drop('acquisitions');
	}

}
