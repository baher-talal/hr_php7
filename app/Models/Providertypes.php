<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class providertypes extends Sximo  {
	
	protected $table = 'provider_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT provider_types.* FROM provider_types  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE provider_types.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
