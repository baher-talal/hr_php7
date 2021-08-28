<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class notifications extends Sximo  {
	
	protected $table = 'tb_notifications';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_notifications.* FROM tb_notifications  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_notifications.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
