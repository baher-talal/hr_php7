<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class specscontentcategory extends Sximo  {
	
	protected $table = 'specs_cont_categories';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_categories.* FROM specs_cont_categories  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_categories.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
