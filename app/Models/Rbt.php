<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class rbt extends Sximo  {
	
	protected $table = 'rbts';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT rbts.* FROM rbts  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE rbts.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
