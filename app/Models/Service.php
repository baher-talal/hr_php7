<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class service extends Sximo  {
	
	protected $table = 'tb_services';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_services.* FROM tb_services  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_services.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
