<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class tasktime extends Sximo  {
	
	protected $table = 'tb_task_time';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_task_time.* FROM tb_task_time  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_task_time.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
