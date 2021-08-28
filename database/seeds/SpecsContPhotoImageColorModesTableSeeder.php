<?php

use Illuminate\Database\Seeder;

class SpecsContPhotoImageColorModesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('specs_cont_photo_image_color_modes')->delete();
        
        \DB::table('specs_cont_photo_image_color_modes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'photo_color_mode_title' => 'Bitmap',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'photo_color_mode_title' => 'Grayscale',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'photo_color_mode_title' => 'RGB Color',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'photo_color_mode_title' => 'CMYK Color',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'photo_color_mode_title' => 'Lab Color',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));
        
        
    }
}
