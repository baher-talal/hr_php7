<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class punchnotifications extends Sximo  {
	
	protected $table = 'tb_punch_notifications';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_punch_notifications.* FROM tb_punch_notifications  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_punch_notifications.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
