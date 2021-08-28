<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class videoframerates extends Sximo  {
	
	protected $table = 'specs_cont_video_frame_rates';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_video_frame_rates.* FROM specs_cont_video_frame_rates  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_video_frame_rates.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
