<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'myvacations/comboselect',
        'mytravelling/comboselect',
        'operator/comboselect',
        'report/get_statistics',
        'notifications/comboselect',
        'track/upload',
        'travelling/comboselect',
        'sximo/module/combotable',
        'sximo/module/combotablefield',
        'commitments/comboselect',
        'core/elfinder',
        'campaignalbums/comboselect',
        'track/comboselect',
        'occasions/comboselect',
        'audiometadata/comboselect',
        'originalcontents/comboselect',
        'finalvideo/comboselect',
        'finalimage/comboselect',
        'departments/comboselect',
        'deductions/comboselect',
        'delaynotifications/comboselectuser',
        'rbt/get_statistics',
        'rbt/comboselect',
        'punchnotifications/comboselectuser',
        'notifications/upnotifications',
        'rbt/search',
        'report/search',
        'rbt/save_tracks',
        'countryperdiem/comboselect',
        'contracts/comboselect',
        'acquisitions/comboselect',
        'notifications/seennotification'
    ];
}
