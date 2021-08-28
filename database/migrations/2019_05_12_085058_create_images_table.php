<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('image_title', 160);
			$table->integer('provider_id')->index('provider_id');
			$table->integer('country_id')->index('country_id');
			$table->integer('operators_id')->index('operators_id');
			$table->string('image_path', 200);
			$table->boolean('image_status')->default(0);
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
		Schema::drop('images');
	}

}
