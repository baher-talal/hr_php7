<?php

use Illuminate\Database\Seeder;

class AttachmentTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attachment_types')->delete();
        
        \DB::table('attachment_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'contract final preview',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'annex',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'authorization letter',
            ),
        ));
        
        
    }
}
