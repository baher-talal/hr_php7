<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contracts extends Sximo {

    protected $table = 'tb_contracts';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct();
    }

    public static function querySelect() {

        return "  SELECT tb_contracts.* FROM tb_contracts  ";
    }

    public static function queryWhere() {

        return "  WHERE tb_contracts.id IS NOT NULL ";
    }

    public static function queryGroup() {
        return "  ";
    }

    public function operator() {
        return $this->belongsToMany('App\Models\Operator');
    }

    public function service() {
        return $this->belongsToMany('App\Models\Service');
    }
    
     public function attachments() {
        return $this->hasMany('App\Models\Contractsattachments', 'contract_id');
    }    
   
    public function item() {
        return $this->hasMany('App\Models\Contractsitems','contract_id');
    }
    
    public function country() {
        return $this->belongsToMany('App\Models\Countries','contracts_operator');
    }
    public function approve() {
        return $this->belongsToMany('App\Models\contractapproves', 'contract_approves','contract_id');
    }
 
}
