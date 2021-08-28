<?php

use Illuminate\Database\Seeder;

class SpecsContAudioSampleRateTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_audio_sample_rate')->delete();
        
        \DB::table('specs_cont_audio_sample_rate')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sample_rate_title' => '192,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'sample_rate_title' => '176,400 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'sample_rate_title' => '96,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'sample_rate_title' => '88,200 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'sample_rate_title' => '64,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'sample_rate_title' => '48,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'sample_rate_title' => '44,100 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'sample_rate_title' => '32,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'sample_rate_title' => '22,050 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'sample_rate_title' => '16,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            10 => 
            array (
                'id' => 11,
                'sample_rate_title' => '11,025 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            11 => 
            array (
                'id' => 12,
                'sample_rate_title' => '8,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            12 => 
            array (
                'id' => 13,
                'sample_rate_title' => '6,000 Hz',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
