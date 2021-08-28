<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contenttype extends Sximo  {
	
	protected $table = 'content_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT content_types.* FROM content_types  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE content_types.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
