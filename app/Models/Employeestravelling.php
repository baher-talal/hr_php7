<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class employeestravelling extends Sximo  {
	
	protected $table = 'tb_travellings';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_travellings.* FROM tb_travellings  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_travellings.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
