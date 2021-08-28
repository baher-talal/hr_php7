<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contentoccations extends Sximo  {
	
	protected $table = 'cont_occations';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT cont_occations.* FROM cont_occations  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE cont_occations.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
