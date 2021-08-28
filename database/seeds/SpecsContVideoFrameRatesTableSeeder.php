<?php

use Illuminate\Database\Seeder;

class SpecsContVideoFrameRatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_video_frame_rates')->delete();
        
        \DB::table('specs_cont_video_frame_rates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'video_frame_rate_title' => '8',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'video_frame_rate_title' => '12',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'video_frame_rate_title' => '15',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'video_frame_rate_title' => '23.976',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'video_frame_rate_title' => '24',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'video_frame_rate_title' => '25',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'video_frame_rate_title' => '30',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'video_frame_rate_title' => '50',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'video_frame_rate_title' => '59.94',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'video_frame_rate_title' => '60',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            10 => 
            array (
                'id' => 11,
                'video_frame_rate_title' => '120',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
