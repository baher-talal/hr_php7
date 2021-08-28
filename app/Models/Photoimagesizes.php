<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class photoimagesizes extends Sximo  {
	
	protected $table = 'specs_cont_photo_image_sizes';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_photo_image_sizes.* FROM specs_cont_photo_image_sizes  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_photo_image_sizes.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
