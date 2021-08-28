<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mediaspecsvideo extends Sximo  {
	
	protected $table = 'operator_media_videos';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT operator_media_videos.* FROM operator_media_videos  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE operator_media_videos.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
