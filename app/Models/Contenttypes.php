<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contenttypes extends Sximo  {
	
	protected $table = 'cont_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT cont_types.* FROM cont_types  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE cont_types.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
