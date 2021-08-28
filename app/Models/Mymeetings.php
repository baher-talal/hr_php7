<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mymeetings extends Sximo  {
	
	protected $table = 'tb_meetings';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_meetings.* FROM tb_meetings  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_meetings.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
