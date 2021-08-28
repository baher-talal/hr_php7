<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_tracks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('album_id')->index('tracks_album_fk');
			$table->string('web_audition_preview');
			$table->string('aip_play_rbt');
			$table->string('wap_audition_rbt');
			$table->string('rbt_name');
			$table->string('initial_rbt_name', 3);
			$table->string('singer_name');
			$table->string('initial_singer_name', 3);
			$table->boolean('singer_gender')->comment(' (1 for male, 2 for female, and -1 for singer group) ');
			$table->integer('value_of_category');
			$table->text('rbt_information', 65535)->nullable();
			$table->integer('rbt_price')->nullable()->default(5);
			$table->date('validity_period_rbt');
			$table->integer('language_code')->nullable();
			$table->integer('relative_expiry_rbt')->nullable()->default(30);
			$table->string('language_prompt_rbt');
			$table->integer('allowed_cut')->default(0);
			$table->string('movie_name');
			$table->string('sub_cp_id', 1)->nullable();
			$table->integer('price_group_id')->nullable()->default(10001);
			$table->string('company_lyrics', 1);
			$table->string('dt_lyrics', 1)->nullable();
			$table->string('company_id_tune', 1)->nullable();
			$table->date('date_tune');
			$table->string('company_id', 1)->nullable();
			$table->string('validity_date', 1)->nullable();
			$table->string('allowed_channels', 5)->nullable()->default('ALL');
			$table->boolean('renew_allowed')->nullable()->default(1);
			$table->string('max_download_times', 1)->nullable();
			$table->boolean('multiple_language_code')->nullable()->default(4);
			$table->string('rbt_name_ml');
			$table->string('singer_name_ml');
			$table->integer('entry_by')->nullable();
			$table->timestamps();
			$table->string('track_path');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_tracks');
	}

}
