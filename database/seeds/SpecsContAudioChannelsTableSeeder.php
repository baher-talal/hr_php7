<?php

use Illuminate\Database\Seeder;

class SpecsContAudioChannelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_audio_channels')->delete();
        
        \DB::table('specs_cont_audio_channels')->insert(array (
            0 => 
            array (
                'id' => 1,
                'channel_title' => 'Mono Mix',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'channel_title' => 'Mono Left',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'channel_title' => 'Mono Right',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'channel_title' => 'Stereo',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
