<?php

use Illuminate\Database\Seeder;

class TbOperatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tb_operators')->delete();
        
        \DB::table('tb_operators')->insert(array (
            0 => 
            array (
                'id' => 7,
                'name' => 'زين',
                'country_id' => 1,
                'created_at' => '2018-09-10 11:19:06',
                'updated_at' => '2018-09-30 13:04:32',
                'entry_by' => 116,
            ),
            1 => 
            array (
                'id' => 8,
                'name' => 'اتصالات',
                'country_id' => 1,
                'created_at' => '2018-09-24 10:54:50',
                'updated_at' => '2018-09-24 10:54:50',
                'entry_by' => 116,
            ),
            2 => 
            array (
                'id' => 101,
                'name' => 'زين',
                'country_id' => 2,
                'created_at' => '2018-09-30 13:04:24',
                'updated_at' => '2018-09-30 13:04:24',
                'entry_by' => 116,
            ),
            3 => 
            array (
                'id' => 102,
                'name' => 'اتصالات',
                'country_id' => 5,
                'created_at' => '2018-09-30 13:05:39',
                'updated_at' => '2018-09-30 13:05:53',
                'entry_by' => 116,
            ),
        ));
        
        
    }
}
