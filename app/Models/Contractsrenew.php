<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contractsrenew extends Sximo  {
	
	protected $table = 'tb_contracts_renews';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_contracts_renews.* FROM tb_contracts_renews  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_contracts_renews.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
