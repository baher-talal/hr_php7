<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class campaignalbums extends Sximo  {

	protected $table = 'campaign_albums';
	protected $primaryKey = 'id';
	
	protected $fillable = [
			'name',
			'background_image',
			'provider_id',
			'type_id'
	];

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT campaign_albums.* FROM campaign_albums  ";
	}

	public static function queryWhere(  ){

		return "  WHERE campaign_albums.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

	public function provider()
	{
			return $this->belongsTo('App\Models\Providers') ;
	}

	public function type()
	{
			return $this->belongsTo('App\Models\Campaigntypes');
	}

	public function tracks()
	{
			return $this->hasMany('App\Models\Campaigntracks','album_id','id');
	}

}
