<?php

use Illuminate\Database\Seeder;

class TbGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tb_groups')->delete();
        
        \DB::table('tb_groups')->insert(array (
            0 => 
            array (
                'group_id' => 1,
                'name' => 'Superadmin',
                'description' => 'Root Superadmin',
                'level' => 1,
                'entry_by' => NULL,
            ),
            1 => 
            array (
                'group_id' => 2,
                'name' => 'CEO',
                'description' => 'CEO group',
                'level' => 2,
                'entry_by' => 2,
            ),
            2 => 
            array (
                'group_id' => 3,
                'name' => 'HR',
                'description' => 'Human Resource',
                'level' => 3,
                'entry_by' => 2,
            ),
            3 => 
            array (
                'group_id' => 5,
                'name' => 'Manager',
                'description' => 'Manager group',
                'level' => 4,
                'entry_by' => NULL,
            ),
            4 => 
            array (
                'group_id' => 6,
                'name' => 'Employee',
                'description' => 'Employee group',
                'level' => 5,
                'entry_by' => NULL,
            ),
            5 => 
            array (
                'group_id' => 7,
                'name' => 'HR Reports',
                'description' => 'view only all modules and make reports',
                'level' => 6,
                'entry_by' => NULL,
            ),
            6 => 
            array (
                'group_id' => 8,
                'name' => 'admin',
                'description' => 'that determine cost for travelling',
                'level' => 8,
                'entry_by' => NULL,
            ),
            7 => 
            array (
                'group_id' => 9,
                'name' => 'CFO',
                'description' => 'finance role',
                'level' => 9,
                'entry_by' => NULL,
            ),
            8 => 
            array (
                'group_id' => 10,
                'name' => 'Project Coordinate',
                'description' => 'see all modules related to task management only ',
                'level' => 10,
                'entry_by' => NULL,
            ),
            9 => 
            array (
                'group_id' => 11,
                'name' => 'Providers',
                'description' => '',
                'level' => 11,
                'entry_by' => NULL,
            ),
        ));
        
        
    }
}
