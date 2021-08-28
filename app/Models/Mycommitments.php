<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mycommitments extends Sximo  {
	
	protected $table = 'tb_commitments';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_commitments.* FROM tb_commitments  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_commitments.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
