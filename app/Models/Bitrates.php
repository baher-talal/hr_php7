<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class bitrates extends Sximo  {
	
	protected $table = 'specs_cont_audio_bit_rate';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_audio_bit_rate.* FROM specs_cont_audio_bit_rate  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_audio_bit_rate.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
