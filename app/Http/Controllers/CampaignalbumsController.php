<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaignalbums;
use App\Models\Campaigntracks;
use App\Models\Campaignoperatorstracks;
use App\Models\Campaigntypes;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, DB;


class CampaignalbumsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'campaignalbums';
	static $per_page	= '10';
	private $audioExtensions = array('mp3','wav'); // we can increase extensions here
	private $videoExtensions = array('mp4') ;
	private $imgExtensions = array("png", "jpeg", "jpg", "gif");

	public function __construct()
	{

		//$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Campaignalbums();

		$this->info = $this->model->makeInfo( $this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'campaignalbums',
			'return'	=> self::returnUrl()

		);

	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query
		// Filter Search for query
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query
		$results = $this->model->getRows( $params );

		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
		$pagination->setPath('campaignalbums');

		$this->data['rowData']		= $results['rows'];
		// Build Pagination
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();
		// Row grid Number
		$this->data['i']			= ($page * $params['limit'])- $params['limit'];
		// Grid Configuration
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any

		// Master detail link if any
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
		// Render into template
		return view('campaignalbums.index',$this->data);
	}



	function getUpdate(Request $request, $id = null)
	{

		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('campaign_albums');
		}


		$this->data['id'] = $id;
		return view('campaignalbums.form',$this->data);
	}

	public function getShow( $id = null)
	{

		if($this->access['is_detail'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('campaign_albums');
		}

		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('campaignalbums.view',$this->data);
	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost('tb_campaignalbums');
			$data['created_at'] = date("Y-m-d H:i:s");
			$data['updated_at'] = date("Y-m-d H:i:s");
			$id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->input('apply')))
			{
				$return = 'campaignalbums/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'campaignalbums?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');

		} else {

			return Redirect::to('campaignalbums/update/'.$request->input('id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}

	}

	public function postDelete( Request $request)
	{

		if($this->access['is_remove'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows
		if(count($request->input('id')) >=1)
		{
			$this->model->destroy($request->input('id'));

			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('id'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('campaignalbums')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('campaignalbums')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}

	}

	public function show($id) {
			$album = Campaignalbums::findOrFail($id);
			$tt = Campaigntracks::all();

			//return [$album,$tt];
			return view('campaignalbums.showtracks', compact('album', 'tt'));
	}

	public function get_track_form($id)
	{
			$album = Campaignalbums::findOrFail($id);
			$this->data['row'] = $this->model->getColumnTable('campaign_albums');
			$operators = \App\Models\Operator::all();
			$this->data['operators'] = $operators;
			$this->data['album'] = $album;
			$this->data['id'] = $id;
			return view('campaigntracks.addtrack',$this->data) ;
	}

	public function add_track(Request $request)
	{
			$check = Campaigntracks::where('title',$request->title)->where('album_id',$request->album_id)->get() ;
			if (count($check)>0)
			{
					//\Session::flash('message',\SiteHelpers::alert('error', 'This Track Already exists in this album'));
					return redirect("campaignalbums/show/".$request->album_id)->with('messagetext','This Track Already exists in this album')->with('msgstatus','error');;
			}


			// laravel validation for file size max:5000 = 5 M and this must be in controller as if put in TrackRequest it give error [ htmlentities() expects parameter 1 to be string, array given] if file is large than  5M
			$validator = Validator::make($request->all(), [
					'title' => 'required|min:3',
					'track_file' => 'max:20480',  // The value is in kilobytes. I.e. max:10240 = max 10 MB.
					'album_id'  => 'required|numeric'
			]);




			if ($validator->fails()) {
				return back()->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
				->withErrors($validator)->withInput();
			}


			$track =  $request->all() ;
			$album = Campaignalbums::findOrFail($request['album_id']) ;
			$file = $request->file('track_file');
			$destinationFolder = "uploads/campaign/tracks/" ;
			$albumType = $album->type->type ;
			$unique = time();
			if ($albumType=="Audio")
			{
					if (in_array($file->getClientOriginalExtension(),$this->audioExtensions))
					{
							$destinationFolder .= "Audio/" ;
					}
					else{
							//\Session::flash('message',\SiteHelpers::alert('error','Audio Extension must be of type mp3 or wav only with max size 10M'));
							return redirect("campaignalbums")->with('messagetext','Audio Extension must be of type mp3 or wav only with max size 10M')->with('msgstatus','error');
					}
			}
			elseif ($albumType=="Video")
			{
					if (in_array($file->getClientOriginalExtension(),$this->videoExtensions))
					{
							$destinationFolder .= "Video/" ;
					}
					else{
							//\Session::flash('failed','Video Extension must be of type mp4 with max size 10M');
							//\Session::flash('message',\SiteHelpers::alert('error','Video Extension must be of type mp4 with max size 10M'));
							return redirect("campaignalbums")->with('messagetext','Video Extension must be of type mp4 with max size 10M')->with('msgstatus','error');
					}
			}

			$track['track_file'] = $destinationFolder.$unique.".".$file->getClientOriginalExtension() ;
			$file->move($destinationFolder,$unique.".".$file->getClientOriginalExtension()) ;

			if ($request->hasFile('background_image')) {
					$file = $request->file('background_image');
					if (!in_array($file->getClientOriginalExtension(), $this->imgExtensions)) {
							//\Session::flash('failed', 'Image must be jpg, png, or jpeg only !!try again with that extensions please..');
							//\Session::flash('message',\SiteHelpers::alert('error','Image must be jpg, png, or jpeg only !!try again with that extensions please..'));
							return back()->with('messagetext','Image must be jpg, png, or jpeg only !!try again with that extensions please..')->with('msgstatus','error');
					}
					$destinationFolder = "uploads/campaign/tracks/background/";
					$uniqueNumber = time();
					$track['background_image'] = $destinationFolder . $uniqueNumber . "." . $file->getClientOriginalExtension();
					$file->move($destinationFolder, $uniqueNumber . "." . $file->getClientOriginalExtension());

			}

			if ($request->hasFile('track_poster')) {
				$file = $request->file('track_poster');
				if (!in_array($file->getClientOriginalExtension(), $this->imgExtensions)) {
						//\Session::flash('failed', 'Image must be jpg, png, or jpeg only !!try again with that extensions please..');
						//\Session::flash('message',\SiteHelpers::alert('error','Image must be jpg, png, or jpeg only !!try again with that extensions please..'));
						return back()->with('messagetext','Image must be jpg, png, or jpeg only !!try again with that extensions please..')->with('msgstatus','error');
					}
			$destinationFolder = "uploads/campaign/tracks/poster/";
			$uniqueNumber = time();
			$track['track_poster'] = $destinationFolder . $uniqueNumber . "." . $file->getClientOriginalExtension();
			$file->move($destinationFolder, $uniqueNumber . "." . $file->getClientOriginalExtension());

			}


			 	$track_info = Campaigntracks::insertGetId([
					'title' => $request->title,
					'track_file' => (isset($track['track_file'])) ? $track['track_file']: Null,
					'album_id' => $request->album_id,
					'subscription_txt' => $request->subscription_txt,
					'track_poster' => (isset($track['track_poster'])) ? $track['track_poster']:Null,
					'background_image' => (isset($track['background_image']))? $track['background_image']: Null,
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s")
					]) ;

				for($i=0;$i<count($request['code']);$i++)
				{
						$data['operator_id'] = $request['operator_id'][$i];
						$data['code'] = $request['code'][$i] ;
						$data['track_id'] = $track_info ;
						$data['created_at'] = date("Y-m-d H:i:s");
						$data['updated_at'] = date("Y-m-d H:i:s");
						Campaignoperatorstracks::insertGetId($data);
				}

			//\Session::flash('success','Track added successfully') ;
			//\Session::flash('message',\SiteHelpers::alert('success','Track added successfully'));
			return redirect("campaignalbums/show/".$album->id)->with('messagetext','Track added successfully')->with('msgstatus','success');
	}

	public function delete_track($id)
	{
			$track = Campaigntracks::findOrFail($id);
			Campaigntracks::destroy($id) ;
			return back()->with(['message'=> \SiteHelpers::alert('success', 'Track Deleted successfully')]);
	}

	public function update_track(Request $request, $id)
	{
			$cnt = count($request->get('items_removed')) ;
			if($cnt>0)
			{
					for($i=0;$i<$cnt;$i++)
					{
							Campaignoperatorstracks::destroy($request['items_removed'][$i]);
					}
			}
			$new_operators_ids = count($request->get('new_operator_id')) ;
			$new_code = count($request->get('new_code')) ;
			if ($new_operators_ids > 0 && $new_code > 0 && $new_operators_ids == $new_code)
			{
					for($i = 0 ; $i < $new_operators_ids ; $i++)
					{
							$data['operator_id'] = $request['new_operator_id'][$i] ;
							$data['track_id'] = $id ;
							$data['code'] = $request['new_code'][$i];
							$data['created_at'] = date('Y-m-d H:i:s');
							$data['updated_at'] = date('Y-m-d H:i:s');
							Campaignoperatorstracks::insert($data);
							// $operator_track = new Campaignoperatorstracks($data) ;
							// $operator_track->save();
					}
					\Session::flash('success','Track Linked to Operator successfully');
			}
			$oldTrack = Campaigntracks::findOrFail($id) ;
			$newTrack = $request->all() ;
			$albumType = Campaigntypes::findOrFail($request->get('album_type'))->type;
			$destinationFolder = "uploads/campaign/tracks/" ;
			if ($request->hasFile('track_file'))
			{

					$file = $request->file('track_file') ;
					$unique = time();
					if ($albumType=="Audio")
					{
							if (in_array($file->getClientOriginalExtension(),$this->audioExtensions))
							{
									$destinationFolder .= "Audio/" ;
							}
							else{
									\Session::flash('failed','Audio Extension must be of type mp3 or wav only with max size 10M');
									return redirect("campaigntrack/show/".$request['album_id']);
							}
					}
					elseif ($albumType=="Video")
					{
							if (in_array($file->getClientOriginalExtension(),$this->videoExtensions))
							{
									$destinationFolder .= "Video/" ;
							}
							else{
									\Session::flash('failed','Video Extension must be of type mp4 with max size 10M');
									return redirect("campaigntrack/".$request['album_id']);
							}
					}
					$newTrack['track_file'] = $destinationFolder.$unique.".".$file->getClientOriginalExtension() ;
					$file->move($destinationFolder,$unique.".".$file->getClientOriginalExtension()) ;
			}


				if ($request->hasFile('background_image')) {
					$file = $request->file('background_image');
					if (!in_array($file->getClientOriginalExtension(), $this->imgExtensions)) {
							\Session::flash('failed', 'Image must be jpg, png, or jpeg only !!try again with that extensions please..');
							return back();
					}
					$destinationFolder = "uploads/campaign/tracks/background/";
					$uniqueNumber = time();
					$newTrack['background_image'] = $destinationFolder . $uniqueNumber . "." . $file->getClientOriginalExtension();
					$file->move($destinationFolder, $uniqueNumber . "." . $file->getClientOriginalExtension());
					// if (file_exists($oldTrack->background_image)) {
					// 		Storage::delete($oldTrack->background_image);
					// }
			}

			if ($request->hasFile('track_poster')) {
				$file = $request->file('track_poster');
				if (!in_array($file->getClientOriginalExtension(), $this->imgExtensions)) {
						\Session::flash('failed', 'Image must be jpg, png, or jpeg only !!try again with that extensions please..');
						return back();
				}
				$destinationFolder = "uploads/campaign/tracks/poster/";
				$uniqueNumber = time();
				$newTrack['track_poster'] = $destinationFolder . $uniqueNumber . "." . $file->getClientOriginalExtension();
				$file->move($destinationFolder, $uniqueNumber . "." . $file->getClientOriginalExtension());
				// if (file_exists($oldTrack->track_poster)) {
				// 		Storage::delete($oldTrack->track_poster);
				// }
		}

			$oldTrack->update($newTrack) ;

			if ($request->get('operator_id'))
			{
					for($i = 0 ; $i < count($request->get('operator_track_id')) ; $i++)
					{
							$old_op_tr = Campaignoperatorstracks::findOrFail($request['operator_track_id'][$i]);
							$new_op_tr['operator_id'] = $request['operator_id'][$i];
							$new_op_tr['code'] = $request['code'][$i] ;
							$old_op_tr->update($new_op_tr) ;
					}
			}

			\Session::flash('success','Track Updated succesfully');
			return redirect("campaignalbums/show/".$request->get('album_id'));
	}

	public function UpdateRecord(Request $request) {
			$this->data['row'] = $this->model->getColumnTable('campaign_albums');
			$track = Campaigntracks::findOrFail($request->get('track_id'));
			$albums = Campaignalbums::pluck('name', 'id');
			$operators = Operator::all();
			$op_tr = DB::select("SELECT  campaign_operators_tracks.id operator_track_id , campaign_operators_tracks.code code , campaign_operators_tracks.operator_id operator_id FROM campaign_operators_tracks JOIN campaign_tracks ON campaign_operators_tracks.track_id = campaign_tracks.id JOIN tb_operators ON tb_operators.id = campaign_operators_tracks.operator_id WHERE campaign_tracks.id =" . $request->get('track_id'));
			$this->data['track'] =$track;
			$this->data['albums'] =$albums;
			$this->data['operators'] =$operators;
			$this->data['op_tr'] =$op_tr;
			return view('campaignalbums.edit_track_from_album', $this->data);
	}

	public function get_operator_track($id)
	{
			$operators = Operator::all();
			$track = Campaigntracks::findOrFail($id);
			$this->data['row'] = $this->model->getColumnTable('campaign_albums');
			$this->data['track'] =$track;
			$this->data['operators'] =$operators;
		return view('campaigntracks.add_operator_track',$this->data);
	}
	public function add_operator_track(Request $request)
	{
		Campaignoperatorstracks::insert($request->only('operator_id','track_id','code')) ;
		return back()
					->with('messagetext','Track Linked to Operator successfully')->with('msgstatus','success');
	}
	public function edit_operator_track($id)
	{
		$operator_track = Campaignoperatorstracks::findOrFail($id);
		$operators = Operator::all();
		$this->data['row'] = $this->model->getColumnTable('campaign_albums');
		$this->data['operator_track'] = $operator_track;
		$this->data['operators'] = $operators;
		return view('campaignoperatorstracks.edit_operator_track',$this->data);
	}
	public function update_operator_track($id,Request $request)
	{
		$oldOpTr = Campaignoperatorstracks::findOrFail($id) ;
		$newOpTr = $request->all();
		$oldOpTr->update($newOpTr) ;
		return redirect('operator_track')
					->with('messagetext','Operator Track link updated successfully')->with('msgstatus','success');
	}
	public function delete_operator_track($id)
	{
		Campaignoperatorstracks::destroy($id);
		return back()
					->with('messagetext','Operator Link to Track has been deleted successfully')->with('msgstatus','success');
	}
	public function all_operator_track()
	{
			$operators_tracks = Campaignoperatorstracks::all();
			return view('campaignoperatorstracks.all_operator_track',compact('operators_tracks'));
	}

	public function campaigntrack()
	{
			$tracks = Campaigntracks::all() ;
			return view('campaignalbums.all_tracks',compact('tracks'));
	}

	public function GetTrack(Request $request) {
			if ($request->get('track_id') && $request->get('operator_id')) {
					$track = Campaigntracks::find($request->get('track_id'));
					$optTrack = Campaignoperatorstracks::find($request->get('operator_id'));
					$this->data['row'] = $this->model->getColumnTable('campaign_albums');
					$this->data['optTrack'] = $optTrack;
					$this->data['track'] = $track;
					if (count($track) > 0 && count($optTrack) > 0) {
							$albumType = $track->album->type->type;
							if ($albumType == "Audio") {
									return view('playtrack.audio', $this->data);
							} elseif ($albumType == "Video") {
									return view('playtrack.video', $this->data);
							} else {
									\Session::flash('failed', 'No result found');
									return redirect('campaigntracks');
							}
					} else {
							\Session::flash('failed', 'No link between those operator and track');
							return redirect('campaigntracks');
					}
			} else {
					\Session::flash('failed', 'No operator or track have been chosen');
					return redirect('campaigntracks');
			}
	}

	public function GetTrack_v2($track_id) {

			$query = "SELECT id FROM campaign_tracks WHERE id =" . $track_id;
			$run = \DB::select($query);
			if (count($run) == 0) {
					return view('errors.pppp_404');
			}

			$country_from_ip = $this->ip_info("Visitor", "Country");
			//  $country_from_ip = "Egypt";
			// var_dump($country_from_ip) ; die;

			if ($country_from_ip !== NULL) {  // there is detect country
					$track = DB::table('campaign_operators_tracks')
									->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
									->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
									->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
									->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
									->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
									->where('campaign_operators_tracks.track_id', '=', $track_id)
									->where('tb_countries.country', 'LIKE', '%' . $country_from_ip . '%')
									->select([
											'campaign_tracks.*',
											'tb_operators.*',
											'campaign_operators_tracks.*',
											'tb_countries.*',
											'campaign_albums.*',
											'campaign_types.*',
											'campaign_tracks.title AS tr_title',
											'tb_operators.name AS op_title',
											'tb_countries.country AS con_title'
									])
									->get();

					if (count($track) == 0) {  // get all tracks ( for testing )
							$track = DB::table('campaign_operators_tracks')
											->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
											->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
											->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
											->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
											->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
											->where('campaign_operators_tracks.track_id', '=', $track_id)
											->select([
													'campaign_tracks.*',
													'tb_operators.*',
													'campaign_operators_tracks.*',
													'tb_countries.*',
													'campaign_albums.*',
													'campaign_types.*',
													'campaign_tracks.title AS tr_title',
													'tb_operators.name AS op_title',
													'tb_countries.country AS con_title'
											])
											->get();
					}
			} else {  // there is no detect
					$track = DB::table('campaign_operators_tracks')
									->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
									->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
									->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
									->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
									->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
									->where('campaign_operators_tracks.track_id', '=', $track_id)
									->select([
											'campaign_tracks.*',
											'tb_operators.*',
											'campaign_operators_tracks.*',
											'tb_countries.*',
											'campaign_albums.*',
											'campaign_types.*',
											'campaign_tracks.title AS tr_title',
											'tb_operators.name AS op_title',
											'tb_countries.country AS con_title'
									])
									->get();
			}

			if (count($track) > 0) {
					$albumType = $track[0]->type;
					return view('playtrack.audio_v2', compact('track'));
			} else {
					return view('errors.pppp_404');
			}
	}

	public function GetTrack_v3($track_id) {

			$query = "SELECT id FROM campaign_tracks WHERE id =" . $track_id;
			$run = \DB::select($query);
			if (count($run) == 0) {
					return view('errors.404');
			}

			$country_from_ip = $this->ip_info("Visitor", "Country");
			//  $country_from_ip = "Egypt";
			// var_dump($country_from_ip) ; die;

			if ($country_from_ip !== NULL) {  // there is detect country
					$track = DB::table('campaign_operators_tracks')
									->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
									->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
									->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
									->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
									->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
									->where('campaign_operators_tracks.track_id', '=', $track_id)
									->where('tb_countries.country', 'LIKE', '%' . $country_from_ip . '%')
									->select([
											'campaign_tracks.*',
											'tb_operators.*',
											'campaign_operators_tracks.*',
											'tb_countries.*',
											'campaign_albums.*',
											'campaign_types.*',
											'campaign_tracks.title AS tr_title',
											'tb_operators.name AS op_title',
											'tb_countries.country AS con_title'
									])
									->get();

					if (count($track) == 0) {  // get all tracks ( for testing )
							$track = DB::table('campaign_operators_tracks')
											->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
											->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
											->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
											->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
											->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
											->where('campaign_operators_tracks.track_id', '=', $track_id)
											->select([
													'campaign_tracks.*',
													'tb_operators.*',
													'campaign_operators_tracks.*',
													'tb_countries.*',
													'campaign_albums.*',
													'campaign_types.*',
													'campaign_tracks.title AS tr_title',
													'campaign_tracks.background_image AS tr_background_image',
													'tb_operators.name AS op_title',
													'tb_countries.country AS con_title'
											])
											->get();
					}
			} else {  // there is no detect
					$track = DB::table('campaign_operators_tracks')
									->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
									->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
									->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
									->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
									->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
									->where('campaign_operators_tracks.track_id', '=', $track_id)
									->select([
											'campaign_tracks.*',
											'tb_operators.*',
											'campaign_operators_tracks.*',
											'tb_countries.*',
											'campaign_albums.*',
											'campaign_types.*',
											'campaign_tracks.title AS tr_title',
											'campaign_tracks.background_image AS tr_background_image',
											'tb_operators.name AS op_title',
											'tb_countries.country AS con_title'
									])
									->get();
			}


			if (count($track) > 0) {
					$albumType = $track[0]->type;
					return view('playtrack.audio_v3', compact('track'));
			} else {
					return view('errors.404');
			}
	}

	public function GetTrack_v4($album_id) {

			$query = "SELECT id FROM campaign_albums WHERE id =" . $album_id;
			$run = \DB::select($query);
			if (count($run) == 0) {
					return view('errors.404');
			}

			$country_from_ip = $this->ip_info("Visitor", "Country");

			if ($country_from_ip !== NULL) {  // there is detect country
					$albums = DB::table('campaign_operators_tracks')
									->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
									->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
									->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
									->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
									->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
									->where('campaign_albums.id', '=', $album_id)
									->where('tb_countries.country', 'LIKE', '%' . $country_from_ip . '%')
									->groupBy('campaign_tracks.id')
									->select([
											'campaign_tracks.*',
											'tb_operators.*',
											'campaign_operators_tracks.*',
											'tb_countries.*',
											'campaign_albums.*',
											'campaign_types.*',
											'campaign_tracks.background_image as background_image_track',
											'campaign_tracks.title AS tr_title',
											'tb_operators.name AS op_title',
											'tb_countries.country AS con_title'
									])
									->get();

					if (count($albums) == 0) {  // get all tracks ( for testing )
						$albums = DB::table('campaign_operators_tracks')
										->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
										->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
										->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
										->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
										->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
										->where('campaign_albums.id', '=', $album_id)
										->groupBy('campaign_tracks.id')
										->select([
												'campaign_tracks.*',
												'tb_operators.*',
												'campaign_operators_tracks.*',
												'tb_countries.*',
												'campaign_albums.*',
												'campaign_types.*',
												'campaign_tracks.background_image as background_image_track',
												'campaign_tracks.title AS tr_title',
												'tb_operators.name AS op_title',
												'tb_countries.country AS con_title'
										])
										->get();
					}
			} else {  // there is no detect
				$albums = DB::table('campaign_operators_tracks')
								->join('campaign_tracks', 'campaign_operators_tracks.track_id', '=', 'campaign_tracks.id')
								->join('tb_operators', 'campaign_operators_tracks.operator_id', '=', 'tb_operators.id')
								->join('tb_countries', 'tb_operators.country_id', '=', 'tb_countries.id')
								->join('campaign_albums', 'campaign_tracks.album_id', '=', 'campaign_albums.id')
								->join('campaign_types', 'campaign_albums.type_id', '=', 'campaign_types.id')
								->where('campaign_albums.id', '=', $album_id)
								->groupBy('campaign_tracks.id')
								->select([
										'campaign_tracks.*',
										'tb_operators.*',
										'campaign_operators_tracks.*',
										'tb_countries.*',
										'campaign_albums.*',
										'campaign_types.*',
										'campaign_tracks.background_image as background_image_track',
										'campaign_tracks.title AS tr_title',
										'tb_operators.name AS op_title',
										'tb_countries.country AS con_title',
										'campaign_albums.id as album_id'
								])
								->get();
			}

			if (count($albums) > 0) {
					$albumType = $albums[0]->type;
					//dd($albums);
					return view('playtrack.new_video', compact('albums', 'albumType','country_from_ip'));
			} else {
					return view('errors.404');
			}
	}

	public function share_track(Request $request) {
			$link = $request['link'];
			$page_content = file_get_contents($link);
			$file_name = "./uploads/shares/" . time() . ".html";
			file_put_contents($file_name, $page_content);
			return view('playtrack.share_btn', compact('file_name'));
	}

	public function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
			$output = NULL;
			if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
					$ip = $_SERVER["REMOTE_ADDR"];
					if ($deep_detect) {
							if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
									$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
							if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
									$ip = $_SERVER['HTTP_CLIENT_IP'];
					}
			}
			$purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
			$support = array("country", "countrycode", "state", "region", "city", "location", "address");
			$continents = array(
					"AF" => "Africa",
					"AN" => "Antarctica",
					"AS" => "Asia",
					"EU" => "Europe",
					"OC" => "Australia (Oceania)",
					"NA" => "North America",
					"SA" => "South America"
			);
			if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
					$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
					if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
							switch ($purpose) {
									case "location":
											$output = array(
													"city" => @$ipdat->geoplugin_city,
													"state" => @$ipdat->geoplugin_regionName,
													"country" => @$ipdat->geoplugin_countryName,
													"country_code" => @$ipdat->geoplugin_countryCode,
													"continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
													"continent_code" => @$ipdat->geoplugin_continentCode
											);
											break;
									case "address":
											$address = array($ipdat->geoplugin_countryName);
											if (@strlen($ipdat->geoplugin_regionName) >= 1)
													$address[] = $ipdat->geoplugin_regionName;
											if (@strlen($ipdat->geoplugin_city) >= 1)
													$address[] = $ipdat->geoplugin_city;
											$output = implode(", ", array_reverse($address));
											break;
									case "city":
											$output = @$ipdat->geoplugin_city;
											break;
									case "state":
											$output = @$ipdat->geoplugin_regionName;
											break;
									case "region":
											$output = @$ipdat->geoplugin_regionName;
											break;
									case "country":
											$output = @$ipdat->geoplugin_countryName;
											break;
									case "countrycode":
											$output = @$ipdat->geoplugin_countryCode;
											break;
							}
					}
			}
			return $output;
	}

	public function getUserIP() {
			$client = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote = $_SERVER['REMOTE_ADDR'];

			if (filter_var($client, FILTER_VALIDATE_IP)) {
					$ip = $client;
			} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
					$ip = $forward;
			} else {
					$ip = $remote;
			}

			return $ip;
	}
}
