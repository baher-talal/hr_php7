<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class aggregators extends Sximo  {
	
	protected $table = 'aggregators';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT aggregators.* FROM aggregators  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE aggregators.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
