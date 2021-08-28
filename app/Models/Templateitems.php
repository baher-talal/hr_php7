<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class templateitems extends Sximo  {
	
	protected $table = 'template_items';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT template_items.* FROM template_items  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE template_items.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
