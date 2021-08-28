<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect , Excel ;


class ReportController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'report';
	static $per_page	= '10';

	public function __construct()
	{

		//$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Report();

		$this->info = $this->model->makeInfo( $this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'report',
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
		$pagination->setPath('report');

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
		return view('report.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('reports');
		}


		$this->data['id'] = $id;
		return view('report.form',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('reports');
		}

		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('report.view',$this->data);
	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost('tb_report');

			$id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->input('apply')))
			{
				$return = 'report/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'report?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$request->input('id').' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$request->input('id').' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');

		} else {

			return Redirect::to('report/update/'.$request->input('id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('report')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('report')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}

	}

	// report new function
	public function downloadSample()
	{
			$file= base_path(). "/rbt_system/report/reports.xlsx";

			$headers = array(
								'Content-Type: application/xlsx',
							);
			// return response()->download($pathToFile[, $name], [, $headers]);
			return response()->download($file, 'reports.xlsx', $headers);
	}

	public function excel()
	{
			$title = 'Create - report';
			$this->data['row'] = $this->model->getColumnTable('reports');
			$operators = \App\Models\Operator::all()->pluck('name','id');
			$providers = \App\Models\providers::all()->pluck('provider_name','id');
			$aggregators = \App\Models\aggregators::all()->pluck('aggregator_name','id');
			$this->data['operators'] = $operators;
			$this->data['providers'] = $providers;
			$this->data['aggregators'] = $aggregators;
			return view('report.create',$this->data);
	}

	public function excelStore(Request $request)
	{
			$validator = Validator::make($request->all(),[
							'operator_id' => 'required',
							'year' => 'required',
							'month' => 'required',
					]);

			if ($validator->fails()) {
					return back()->withErrors($validator)->withInput();
			}
			ini_set('max_execution_time', 60000000000);
			ini_set('memory_limit', -1);

			$successful_creations = 0 ;
			$total_reports = 0 ;

			if ($request->hasFile('fileToUpload')) {
					$ext =  $request->file('fileToUpload')->getClientOriginalExtension();
					if ($ext != 'xls' && $ext != 'xlsx' && $ext != 'csv') {
							$request->session()->flash('failed', 'File must be excel');
							return back();
					}

					$file = $request->file('fileToUpload');
					$filename = time().'_'.$file->getClientOriginalName();
					if(!$file->move(base_path().'/rbt_system/report/excel',  $filename) ){
							return back();
					}

					Excel::filter('chunk')->load(base_path().'/rbt_system/report/excel/'.$filename)->chunk(5, function($results) use ($request,&$total_reports,&$successful_creations)
					{
							// dd($results);
							$total_reports = count($results) ;
							foreach ($results as $row) {
									$report['year'] = $request->year;
									$report['month'] = $request->month;
									$report['operator_id'] = $request->operator_id;
									if ($request->aggregator_id != "") {
											$report['aggregator_id'] = $request->aggregator_id;
									}




									$report['classification'] = $row->classification;
									if ($row->code != "") {  // if you write rbt code only
											$report['code'] = $row->code;
											$rbt = \App\Models\Rbt::where('code',$row->code)->where('operator_id',$request->operator_id)->first(); // see if this rbt code found before for the same operator
											if ($rbt == null) { // this rbt not found
													 continue;
											 }

											// old report for the rbt code in the same operator
										$old_report = \App\Models\Report::where('operator_id',$rbt->operator_id)->where('provider_id',$rbt->provider_id)->where('code',$rbt->code)->where('year',$request->year)->where('month',$request->month)->first();
											if($old_report){
													continue;
											}

											$report['rbt_name'] = $rbt->track_title_en;
											$report['rbt_id'] = $rbt->id;
											$report['provider_id'] = $rbt->provider_id;

									}elseif ($row->code == "" && $row->track_name != "" && $row->artist_name != "") { // if you write rbt name + provider name
											$provider = \App\Models\providers::where('provider_name', $row->artist_name)->first();
											if (!$provider) {
													continue;
											}
											$rbt = \App\Models\Rbt::where('operator_id',$request->operator_id)->where('provider_id',$provider->id)->where('track_title_en',$row->track_name)->first();
											if ($rbt == null) {
													continue;
											}
											$report['code'] = $rbt->code;
											$report['rbt_name'] = $rbt->track_title_en;
											$report['rbt_id'] = $rbt->id;
											$report['provider_id'] = $rbt->provider_id;
									}else{
											continue;
									}
									$report['download_no'] = $row->download_number;
									$report['total_revenue'] = $row->total_revenue;
									$report['revenue_share'] = $row->revenue_share;
									$report['created_at'] = \Carbon\Carbon::now();
									$report['updated_at'] = \Carbon\Carbon::now();
									$check = \App\Models\Report::insert($report) ;
									if ($check)
											$successful_creations++ ;
							}

					},false);
			}else{
					$request->session()->flash('failed', 'Excel file is required');
					return back();
			}

			$remaining = $total_reports-$successful_creations ;
			//$request->session()->flash('success', $successful_creations.' items created successfuly, '.$remaining.' failed to be created');
			return redirect('report')->with(['message' => \SiteHelpers::alert('success',$successful_creations.' items created successfuly, '.$remaining.' failed to be created')]);
	}

	public function statitics()
	{
			$this->data['row'] = $this->model->getColumnTable('reports');
			$operators = \App\Models\Operator::all() ;
			$this->data['operators']  = $operators;
			return view('report.statistics',$this->data);
	}

	public function get_statistics(Request $request)
	{
		$from_year = $request['duration'][0];
		$from_month = $request['duration'][1] ;
		$to_year = $request['duration'][2];
		$to_month = $request['duration'][3];
		$operator = $request['duration'][4];
		//Sreturn [$from_year,$from_month,$to_year,$to_month,$operator];
		$operator_query = "" ;
		if ($operator)
				$operator_query = " AND reports.operator_id = ". $operator ;

		$query = 'SELECT
							reports.* , rbts.track_title_en AS rbt_name,
							tb_operators.name
							FROM reports
							JOIN tb_operators ON reports.operator_id = tb_operators.id
							JOIN rbts ON reports.rbt_id = rbts.id
							WHERE (reports.year > '.$from_year.' OR ( reports.month >= '.$from_month.' AND reports.year = '.$from_year.')) AND (reports.year < '.$to_year.' OR ( reports.month <= '.$to_month.' AND reports.year = '.$to_year.')) '.$operator_query.'
							ORDER BY year ASC, month ASC ' ;

		$reports = \DB::select($query) ;
		return $reports ;
	}

	public function search()
	{
		$this->data['row'] = $this->model->getColumnTable('reports');
		$operators = \App\Models\Operator::all()->pluck('name','id');
		$providers = \App\Models\providers::all()->pluck('provider_name','id');
		$aggregators = \App\Models\aggregators::all()->pluck('aggregator_name','id');
		$this->data['operators'] = $operators;
		$this->data['providers'] = $providers;
		$this->data['aggregators'] = $aggregators;
			return view('report.search',$this->data) ;
	}

	public function search_result(Request $request)
	{
			$report_columns = \Schema::getColumnListing('reports');
			$columns = array(1=>"year",2=>"month",3=>"classification",4=>"code",
					5=>"rbt_name", 6=>"rbt_id",7=>"download_no",8=>"total_revenue",9=>"revenue_share",10=>"operator_id",11=>"provider_id",14=>"aggregator_id",12=>"from",13=>"to");
			$search_key_value = array() ;
			foreach ($request['search_field'] as $index=>$item) {
					if (strlen($item)==0 || !strcmp($item,"undefined"))
							continue ;
					else {
							if ($index==12){
									$item = date("Y-m-d",strtotime($item));
									$search_key_value['from'] = $item ;
							}
							elseif($index==13)
							{
									$item = date("Y-m-d",strtotime($item));
									$search_key_value['to'] = $item ;
							}
							elseif (array_search($columns[$index],$report_columns))
							{
									$search_key_value[$columns[$index]] = $item ;
							}
					}
			}
			$string_query = "" ;
			$counter = 0 ;
			$size = count($search_key_value) ;
			foreach ($search_key_value as $index=>$value)
			{
					$sign = "=" ;
					if ($index == "to")
					{
							$sign = "<=" ;
							$index = "created_at" ;
					}
					elseif($index=="from")
					{
							$sign = ">=" ;
							$index = "created_at" ;
					}

					$counter++ ;
					if ($counter == $size)
					{
							$string_query .= "`reports`.`$index`"." $sign '$value'" ;
					}
					else
					{
							$string_query .= "`reports`.`$index`"." $sign '$value' AND ";
					}
			}
			$select = "SELECT reports.* , tb_operators.name AS operator_title, providers.provider_name AS provider_title, aggregators.aggregator_name AS aggregator_title
								 FROM reports
								 Left JOIN providers ON reports.provider_id = providers.id
								 Left JOIN aggregators ON reports.aggregator_id = aggregators.id
								 JOIN tb_operators ON reports.operator_id = tb_operators.id " ;
			if (empty($string_query))
					$where = "";
			else
					$where = " WHERE ".$string_query." ORDER BY reports.total_revenue DESC" ;

					// if(Auth::user()->hasRole(['account']))
					// {
					// 	if($where){
					// 	$select  .=" And aggregators.id=".Auth::user()->aggregator_id;
					// 	}
					// 	else{
					// 		$select  .=" where aggregators.id=".Auth::user()->aggregator_id;
					// 	}
					// }
			$query = $select.$where;
			$search_result = \DB::select($query) ;
			return $search_result ;
	}
}
