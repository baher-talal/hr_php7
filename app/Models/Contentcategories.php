<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contentcategories extends Sximo  {
	
	protected $table = 'cont_categories';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT cont_categories.* FROM cont_categories  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE cont_categories.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
