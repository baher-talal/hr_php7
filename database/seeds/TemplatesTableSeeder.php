<?php

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('templates')->delete();
        
        \DB::table('templates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'عقد استغلال مصنفات فنية',
                'created_at' => '2018-11-12 10:07:11',
                'updated_at' => '2018-11-12 10:07:11',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'عقد استغلال محتوي لتقديم خدمات القيمة المضافة	',
                'created_at' => '2018-10-25 10:36:19',
                'updated_at' => '2018-10-30 16:06:17',
            ),
        ));
        
        
    }
}
