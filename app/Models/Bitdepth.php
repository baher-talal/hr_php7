<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class bitdepth extends Sximo  {
	
	protected $table = 'specs_cont_audio_bit_depth';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_audio_bit_depth.* FROM specs_cont_audio_bit_depth  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_audio_bit_depth.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
