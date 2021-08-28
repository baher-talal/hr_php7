<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class audiometadata extends Sximo  {
	
	protected $table = 'get_audio_details';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT get_audio_details.* FROM get_audio_details  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE get_audio_details.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
