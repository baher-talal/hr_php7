<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class commitmentsescalation extends Sximo  {
	
	protected $table = 'commitments_escalation';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT commitments_escalation.* FROM commitments_escalation  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE commitments_escalation.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
