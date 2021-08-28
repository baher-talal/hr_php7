<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class finalimage extends Sximo  {
	
	protected $table = 'images';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT images.* FROM images  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE images.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
