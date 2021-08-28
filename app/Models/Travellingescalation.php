<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class travellingescalation extends Sximo  {
	
	protected $table = 'tb_travelling_escalations';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_travelling_escalations.* FROM tb_travelling_escalations  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_travelling_escalations.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
