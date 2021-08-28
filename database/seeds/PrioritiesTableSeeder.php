<?php

use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('priorities')->delete();
        
        \DB::table('priorities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'value' => 'urgent',
            ),
            1 => 
            array (
                'id' => 2,
                'value' => 'high ',
            ),
            2 => 
            array (
                'id' => 3,
                'value' => 'normal',
            ),
            3 => 
            array (
                'id' => 4,
                'value' => 'low',
            ),
        ));
        
        
    }
}
