<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class providers extends Sximo  {

	protected $table = 'providers';
	protected $primaryKey = 'id';



	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT providers.* FROM providers  ";
	}

	public static function queryWhere(  ){

		return "  WHERE providers.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
