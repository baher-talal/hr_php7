<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class countryperdiem extends Sximo  {
	
	protected $table = 'tb_country_per_diem';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_country_per_diem.* FROM tb_country_per_diem  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_country_per_diem.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
