<?php

use Illuminate\Database\Seeder;

class SpecsContAudioFormatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_audio_formats')->delete();
        
        \DB::table('specs_cont_audio_formats')->insert(array (
            0 => 
            array (
                'id' => 1,
                'audio_format_title' => 'CCITT A-Law',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'audio_format_title' => 'CCITT u-Law',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'audio_format_title' => 'GSM 6.10',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
            'audio_format_title' => 'IEEE Float (uncompressed)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'audio_format_title' => 'IMA ADPCM',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'audio_format_title' => 'Microsoft ADPCM',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 => 
            array (
                'id' => 7,
            'audio_format_title' => 'PCM (uncompressed)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
