<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class operator extends Sximo  {

	protected $table = 'tb_operators';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT tb_operators.* FROM tb_operators  ";
	}

	public static function queryWhere(  ){

		return "  WHERE tb_operators.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

	public function country()
	{
		return $this->belongsTo('\App\Models\Countries','country_id');
	}

}
