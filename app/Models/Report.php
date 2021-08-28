<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class report extends Sximo  {
	
	protected $table = 'reports';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT reports.* FROM reports  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE reports.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
