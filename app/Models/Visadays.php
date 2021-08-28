<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class visadays extends Sximo  {
	
	protected $table = 'tb_visa_days';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_visa_days.* FROM tb_visa_days  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_visa_days.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
        
       

}
