<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class occasions extends Sximo  {
	
	protected $table = 'occasions';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT occasions.* FROM occasions  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE occasions.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
