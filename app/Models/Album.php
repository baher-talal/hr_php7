<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class album extends Sximo  {

	protected $table = 'tb_albums';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT tb_albums.* FROM tb_albums  ";
	}

	public static function queryWhere(  ){

		return "  WHERE tb_albums.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

	public function tracks()
	{
		return $this->hasMany('App\Models\Track','album_id');
	}


}
