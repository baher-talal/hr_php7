<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class photoresolutions extends Sximo  {
	
	protected $table = 'specs_cont_photo_image_resolutions';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_photo_image_resolutions.* FROM specs_cont_photo_image_resolutions  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_photo_image_resolutions.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
