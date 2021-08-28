<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class myovertime extends Sximo  {
	
	protected $table = 'tb_overtimes';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_overtimes.* FROM tb_overtimes  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_overtimes.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
