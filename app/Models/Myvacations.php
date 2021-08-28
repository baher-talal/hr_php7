<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class myvacations extends Sximo  {
	
	protected $table = 'tb_vacations';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_vacations.* FROM tb_vacations  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_vacations.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
