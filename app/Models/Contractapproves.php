<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contractapproves extends Sximo  {
	
	protected $table = 'contract_approves';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT contract_approves.* FROM contract_approves  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE contract_approves.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
