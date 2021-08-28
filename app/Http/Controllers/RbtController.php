<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rbt;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input;
use Redirect;
use Validator;

class RbtController extends Controller
{

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'rbt';
    static $per_page = '10';

    public function __construct()
    {

        //$this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Rbt();

        $this->info = $this->model->makeInfo($this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'rbt',
            'return' => self::returnUrl(),

        );

    }

    public function getIndex(Request $request)
    {

        if ($this->access['is_view'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query
        // Filter Search for query
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0),
        );
        // Get Query
        $results = $this->model->getRows($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('rbt');

        $this->data['rowData'] = $results['rows'];
        // Build Pagination
        $this->data['pagination'] = $pagination;
        // Build pager number and append current param GET
        $this->data['pager'] = $this->injectPaginate();
        // Row grid Number
        $this->data['i'] = ($page * $params['limit']) - $params['limit'];
        // Grid Configuration
        $this->data['tableGrid'] = $this->info['config']['grid'];
        $this->data['tableForm'] = $this->info['config']['forms'];
        $this->data['colspan'] = \SiteHelpers::viewColSpan($this->info['config']['grid']);
        // Group users permission
        $this->data['access'] = $this->access;
        // Detail from master if any

        // Master detail link if any
        $this->data['subgrid'] = (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
        // Render into template
        return view('rbt.index', $this->data);
    }

    public function getUpdate(Request $request, $id = null)
    {

        if ($id == '') {
            if ($this->access['is_add'] == 0) {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            }

        }

        if ($id != '') {
            if ($this->access['is_edit'] == 0) {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            }

        }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('rbts');
        }

        $this->data['id'] = $id;
        $operators = \App\Models\Operator::all();
        $this->data['operators'] = $operators;
        return view('rbt.form', $this->data);
    }

    public function getShow($id = null)
    {

        if ($this->access['is_detail'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('rbts');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('rbt.view', $this->data);
    }

    public function postSave(Request $request)
    {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_rbt');
            foreach ($data as $key => $value) {
                if (empty($data[$key])) {
                    $data[$key] = null;
                }
                if($key == 'track_file'){
                    $data[$key] = 'uploads/track_file/'. $value;
                }
            }
            $id = $this->model->insertRow($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'rbt/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'rbt?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');

        } else {

            return Redirect::to('rbt/update/' . $request->input('id'))->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                ->withErrors($validator)->withInput();
        }

    }

    public function postDelete(Request $request)
    {

        if ($this->access['is_remove'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        // delete multipe rows
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('rbt')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');

        } else {
            return Redirect::to('rbt')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }

    }

    //our rbt function
    public function destroy($id, Request $request)
    {
        $rbt = \App\Models\Rbt::find($id);
        $rbt->delete();
        return back()->with(['message' => \SiteHelpers::alert('success', 'Deleted Successfull')]);
    }
    public function create_excel()
    {
        $this->data['row'] = $this->model->getColumnTable('rbts');
        $operators = \App\Models\Operator::all();
        $this->data['operators'] = $operators;
        return view('rbt.create', $this->data);
    }
    public function downloadSample()
    {
        $file = base_path() . "/rbt_system/rbt/rbt.xlsx";

        $headers = array(
            'Content-Type: application/xlsx',
        );
        return response()->download($file, 'rbt.xlsx', $headers);
    }
    public function getDownloadNew()
    {
        $file = base_path() . "/rbt_system/rbt/rbtNew.xlsx";

        $headers = array(
            'Content-Type: application/xlsx',
        );
        return response()->download($file, 'rbtNew.xlsx', $headers);
    }
    public function excelStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $counter = 0;
        $total_counter = 0;

        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', -1);

        if ($request->hasFile('fileToUpload')) {
            $ext = $request->file('fileToUpload')->getClientOriginalExtension();
            if ($ext != 'xls' && $ext != 'xlsx' && $ext != 'csv') {
                return back()->with(['message' => \SiteHelpers::alert('error', 'File Must be Excel')]);
            }

            $file = $request->file('fileToUpload');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!$file->move(base_path() . '/rbt_system/rbt/excel', $filename)) {
                return back()->with(['message' => \SiteHelpers::alert('error', 'Failed To Move File')]);
            }
            $arr_faild = [];

            Excel::filter('chunk')->load(base_path() . '/rbt_system/rbt/excel/' . $filename)->chunk(100, function ($results) use ($request, &$counter, &$total_counter, &$arr_faild) {
                
                foreach ($results as $row) {
                    $total_counter++;
                    
                    $rbt = \App\Models\Rbt::where('operator_id', $request->operator_id)->where('code', $row->code)->first();
                    if ($rbt) {
                        array_push($arr_faild, $row);
                        continue;
                    }
                    if (isset($row->code) && $row->code == "") {
                        array_push($arr_faild, $row);
                        continue;
                    }
                    if (isset($row->code) && $row->code != "") {
                        if (!is_numeric(str_replace(' ', '', $row->code))) {
                            array_push($arr_faild, $row);
                            continue;
                        }
                    }
                    if (isset($row->social_media_code) && $row->social_media_code != "") {
                        if (!is_numeric(str_replace(' ', '', $row->code))) {
                            array_push($arr_faild, $row);
                            continue;
                        }
                    }

                    if (isset($row->occasion) && $row->occasion != "") {

                        $check_occasion = \App\Models\Occasions::where('occasion_name', 'LIKE', '%' . $row->occasion . '%')->first();
                        if ($check_occasion) {
                            $occasion_id = $check_occasion->id;
                        } else {
                            $occ = array();
                            $occ['occasion_name'] = $row->occasion;
                            $create = \App\Models\Occasions::insertGetId($occ);
                            $occasion_id = $create;
                        }

                    } else {
                        $occasion_id = null;
                    }

                    $check_provider = \App\Models\providers::where('provider_name', 'LIKE', '%' . $row->content_owner . '%')->first();
                    if ($check_provider) {

                        $provider_id = $check_provider->id;
                    } else {
                        $prov = array();
                        $prov['provider_name'] = $row->content_owner;
                        $create = \App\Models\providers::insertGetId($prov);
                        $provider_id = $create;
                    }
                    
                    if ($request['type']) {
                        $rbt['artist_name_en'] = $row->artist_name_english;
                        $rbt['artist_name_ar'] = $row->artist_name_arabic; // not required
                        $rbt['track_title_en'] = $row->rbt_name_english;
                        $rbt['track_title_ar'] = $row->rbt_name_arabic; // not required
                        $rbt['album_name'] = $row->album; // not required
                        $rbt['provider_id'] = $provider_id; //  original content owner = Mashari Al Afasi
                        $rbt['occasion_id'] = $occasion_id;
                        $rbt['code'] = $row->codes;
                        $rbt['owner'] = $row->provider; // ex:  ARPU
                        $rbt['operator_id'] = $request->operator_id;
                        $rbt['aggregator_id'] = $request->aggregator_id;
                        $rbt['type'] = 1; // new excel
                    } else {
                        $rbt['code'] = $row->code;
                        $rbt['occasion_id'] = $occasion_id;
                        $rbt['track_title_en'] = $row->rbt_name;
                        $rbt['social_media_code'] = $row->social_media_code;
                        $rbt['provider_id'] = $provider_id;
                        $rbt['operator_id'] = $request->operator_id;
                        $rbt['aggregator_id'] = $request->aggregator_id;
                    }
                    $rbt['created_at'] = \Carbon\Carbon::now();
                    $rbt['updated_at'] = \Carbon\Carbon::now();
                    $rbt['track_file'] = "rbt_system/" . date('Y-m-d') . "/" . $rbt['track_title_en'] . ".wav";
                    $check = \App\Models\Rbt::insert($rbt);
                    if ($check) {
                        $counter++;
                    }
                }
            }, false);
        } else {
            return back()->with(['message' => \SiteHelpers::alert('error', 'Excel File Is Required')]);
        }
        //    unlink(base_path().'/rbt/excel/'.$filename);
        $failures = $total_counter - $counter;
        if ($failures > 0) {
            Excel::create("rbt_system/" . time() . "/" . 'failed', function ($excel) use ($arr_faild) {
                $excel->sheet(time() . '_failure', function ($sheet) use ($arr_faild) {
                    $sheet->loadView('rbt.failure', compact('arr_faild'));
                })->export('xls');
            });
        }
        return redirect('rbt')->with(['message' => \SiteHelpers::alert('success', $counter . ' item(s) created successfully, and ' . $failures . ' item(s) failed')]);
    }
    public function statitics()
    {
        $this->data['row'] = $this->model->getColumnTable('rbts');
        $operators = \DB::table('tb_operators')->get();
        $this->data['operators'] = $operators;
        return view('rbt.statistics', $this->data);
    }
    public function get_statistics(Request $request)
    {
        $from_year = $request['duration'][0];
        $from_month = $request['duration'][1];
        $to_year = $request['duration'][2];
        $to_month = $request['duration'][3];
        $operator = $request['duration'][4];
        $num_of_rbts = $request['duration'][5];
        $order_by = " ORDER BY reports.year ASC, reports.month ASC ";
        $operator_query = "";
        $where = "";
        $duration_query = "";
        $num_of_rbts_query = "";
        if ($operator) {
            $where = " WHERE ";
            $operator_query = " reports.operator_id = " . $operator;
        }
        if ($from_month && $from_year && $to_month && $to_year) {
            $where = " WHERE ";
            if ($operator) {
                $duration_query = ' AND (reports.year > ' . $from_year . ' OR ( reports.month >= ' . $from_month . ' AND reports.year = ' . $from_year . ')) AND (reports.year < ' . $to_year . ' OR ( reports.month <= ' . $to_month . ' AND reports.year = ' . $to_year . ')) ';
            } else {
                $duration_query = ' (reports.year > ' . $from_year . ' OR ( reports.month >= ' . $from_month . ' AND reports.year = ' . $from_year . ')) AND (reports.year < ' . $to_year . ' OR ( reports.month <= ' . $to_month . ' AND reports.year = ' . $to_year . ')) ';
            }

        }
        if ($num_of_rbts) {
            $num_of_rbts_query = " LIMIT " . $num_of_rbts . " OFFSET 0";
            $order_by = " ORDER BY reports.revenue_share DESC ";
        } else {
            $num_of_rbts_query = " LIMIT 10 OFFSET 0";
        }
        $query = 'SELECT reports.* , rbts.track_title_en AS rbt_name, tb_operators.name FROM reports JOIN tb_operators ON reports.operator_id = tb_operators.id JOIN rbts ON reports.rbt_id = rbts.id ' .
            $where . $operator_query . $duration_query . $order_by . $num_of_rbts_query;

        $reports = \DB::select($query);
        return $reports;
    }
    public function multi_upload()
    {
        $this->data['row'] = $this->model->getColumnTable('rbts');
        return view('rbt.multi_uploader', $this->data);
    }
    public function save_tracks(Request $request)
    {
        if (!file_exists('rbt_system/' . date('Y-m-d') . '/')) {
            mkdir('rbt_system/' . date('Y-m-d') . '/', 0777, true);
        }
        $vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
        $vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file name
        $vpb_file_size = $_FILES['upload_file']['size']; // File Size
        $vpb_uploaded_files_location = 'rbt_system/' . date('Y-m-d') . '/'; //This is the directory where uploaded files are saved on your server

        $vpb_final_location = $vpb_uploaded_files_location . $vpb_file_name; //Directory to save file plus the file to be saved
        //Without Validation and does not save filenames in the database
        if (move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)) {
            //Display the file id
            echo $vpb_file_id;
        } else {
            //Display general system error
            echo 'general_system_error';
        }

    }
    public function list_file_system()
    {
        $this->data['row'] = $this->model->getColumnTable('rbts');
        return view('rbt.file_system', $this->data);
    }
    public function get_file_system(Request $request)
    {
        $provider = \Session::get('provider');
        $data = array();
        //return public_path().'/userfiles/';
        if (!is_dir(public_path() . '/rbt_system')) {
            mkdir(public_path() . '/rbt_system', 0777, true);
        }

        $data['folder'] = './rbt_system';

        if (!is_null($request->get('cmd'))) {
            return view('core.elfinder.connector', $data);

        } else {
            return view('provider_interface.elfinder', $data);
        }

    }
    public function search()
    {
        $this->data['row'] = $this->model->getColumnTable('rbts');
        $operators = \App\Models\Operator::all()->pluck('name', 'id');
        $occasions = \App\Models\Occasions::all()->pluck('occasion_name', 'id');
        $aggregators = \App\Models\Aggregators::all()->pluck('aggregator_name', 'id');
        $providers = \App\Models\providers::all()->pluck('provider_name', 'id');
        $this->data['operators'] = $operators;
        $this->data['occasions'] = $occasions;
        $this->data['aggregators'] = $aggregators;
        $this->data['providers'] = $providers;
        return view('rbt.search', $this->data);
    }
    public function search_result(Request $request)
    {
        //return $request['search_field'];
        $rbt_columns = \Schema::getColumnListing('rbts');
        $columns = array(1 => "track_title_en", 2 => "track_title_ar", 3 => "artist_name_en", 4 => "artist_name_ar",
            5 => "album_name", 6 => "code", 7 => "social_media_code", 8 => "owner", 9 => "from", 10 => "to", 11 => "operator_id", 12 => "occasion_id", 13 => "aggregator_id", 14 => "provider_id", 15 => "type");

        $search_key_value = array();
        foreach ($request['search_field'] as $index => $item) {
            if (strlen($item) == 0 || !strcmp($item, "undefined")) {
                continue;
            } else {
                if ($index == 9) {
                    $item = date("Y-m-d", strtotime($item));
                    $search_key_value['from'] = $item;
                } elseif ($index == 10) {
                    $item = date("Y-m-d", strtotime($item));
                    $search_key_value['to'] = $item;
                } elseif (array_search($columns[$index], $rbt_columns)) {
                    $search_key_value[$columns[$index]] = $item;
                }
            }
        }
        $string_query = "";
        $counter = 0;
        $size = count($search_key_value);
        foreach ($search_key_value as $index => $value) {
            $sign = "=";
            if ($index == "to") {
                $sign = "<=";
                $index = "created_at";
            } elseif ($index == "from") {
                $sign = ">=";
                $index = "created_at";
            }

            $counter++;
            if ($counter == $size) {
                $string_query .= "`rbts`.`$index`" . " $sign '$value'";
            } else {
                $string_query .= "`rbts`.`$index`" . " $sign '$value' AND ";
            }
        }

        $select = "SELECT rbts.* , tb_operators.name AS operator_title, providers.provider_name AS provider_title,occasions.occasion_name AS occasion_title, aggregators.aggregator_name AS aggregator_title
								 FROM rbts
								 JOIN providers ON rbts.provider_id = providers.id
								 JOIN aggregators ON rbts.aggregator_id = aggregators.id
								 JOIN tb_operators ON rbts.operator_id = tb_operators.id
								 LEFT JOIN occasions ON rbts.occasion_id = occasions.id";

        if (empty($string_query)) {
            $where = "";
        } else {
            $where = " WHERE " . $string_query;
        }

        // if(Auth::user()->hasRole(['account']))
        // {
        //     if($where){
        //     $select  .=" And aggregators.id=".Auth::user()->aggregator_id;
        //     }
        //     else{
        //     $select  .=" where aggregators.id=".Auth::user()->aggregator_id;
        //     }
        // }

        $query = $select . $where;
        $search_result = \DB::select($query);
        return $search_result;
    }
}
