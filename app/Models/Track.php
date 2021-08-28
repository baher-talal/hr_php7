<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class track extends Sximo  {
	
	protected $table = 'tb_tracks';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_tracks.* FROM tb_tracks  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_tracks.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
