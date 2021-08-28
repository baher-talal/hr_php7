<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class template extends Sximo  {
	
	protected $table = 'templates';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT templates.* FROM templates  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE templates.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
