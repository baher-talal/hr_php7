<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class videopixelaspectratios extends Sximo  {
	
	protected $table = 'specs_cont_video_pixel_aspect_ratios';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_video_pixel_aspect_ratios.* FROM specs_cont_video_pixel_aspect_ratios  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_video_pixel_aspect_ratios.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
