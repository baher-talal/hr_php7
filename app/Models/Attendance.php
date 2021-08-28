<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class attendance extends Sximo  {
	
	protected $table = 'tb_attendance';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_attendance.* FROM tb_attendance  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_attendance.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
