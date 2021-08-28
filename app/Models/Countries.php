<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class countries extends Sximo  {
	
	protected $table = 'tb_countries';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_countries.* FROM tb_countries  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_countries.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
