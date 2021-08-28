<?php

use Illuminate\Database\Seeder;

class AggregatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('aggregators')->delete();
        
        \DB::table('aggregators')->insert(array (
            0 => 
            array (
                'id' => 1,
                'aggregator_name' => 'iVAS',
                'aggregator_phone' => '+20233054296',
                'aggregator_mobile' => '+201140700007',
                'aggregator_post_office' => '',
                'aggregator_email' => 'haitham@ivas.com.eg',
                'aggregator_address' => '11 Aboelkaramat, Agouza, Giza, Egypt.',
                'aggregator_admin' => 'Haitham Shaker',
                'aggregator_join_date' => '2014-01-01',
                'entry_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}
