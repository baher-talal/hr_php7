<?php

use Illuminate\Database\Seeder;

class SpecsContVideoFormatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_video_formats')->delete();
        
        \DB::table('specs_cont_video_formats')->insert(array (
            0 => 
            array (
                'id' => 1,
            'video_format_title' => 'DV (24p Advanced)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'video_format_title' => 'DV NTSC',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'video_format_title' => 'DV PAL',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'video_format_title' => 'Intel IYUV codec',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'video_format_title' => 'Intel IYUV codec',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'video_format_title' => 'TechSmith Screen Capture Codec',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'video_format_title' => 'TechSmith Screen Codec 2',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'video_format_title' => 'Uncompressed UYVY 422 8bit',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'video_format_title' => 'V210 10-bit YUV',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'video_format_title' => 'None',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            10 => 
            array (
                'id' => 11,
                'video_format_title' => 'Animation',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            11 => 
            array (
                'id' => 12,
                'video_format_title' => 'DNxHR/DNXHD',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            12 => 
            array (
                'id' => 13,
                'video_format_title' => 'DV/NTSC 24p',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            13 => 
            array (
                'id' => 14,
                'video_format_title' => 'DVZS NTSC',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            14 => 
            array (
                'id' => 15,
                'video_format_title' => 'DVZS PAL',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            15 => 
            array (
                'id' => 16,
                'video_format_title' => 'DVSO NTSC',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            16 => 
            array (
                'id' => 17,
                'video_format_title' => 'DVSO PAL',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            17 => 
            array (
                'id' => 18,
                'video_format_title' => 'DVCPRO HD 108oi50',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            18 => 
            array (
                'id' => 19,
                'video_format_title' => 'DVCPRO HD 108oi60',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            19 => 
            array (
                'id' => 20,
                'video_format_title' => 'DVCPRO HD 108op25',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            20 => 
            array (
                'id' => 21,
                'video_format_title' => 'DVCPRO HD 108op30',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            21 => 
            array (
                'id' => 22,
                'video_format_title' => 'DVC P Ro HD 72op50',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            22 => 
            array (
                'id' => 23,
                'video_format_title' => 'DVCPRO HD 72op60',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            23 => 
            array (
                'id' => 24,
                'video_format_title' => 'GOP ro CineForm',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            24 => 
            array (
                'id' => 25,
            'video_format_title' => 'None (Uncompressed RGB 8-bit)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            25 => 
            array (
                'id' => 26,
                'video_format_title' => 'Uncompressed YUV 10 bit 4:2:2',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            26 => 
            array (
                'id' => 27,
                'video_format_title' => 'Uncompressed YUV 8 bit 4:2:2',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
