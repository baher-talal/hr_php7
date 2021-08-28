<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOriginalContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('original_contents', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('provider_id')->index('provider_id');
			$table->integer('content_type_id')->index('content_type_id');
			$table->integer('occasion_id')->index('occasion_id');
			$table->string('original_title', 100);
			$table->string('original_path', 300);
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
		Schema::drop('original_contents');
	}

}
