<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class attachmenttypes extends Sximo  {
	
	protected $table = 'attachment_types';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT attachment_types.* FROM attachment_types  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE attachment_types.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
