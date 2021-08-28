<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class contractsattachments extends Sximo  {
	
	protected $table = 'tb_contracts_attachments';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_contracts_attachments.* FROM tb_contracts_attachments  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_contracts_attachments.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
