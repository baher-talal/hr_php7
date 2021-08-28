<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Audiometadata;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;
use getID3;
use getid3_lib;

class AudiometadataController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'audiometadata';
	static $per_page	= '10';

	public function __construct()
	{

		//$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Audiometadata();

		$this->info = $this->model->makeInfo( $this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'audiometadata',
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
		$pagination->setPath('audiometadata');

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
		return view('audiometadata.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('get_audio_details');
		}


		$this->data['id'] = $id;
		return view('audiometadata.form',$this->data);
	}

	public function getShow( $id = null)
	{

		if($this->access['is_detail'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');

		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('get_audio_details');
		}

		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('audiometadata.view',$this->data);
	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);








		if ($validator->passes()) {
			$data = $this->validatePost('tb_audiometadata');


			$acceptAudioTypes = array('wav', 'mp3'); // Media formats.

			if(!is_null($request->file('track_sample_path'))) {
				if(!in_array($request->file('track_sample_path')->getClientOriginalExtension(), $acceptAudioTypes)) {
					return Redirect::to('audiometadata/update/'.$request->input('id'))->with('messagetext',\Lang::get('Audio File (WAV - MP3) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}





			// GetID3
									require_once('getID3/getid3/getid3.php');
									$getID3 = new getID3;
									$filename = 'uploads/media/' .$data['track_sample_path'];
									$ThisFileInfo = $getID3->analyze($filename);
									getid3_lib::CopyTagsToComments($ThisFileInfo);
									$this->data['ThisFileInfo'] = $ThisFileInfo;

									$data['track_meta_data'] = strtoupper($ThisFileInfo['fileformat']) .
											' / ' . $ThisFileInfo['audio']['sample_rate'] . ' Hz ' .
											' / ' . (($ThisFileInfo['fileformat'] != 'mp3') ? $ThisFileInfo['audio']['bits_per_sample'] . ' Bit ' : '') .
											' / ' . round($ThisFileInfo['audio']['bitrate'] / 1000).' Kbps' .
											' / ' . $ThisFileInfo['audio']['channelmode'] .
											' / ' . (($ThisFileInfo['fileformat'] != 'mp3') ? $ThisFileInfo['audio']['codec'] : '') .
											' / ' . floor($ThisFileInfo['playtime_seconds'] / 3600) . gmdate(":i:s", $ThisFileInfo['playtime_seconds'] % 3600);


			}

			$trackDurationContain = $request->input('track_duration');
			if( strpos($trackDurationContain, ' ') !== false) {
				return Redirect::to('audiometadata/update/'.$request->input('id'))->with('messagetext',\Lang::get('Enter a comma between the digits without a space!'))->with('msgstatus','error')
				->withErrors($validator)->withInput();
			}

			if( strpos($trackDurationContain, ',') !== false) {
				$trackDurationContainToArray = explode(',', $trackDurationContain);
				if($trackDurationContainToArray[0] > $trackDurationContainToArray[1]) {
					return Redirect::to('audiometadata/update/'.$request->input('id'))->with('messagetext',\Lang::get('The first digit must be smaller than the second number!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}
			}


			$id = $this->model->insertRow($data , $request->input('id'));
			if(!is_null($request->input('apply')))
			{
				$return = 'audiometadata/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'audiometadata?return='.self::returnUrl();
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

			return Redirect::to('audiometadata/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('audiometadata')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('audiometadata')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}

	}


}
