<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class vacationtypes extends Sximo  {
	
	protected $table = 'tb_vacation_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_vacation_types.* FROM tb_vacation_types  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_vacation_types.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
