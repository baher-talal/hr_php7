<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mediaspecsdocument extends Sximo  {
	
	protected $table = 'operator_media_documents';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT operator_media_documents.* FROM operator_media_documents  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE operator_media_documents.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
