<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddValuesToPermissionsHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tb_permissions_hours')->insert(['value' => '06:00 pm', 'created_at' => now()]);
        DB::table('tb_permissions_hours')->insert(['value' => '07:00 pm', 'created_at' => now()]);


        DB::statement("ALTER TABLE `tb_config` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `permissions_hours_per_month`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`");
        DB::statement("ALTER TABLE `tb_config` ADD `sms` INT(10) NOT NULL AFTER `permissions_hours_per_month`;");
        DB::statement("ALTER TABLE `tb_config` ADD `enable_vacation_all_days` INT(1) NULL DEFAULT NULL COMMENT '1 = enable/0 = not enable' AFTER `sms`;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
