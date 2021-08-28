<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('group_id')->nullable();
			$table->string('username', 100);
			$table->string('password', 64);
			$table->string('email', 100);
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			$table->string('avatar', 100)->nullable();
			$table->boolean('active')->nullable();
			$table->integer('department_id')->nullable();
			$table->boolean('login_attempt')->nullable()->default(0);
			$table->dateTime('last_login')->nullable();
			$table->timestamps();
			$table->string('reminder', 64)->nullable();
			$table->string('activation', 50)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->integer('last_activity');
			$table->string('mobile_token')->nullable();
			$table->boolean('is_login')->nullable()->default(0)->comment('0 = not login , 1= login');
			$table->integer('entry_by')->nullable();
			$table->decimal('annual_credit', 10, 1)->nullable()->default(0.0);
			$table->boolean('per_diem_position_id')->default(1)->comment('1= employee  , 2 = manager');
			$table->string('phone_number', 20)->nullable();
			$table->integer('employee_finger_id')->nullable();
			$table->boolean('ivas_login_inside')->nullable()->default(0)->comment('0= default outside , 1 = login inside');
			$table->string('cv')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_users');
	}

}
