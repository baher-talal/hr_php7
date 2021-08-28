<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class samplerates extends Sximo  {
	
	protected $table = 'specs_cont_audio_sample_rate';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_audio_sample_rate.* FROM specs_cont_audio_sample_rate  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_audio_sample_rate.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
