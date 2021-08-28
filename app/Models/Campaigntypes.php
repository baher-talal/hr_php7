<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class campaigntypes extends Sximo  {
	
	protected $table = 'campaign_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT campaign_types.* FROM campaign_types  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE campaign_types.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
