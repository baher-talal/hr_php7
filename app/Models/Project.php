<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class project extends Sximo  {
	
	protected $table = 'projects';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT projects.* FROM projects  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE projects.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
