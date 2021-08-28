<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contractsitems extends Sximo  {
	
	protected $table = 'contract_items';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT contract_items.* FROM contract_items  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE contract_items.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
