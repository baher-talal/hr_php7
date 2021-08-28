<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mediaspecsaudio extends Sximo  {
	
	protected $table = 'operator_media_audios';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT operator_media_audios.* FROM operator_media_audios  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE operator_media_audios.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
