<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class campaigntracks extends Sximo  {

	protected $table = 'campaign_tracks';
	protected $primaryKey = 'id';

	protected $fillable = [
			'title',
			'track_file',
			'album_id',
			'subscription_txt',
			'track_poster',
			'background_image'
	];

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT campaign_tracks.* FROM campaign_tracks  ";
	}

	public static function queryWhere(  ){

		return "  WHERE campaign_tracks.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

	public function operators()
	{
			return $this->belongsToMany('App\Models\Operator','campaign_operators_tracks','track_id','operator_id')->withPivot('code','id');
	}

	public function album()
	{
			return $this->belongsTo('App\Models\campaignalbums','album_id','id');
	}

}
