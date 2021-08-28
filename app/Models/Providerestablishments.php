<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class providerestablishments extends Sximo  {

	protected $table = 'providers';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT providers.* FROM providers  ";
	}

	public static function queryWhere(  ){

		//return "  WHERE providers.id IS NOT NULL ";
		return "  WHERE provider_type_id = 2 OR provider_type_id = 3 ";
	}

	public static function queryGroup(){
		return "  ";
	}


}
