<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
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
                'menu_id' => 98,
                'parent_id' => 19,
                'module' => '',
                'url' => 'http://localhost/hr/database_backups',
                'menu_name' => 'DataBase',
                'menu_type' => 'external',
                'ordering' => '3',
                'position' => 'sidebar',
                'menu_icons' => 'icon-database',
                'active' => 1,
                'access_data' => '{"1":"1","2":"0","3":"0","5":"0","6":"0","7":"0","8":"0","9":"0"}',
                'allow_guest' => NULL,
            )
            ,1 => 
            array (
                'menu_id' => 99,
                'parent_id' => 19,
                'module' => '',
                'url' => 'http://localhost/hr/core/elfinder',
                'menu_name' => 'File Manager',
                'menu_type' => 'external',
                'ordering' => '4',
                'position' => 'sidebar',
                'menu_icons' => 'icon-folder',
                'active' => 1,
                'access_data' => '{"1":"1","2":"0","3":"0","5":"0","6":"0","7":"0","8":"0","9":"0"}',
                'allow_guest' => NULL,
            )
        ));
        
        
    }
}
