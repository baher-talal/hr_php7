<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Finalvideo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;
use getID3;
use getid3_lib;


class FinalvideoController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'finalvideo';
	static $per_page	= '10';

	public function __construct()
	{

		//$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Finalvideo();

		$this->info = $this->model->makeInfo( $this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'finalvideo',
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
		$pagination->setPath('finalvideo');

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
		return view('finalvideo.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('videos');
		}


		$this->data['id'] = $id;
		return view('finalvideo.form',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('videos');
		}

		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('finalvideo.view',$this->data);
	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost('tb_finalvideo');

			$acceptAudioTypes = array('mp4', '3gp'); // Media formats.

			if(!is_null($request->file('video_path'))) {
				if(!in_array($request->file('video_path')->getClientOriginalExtension(), $acceptAudioTypes)) {
					return Redirect::to('finalvideo/update/'.$request->input('id'))->with('messagetext',\Lang::get('Audio File (MP4 - 3GP) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}

			// GetID3
			require_once('getID3/getid3/getid3.php');
			$getID3 = new getID3;
			$filename = 'uploads/media/' .$data['video_path'];
			$ThisFileInfo = $getID3->analyze($filename);
			getid3_lib::CopyTagsToComments($ThisFileInfo);
			$this->data['ThisFileInfo'] = $ThisFileInfo;
			$fileSizeLimit = 5242880; // 5 mb
			if($ThisFileInfo['filesize'] > $fileSizeLimit) {
				return Redirect::to('finalvideo/update/'.$request->input('id'))->with('messagetext',\Lang::get('The file must be less than 5 MB!'))->with('msgstatus','error')
				->withErrors($validator)->withInput();
			}
		}


			$id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->input('apply')))
			{
				$return = 'finalvideo/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'finalvideo?return='.self::returnUrl();
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

			return Redirect::to('finalvideo/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('finalvideo')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('finalvideo')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}

	}


}
