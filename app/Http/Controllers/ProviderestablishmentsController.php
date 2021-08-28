<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Providerestablishments;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;


class ProviderestablishmentsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'providerestablishments';
	static $per_page	= '10';

	public function __construct()
	{

		//$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Providerestablishments();

		$this->info = $this->model->makeInfo( $this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'providerestablishments',
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
		$pagination->setPath('providerestablishments');

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
		return view('providerestablishments.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('providers');
		}

		$providerType = \DB::table('provider_types')->where('id', '>', 1)->get();
		$this->data['providerType'] = $providerType;
		$this->data['id'] = $id;
		return view('providerestablishments.form',$this->data);
	}

	public function getShow( $id = null)
	{

		if($this->access['is_detail'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		// $row = $this->model->getRow($id);
		// if($row)
		// {
		// 	$this->data['row'] =  $row;
		// } else {
		// 	$this->data['row'] = $this->model->getColumnTable('providers');
		// }

		$row = providerestablishments::where('id', $id)->first();

		$this->data['row'] = $row;
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('providerestablishments.view',$this->data);
	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);

		$generalAcceptTypes = array('jpg', 'png');
		$legalAcceptTypes = array('jpg', 'png', 'pdf');


			if(!is_null($request->file('provider_logo'))) {
				if(!in_array($request->file('provider_logo')->getClientOriginalExtension(), $generalAcceptTypes)) {
					return Redirect::to('providerestablishments/update/'.$request->input('id'))->with('messagetext',\Lang::get('Logo File (JPG - PNG) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}
			}
			if(!is_null($request->file('provider_commercial_register_file'))) {
				if(!in_array($request->file('provider_commercial_register_file')->getClientOriginalExtension(), $legalAcceptTypes)) {
					return Redirect::to('providerestablishments/update/'.$request->input('id'))->with('messagetext',\Lang::get('Commercial Register File (PDF - JPG - PNG) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}
			}
			if(!is_null($request->file('provider_tax_card_file'))) {
				if(!in_array($request->file('provider_tax_card_file')->getClientOriginalExtension(), $legalAcceptTypes)) {
					return Redirect::to('providerestablishments/update/'.$request->input('id'))->with('messagetext',\Lang::get('Tax Card File (PDF - JPG - PNG) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}
			}
			if(!is_null($request->file('provider_agent_file'))) {
				if(!in_array($request->file('provider_agent_file')->getClientOriginalExtension(), $legalAcceptTypes)) {
					return Redirect::to('providerestablishments/update/'.$request->input('id'))->with('messagetext',\Lang::get('Agent File (PDF - JPG - PNG) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}
			}


		if ($validator->passes()) {
			$data = $this->validatePost('tb_providerestablishments');

			// Compare dates.
			$CR_START_DATE = date_create($data['provider_commercial_register_date'])->format('Y-m-d');
			$PROVIDER_JOINING_DATE = date_create($data['provider_joining_date'])->format('Y-m-d');
			//$CR_EXPIRED_DATE = date('Y-m-d', strtotime($CR_START_DATE. ' 90 days'));
			$CR_EXPIRED_DATE = date('Y-m-d', strtotime($CR_START_DATE. ' 3 month'));

			if($CR_EXPIRED_DATE < $PROVIDER_JOINING_DATE) {
			return Redirect::to('providerestablishments/update/'.$request->input('id'))->with('messagetext',\Lang::get('The commercial record is expired!'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}







			$id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->input('apply')))
			{
				$return = 'providerestablishments/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'providerestablishments?return='.self::returnUrl();
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

			return Redirect::to('providerestablishments/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('providerestablishments')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('providerestablishments')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}

	}


}
