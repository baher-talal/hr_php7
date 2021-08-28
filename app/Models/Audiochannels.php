<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class audiochannels extends Sximo  {
	
	protected $table = 'specs_cont_audio_channels';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT specs_cont_audio_channels.* FROM specs_cont_audio_channels  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE specs_cont_audio_channels.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
