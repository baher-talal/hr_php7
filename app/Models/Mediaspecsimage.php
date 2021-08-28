<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mediaspecsimage extends Sximo  {
	
	protected $table = 'operator_media_photos';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT operator_media_photos.* FROM operator_media_photos  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE operator_media_photos.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
