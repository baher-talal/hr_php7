<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class audiotracks extends Sximo  {
	
	protected $table = 'audio_tracks';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT audio_tracks.* FROM audio_tracks  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE audio_tracks.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
