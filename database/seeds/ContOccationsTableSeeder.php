<?php

use Illuminate\Database\Seeder;

class ContOccationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cont_occations')->delete();
        
        \DB::table('cont_occations')->insert(array (
            0 => 
            array (
                'id' => 3,
                'cont_occation_name' => 'Ramadan',
            'cont_occation_description' => '<span style="font-weight: bold;">Ramadan </span>is the ninth month of the Islamic calendar, and is observed by Muslims worldwide as a month of fasting (Sawm) to commemorate the first revelation of the Quran to Muhammad according to Islamic belief.<br>',
                'cont_occation_date' => '2018-05-13',
                'category_id' => 4,
                'country_id' => 7,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 4,
                'cont_occation_name' => 'Hajj',
                'cont_occation_description' => '<p>The Hajj is an annual Islamic pilgrimage to Mecca, Saudi Arabia, the holiest city for Muslims, and a mandatory religious duty for Muslims that must be carried out at least once in their lifetime by all adult Muslims who are physically and financially c',
                'cont_occation_date' => '2018-11-01',
                'category_id' => 1,
                'country_id' => 7,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
