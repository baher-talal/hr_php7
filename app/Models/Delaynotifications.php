<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class delaynotifications extends Sximo  {
	
	protected $table = 'tb_delay_notifications';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_delay_notifications.* FROM tb_delay_notifications  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_delay_notifications.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
