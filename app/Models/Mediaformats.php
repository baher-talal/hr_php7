<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mediaformats extends Sximo  {
	
	protected $table = 'specs_cont_media_formats';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_media_formats.* FROM specs_cont_media_formats  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_media_formats.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
