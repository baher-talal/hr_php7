<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class deductions extends Sximo  {
	
	protected $table = 'tb_deductions';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_deductions.* FROM tb_deductions  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_deductions.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
