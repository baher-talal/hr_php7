<?php

use Illuminate\Database\Seeder;

class ContCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('cont_categories')->delete();

        \DB::table('cont_categories')->insert(array (
            0 =>
            array (
                'id' => 1,
                'cont_category_title' => 'Public',
                'created_at' => '2018-11-01 09:10:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'cont_category_title' => 'Social',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 =>
            array (
                'id' => 3,
                'cont_category_title' => 'literature',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 =>
            array (
                'id' => 4,
                'cont_category_title' => 'Religious',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 =>
            array (
                'id' => 5,
                'cont_category_title' => 'Entertainment',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 =>
            array (
                'id' => 6,
                'cont_category_title' => 'Sports',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 =>
            array (
                'id' => 7,
                'cont_category_title' => 'National',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            7 =>
            array (
                'id' => 8,
                'cont_category_title' => 'Woman',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            8 =>
            array (
                'id' => 9,
                'cont_category_title' => 'Children',
                'created_at' => '2018-11-01 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));


    }
}
