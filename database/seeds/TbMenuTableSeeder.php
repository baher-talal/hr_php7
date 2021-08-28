<?php

use Illuminate\Database\Seeder;

class TbMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

       
        
        \DB::table('tb_menu')->insert(array (
            
            55 => 
            array (
                'menu_id' => 118,
                'parent_id' => 0,
                'module' => 'contracts',
                'url' => '',
                'menu_name' => 'Contracts Requests',
                'menu_type' => 'internal',
                'role_id' => NULL,
                'deep' => NULL,
                'ordering' => 39,
                'position' => 'sidebar',
                'menu_icons' => 'fa  fa-folder',
                'active' => '1',
                'access_data' => '{"1":"1","2":"0","3":"0","5":"1","6":"1","7":"0","8":"0","9":"0","10":"0","11":"0"}',
                'allow_guest' => NULL,
                'menu_lang' => NULL,
            ),
            
        ));
        
        
    }
}
