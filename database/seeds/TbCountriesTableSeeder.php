<?php

use Illuminate\Database\Seeder;

class TbCountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tb_countries')->delete();
        
        \DB::table('tb_countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'country' => 'السعوديه',
                'currency' => 'RS',
                'entry_by' => 1,
                'created_at' => '2017-07-18 12:54:06',
                'updated_at' => '2018-11-14 16:41:45',
                'account_manager_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'country' => 'الكويت',
                'currency' => 'DK',
                'entry_by' => 1,
                'created_at' => '2017-07-18 12:54:20',
                'updated_at' => '2018-11-14 16:41:38',
                'account_manager_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'country' => 'الأدرن',
                'currency' => 'JOD',
                'entry_by' => 1,
                'created_at' => '2017-07-18 12:55:14',
                'updated_at' => '2018-11-14 16:41:29',
                'account_manager_id' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'country' => 'تونس',
                'currency' => 'TND',
                'entry_by' => 1,
                'created_at' => '2017-07-24 12:49:10',
                'updated_at' => '2018-11-14 16:41:23',
                'account_manager_id' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'country' => 'مصر',
                'currency' => 'LE',
                'entry_by' => 1,
                'created_at' => '2017-08-28 17:06:29',
                'updated_at' => '2018-11-14 16:41:10',
                'account_manager_id' => NULL,
            ),
        ));
        
        
    }
}
