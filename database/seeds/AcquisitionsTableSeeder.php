<?php

use Illuminate\Database\Seeder;

class AcquisitionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('acquisitions')->delete();
        
        \DB::table('acquisitions')->insert(array (
            0 => 
            array (
                'id' => 16,
                'provider_id' => 1,
                'wikipedia' => '',
                'youtube' => '',
                'facebook' => '',
                'twitter' => '',
                'instagram' => '',
                'sample_links' => '',
                'content_type' => 1,
                'content_classification' => 'rbt',
                'business_case' => '1543745746-70178521.xlsx',
                'brand_manager_id' => 133,
                'operation_approve' => 1,
                'finance_approve' => 1,
                'legal_approve' => 1,
                'ceo_cancel' => 0,
                'final_approve' => 1,
                'created_at' => '2018-12-02 12:15:46',
                'updated_at' => '2018-12-04 14:56:28',
            ),
            1 => 
            array (
                'id' => 17,
                'provider_id' => 4,
                'wikipedia' => 'wi',
                'youtube' => 'yt',
                'facebook' => 'fa',
                'twitter' => 'tw',
                'instagram' => 'in',
                'sample_links' => 'http://localhost/hr/acquisitions/update
http://localhost/hr/acquisitions/update',
                'content_type' => 2,
                'content_classification' => 'rbt',
                'business_case' => '1543929268-17914639.xlsx',
                'brand_manager_id' => 39,
                'operation_approve' => 0,
                'finance_approve' => 0,
                'legal_approve' => 0,
                'ceo_cancel' => 0,
                'final_approve' => 0,
                'created_at' => '2018-12-04 15:14:28',
                'updated_at' => '2018-12-04 16:51:22',
            ),
        ));
        
        
    }
}
