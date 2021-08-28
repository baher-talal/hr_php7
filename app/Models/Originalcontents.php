<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class originalcontents extends Sximo  {
	
	protected $table = 'original_contents';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT original_contents.* FROM original_contents  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE original_contents.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
