<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class departments extends Sximo  {
	
	protected $table = 'tb_departments';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_departments.* FROM tb_departments  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_departments.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
