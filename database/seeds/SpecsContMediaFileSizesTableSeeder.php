<?php

use Illuminate\Database\Seeder;

class SpecsContMediaFileSizesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('specs_cont_media_file_sizes')->delete();

        \DB::table('specs_cont_media_file_sizes')->insert(array (
            0 =>
            array (
                'id' => 1,
            'file_size_title' => 'Less than 600 kb (services)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 =>
            array (
                'id' => 2,
            'file_size_title' => 'Less than 1024 kbps 600 kb (services)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 =>
            array (
                'id' => 3,
            'file_size_title' => 'Less than 1536 kb (services)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 =>
            array (
                'id' => 4,
            'file_size_title' => 'Less than 3072 kb (services)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 =>
            array (
                'id' => 5,
            'file_size_title' => 'Less than 5120 kb (bundle & redirect link)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 =>
            array (
                'id' => 6,
            'file_size_title' => 'Less than 10240 kb (service sample)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 =>
            array (
                'id' => 7,
            'file_size_title' => 'Unlimited (social media & digital platforms & TV)',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));


    }
}
