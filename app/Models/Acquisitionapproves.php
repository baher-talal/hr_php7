<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class acquisitionapproves extends Sximo  {
	
	protected $table = 'acquisition_approves';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT acquisition_approves.* FROM acquisition_approves  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE acquisition_approves.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
