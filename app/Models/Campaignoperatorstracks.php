<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class campaignoperatorstracks extends Sximo  {

	protected $table = 'campaign_operators_tracks';
	protected $primaryKey = 'id';

	protected $fillable = [
			'operator_id',
			'track_id',
			'code'
	];

	public function __construct() {
		parent::__construct();

	}

	public static function querySelect(  ){

		return "  SELECT campaign_operators_tracks.* FROM campaign_operators_tracks  ";
	}

	public static function queryWhere(  ){

		return "  WHERE campaign_operators_tracks.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

	public function track()
	{
			return $this->belongsTo('App\Models\Campaigntracks') ;
	}

	public function operator()
	{
			return $this->belongsTo('App\Models\Operator');
	}

}
