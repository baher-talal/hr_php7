<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class employeespermissions extends Sximo  {
	
	protected $table = 'tb_permissions';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_permissions.* FROM tb_permissions  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_permissions.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}