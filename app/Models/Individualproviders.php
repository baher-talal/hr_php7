<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class individualproviders extends Sximo  {
	
	protected $table = 'providers';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT providers.* FROM providers  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE providers.provider_type_id = 1 ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
