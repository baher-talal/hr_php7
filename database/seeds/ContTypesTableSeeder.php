<?php

use Illuminate\Database\Seeder;

class ContTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cont_types')->delete();
        
        \DB::table('cont_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'cont_type_title' => 'Audio',
                'created_at' => '2018-11-01 11:10:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'cont_type_title' => 'Video',
                'created_at' => '2018-11-01 11:10:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'cont_type_title' => 'Image',
                'created_at' => '2018-11-01 11:10:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'cont_type_title' => 'Document',
                'created_at' => '2018-11-01 11:10:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
