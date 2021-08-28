<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class perdiempositions extends Sximo  {
	
	protected $table = 'tb_per_diem_positions';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_per_diem_positions.* FROM tb_per_diem_positions  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_per_diem_positions.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
