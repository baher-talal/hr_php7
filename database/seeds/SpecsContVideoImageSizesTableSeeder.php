<?php

use Illuminate\Database\Seeder;

class SpecsContVideoImageSizesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_video_image_sizes')->delete();
        
        \DB::table('specs_cont_video_image_sizes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'video_image_size' => 'NTSC DV [720 X 480]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'video_image_size' => 'NTSC D1 [720 X 486]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'video_image_size' => 'NTSC DVSP [720 X 534]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'video_image_size' => 'NTSC D1 WSP [872 X 486]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'video_image_size' => 'PAL D1/DV [720 X 576]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'video_image_size' => 'PAL D1/DVSP [788 X 576]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'video_image_size' => 'PAL D1/DVWSP [1050 X 576]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'video_image_size' => 'HDV/HDTV [1280 X 720]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'video_image_size' => 'HDV [1440 X 1080]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'video_image_size' => 'DVCPRO HD [960 X 720]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            10 => 
            array (
                'id' => 11,
                'video_image_size' => 'DVCPRO HDSP [1440 X 1080]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            11 => 
            array (
                'id' => 12,
                'video_image_size' => 'DVCPRO HDW [1280 X 1080]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            12 => 
            array (
                'id' => 13,
                'video_image_size' => 'HDTV [1920 X 1080]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            13 => 
            array (
                'id' => 14,
                'video_image_size' => 'UHD 4K [3840 X 2160]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            14 => 
            array (
                'id' => 15,
                'video_image_size' => 'UHD 8K [7680 X 4320]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            15 => 
            array (
                'id' => 16,
                'video_image_size' => 'Cineon Half [1828 X 1332]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            16 => 
            array (
                'id' => 17,
                'video_image_size' => 'Cineon Full [3656 X 2664]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            17 => 
            array (
                'id' => 18,
                'video_image_size' => 'Film 2K [2048 X 1556]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            18 => 
            array (
                'id' => 19,
                'video_image_size' => 'Film 4K [4096 X 3112]',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
