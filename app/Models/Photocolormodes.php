<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class photocolormodes extends Sximo  {
	
	protected $table = 'specs_cont_photo_image_color_modes';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_photo_image_color_modes.* FROM specs_cont_photo_image_color_modes  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_photo_image_color_modes.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
