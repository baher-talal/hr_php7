<?php

use Illuminate\Database\Seeder;

class SpecsContMediaFormatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('specs_cont_media_formats')->delete();

        \DB::table('specs_cont_media_formats')->insert(array (
            0 =>
            array (
                'id' => 1,
                'media_format_title' => 'WAV',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'media_format_title' => 'AIFF',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            2 =>
            array (
                'id' => 3,
                'media_format_title' => 'MP3',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            3 =>
            array (
                'id' => 4,
                'media_format_title' => 'OOG',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            4 =>
            array (
                'id' => 5,
                'media_format_title' => 'AAC',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            5 =>
            array (
                'id' => 6,
                'media_format_title' => 'FLAC',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            6 =>
            array (
                'id' => 7,
                'media_format_title' => 'ALAC',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            7 =>
            array (
                'id' => 8,
                'media_format_title' => 'WMA',
                'cont_type_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            8 =>
            array (
                'id' => 9,
                'media_format_title' => 'AVI',
                'cont_type_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            9 =>
            array (
                'id' => 10,
                'media_format_title' => 'MOV',
                'cont_type_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            10 =>
            array (
                'id' => 11,
                'media_format_title' => 'MP4',
                'cont_type_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            11 =>
            array (
                'id' => 12,
                'media_format_title' => 'FLA',
                'cont_type_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            12 =>
            array (
                'id' => 13,
                'media_format_title' => 'WMV',
                'cont_type_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            13 =>
            array (
                'id' => 14,
                'media_format_title' => '3GP',
                'cont_type_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            14 =>
            array (
                'id' => 15,
                'media_format_title' => 'PSD',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            15 =>
            array (
                'id' => 16,
                'media_format_title' => 'AI',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            16 =>
            array (
                'id' => 17,
                'media_format_title' => 'SVG',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            17 =>
            array (
                'id' => 18,
                'media_format_title' => 'TTIF',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            18 =>
            array (
                'id' => 19,
                'media_format_title' => 'EPC',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            19 =>
            array (
                'id' => 20,
                'media_format_title' => 'JPEG',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            20 =>
            array (
                'id' => 21,
                'media_format_title' => 'PNG',
                'cont_type_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            21 =>
            array (
                'id' => 22,
            'media_format_title' => 'DOC, DOCX (word file)',
                'cont_type_id' => 4,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            22 =>
            array (
                'id' => 23,
            'media_format_title' => 'XLS, XLSX (excel file)',
                'cont_type_id' => 4,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            23 =>
            array (
                'id' => 24,
                'media_format_title' => 'PDF',
                'cont_type_id' => 4,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
            24 =>
            array (
                'id' => 25,
                'media_format_title' => 'TXT',
                'cont_type_id' => 4,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'entry_by' => 0,
            ),
        ));


    }
}
