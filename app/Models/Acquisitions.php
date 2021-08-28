<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class acquisitions extends Sximo {

    protected $table = 'acquisitions';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct();
    }

    public static function querySelect() {

        return "  SELECT acquisitions.* FROM acquisitions  ";
    }

    public static function queryWhere() {

        return "  WHERE acquisitions.id IS NOT NULL ";
    }

    public static function queryGroup() {
        return "  ";
    }

    public function country() {
        return $this->belongsToMany('App\Models\Countries', 'acquisition_region','acquisition_id');
    }
    
    public function approve() {
        return $this->belongsToMany('App\Models\acquisitionapproves', 'acquisition_approves','acquisition_id');
    }

}
