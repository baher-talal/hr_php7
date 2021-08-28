<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder2 extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
           
        
        \DB::table('tb_menu')->insert(array (
            0 => 
            array (
                'menu_id' => 100,
                'parent_id' => 0,
                'module' => '',
                'url' => 'http://localhost/hr/searchTables',
                'menu_name' => 'Search',
                'menu_type' => 'external',
                'ordering' => NULL,
                'position' => 'sidebar',
                'menu_icons' => 'icon-filter',
                'active' => 1,
                'access_data' => '{"1":"1","2":"0","3":"0","5":"0","6":"0","7":"0","8":"0","9":"0"}',
                'allow_guest' => NULL,
            )
        ));
        
        
    }
}
