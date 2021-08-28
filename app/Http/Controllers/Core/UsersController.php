<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\Core\Config;
use App\Models\Core\Users;
use Illuminate\Http\Request;
use App\Models\Core\Groups;
use App\Models\Perdiempositions;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Datetime;
use Excel;

class UsersController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'users';
    static $per_page = '10';

    public function __construct()
    {
        parent::__construct();
        // $this->beforeFilter('csrf', array('on'=>'post'));
        $this->model = new Users();
        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'core/users',
            'return' => self::returnUrl(),

        );

        $lang = \Session::get('lang');
        \App::setLocale($lang);
    }

    public function getIndex(Request $request) {

        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'Desc');
        // End Filter sort and order for query
        // Filter Search for query
        // $filter = (!is_null($request->input('search')) ? '': '');
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        $filter .= " AND tb_users.group_id >= '" . \Session::get('gid') . "'";

        if ($request->department_id) {
            $this->data['department_id'] = $request->department_id;
            $filter .= " AND department_id ='{$request->department_id}'";
        }



        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query
        $results = $this->model->getRows($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('users');

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
        return view('core.users.index', $this->data);
    }

    function getUpdate(Request $request, $id = null) {


        $userId = \Auth::user()->id;
        if ($userId != 1) {
            $groups = Groups::where('group_id', '!=', '1')->pluck('name', 'group_id');
        } else {
            $groups = Groups::pluck('name', 'group_id');
        }



        $Perdiempositions = Perdiempositions::pluck('position', 'id');

        $arrarrarr = \DB::table('tb_departments')->pluck('title', 'id');

        // dd($arrarrarr);

        $this->data['departments'] = $arrarrarr ;
        // $this->data['departments'] = ['' => 'Select Department'] + \DB::table('tb_departments')->pluck('title', 'id');

        if ($id == '') {
            if ($this->access['is_add'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        if ($id != '') {
            if ($this->access['is_edit'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_users');
        }

        $this->data['id'] = $id;
        $this->data['groups'] = $groups;
        $this->data['Perdiempositions'] = $Perdiempositions;
        $this->data['tb_config']= Config::where('cnf_id', 1)->first();
        return view('core.users.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_users');
        }
        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('core.users.view', $this->data);
    }

    public function getResetLimit($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');


        if ($id) {
            $sql = "UPDATE tb_users SET messages_send = 0   WHERE id ={$id} ";
            \DB::statement($sql);
        }
        return Redirect::back()->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
    }

    function postSave(Request $request, $id = 0) {
        // $rules = $this->validateForm();

        $rules = array();
        if ($request->input('id') == '') {
            $rules['password'] = 'required|alpha_num|between:6,25';
            $rules['password_confirmation'] = 'required|alpha_num|between:6,25';
            $rules['email'] = 'required|email|unique:tb_users';
            $rules['phone_number'] = 'unique:tb_users,phone_number';
            $rules['username'] = 'required|unique:tb_users';
            // $rules['employee_finger_id'] = 'required|integer';
            $rules['employee_finger_id'] = 'integer';
        } else {
            if ($request->input('password') != '') {
                $rules['password'] = 'required|alpha_num|between:6,25';
                $rules['password_confirmation'] = 'required|alpha_num|between:6,25';
            }
            $rules['username'] = 'required|unique:tb_users,username,' . $request->input('id');
            $rules['phone_number'] = 'unique:tb_users,phone_number,' . $request->input('id');
            //  $rules['employee_finger_id'] = 'required|integer';
            $rules['employee_finger_id'] = 'integer';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $data = $this->validatePost('tb_users');



            if ($request->input('id') == '') {
                $data['password'] = \Hash::make(Input::get('password'));
            } else {
                if (Input::get('password') != '') {
                    $data['password'] = \Hash::make(Input::get('password'));
                }
            }

            $this->model->insertRow($data, $request->input('id'));
            if (!is_null($request->input('apply'))) {
                $return = 'core/users/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'core/users?return=' . self::returnUrl();
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {


            return Redirect::to('core/users/update/' . $request->input('id'))->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    public function postResettoken(Request $request) {
        // echo "fffffffff" ; die;
        $data = array();
        $data['mobile_token'] = '';
        \DB::table('tb_users')->where('id', $request->input('id'))->update($data);
        return true;
    }

    public function getResettoken($id) {
        $this->data['user_id'] = $id;
        return view('core.users.resettoken', $this->data);
    }

    public function postDelete(Request $request) {

        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            // redirect
            return Redirect::to('core/users')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('core/users')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    function getBlast() {
        $this->data = array(
            'groups' => Groups::all(),
            'pageTitle' => 'Blast Email',
            'pageNote' => 'Send email to users'
        );
        return view('core.users.blast', $this->data);
    }

    function postDoblast(Request $request) {

        $rules = array(
            'subject' => 'required',
            'message' => 'required|min:10',
            'groups' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            if (!is_null($request->input('groups'))) {
                $groups = $request->input('groups');
                for ($i = 0; $i < count($groups); $i++) {
                    if ($request->input('uStatus') == 'all') {
                        $users = \DB::table('tb_users')->where('group_id', '=', $groups[$i])->get();
                    } else {
                        $users = \DB::table('tb_users')->where('active', '=', $request->input('uStatus'))->where('group_id', '=', $groups[$i])->get();
                    }
                    $count = 0;
                    foreach ($users as $row) {

                        $to = $row->email;
                        $subject = $request->input('subject');
                        $message = $request->input('message');
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: ' . CNF_APPNAME . ' <' . CNF_EMAIL . '>' . "\r\n";
                        mail($to, $subject, $message, $headers);

                        $count = ++$count;
                    }
                }
                return Redirect::to('core/users/blast')->with('messagetext', 'Total ' . $count . ' Message has been sent')->with('msgstatus', 'success');
            }
            return Redirect::to('core/users/blast')->with('messagetext', 'No Message has been sent')->with('msgstatus', 'info');
        } else {

            return Redirect::to('core/users/blast')->with('messagetext', 'The following errors occurred')->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    // to reset all vacations for all employess = users
    function resetVacations() {

        $users = Users::all();
        if ($users) {
            foreach ($users as $user) {
                $user->vacations_number_per_year = 0;
                $user->save();
            }
            return Redirect::to('core/users')->with('messagetext', 'All vacations for all employees has been reset successfully')->with('msgstatus', 'success');
        }
    }

    function postSearch(Request $request) {
        if (isset($request->search) && trim($request->search) != "") {
            $search = $request->search;
            return redirect('core/users?search=email:' . $search);
        } else {
            return redirect('core/users');
        }
    }

    // import from excel
    public function getExcelsample(Request $request) {
        \Excel::create('sample_users_sheet' . '-' . date("d/m/Y"), function ($excel) {
            $excel->sheet('Users', function ($sheet) {
                $info = $this->model->makeInfo($this->module);
                $fields = $info['config']['grid'];

                $arr = array();

                foreach ($fields as $f) {
                    if ($f['label'] != 'Id' AND $f['label'] != 'Avatar' AND $f['label'] != 'Group' AND $f['label'] != 'Login Attempt'
                            AND $f['label'] != 'Password' AND $f['label'] != 'Active' AND $f['label'] != 'Activation' AND $f['label'] != 'Remember Token'
                            AND $f['label'] != 'Last Activity' AND $f['label'] != 'Mobile Token'AND $f['label'] != 'Is Login'

                            AND $f['label'] != 'Entry By' AND $f['label'] != 'Ivas Login Inside'AND $f['label'] != 'Cv') {
                        $arr[$f['label']] = $f['label'];
                    }
                }

                $sheet->setSize('A1', 25, 18);

                $sheet->row(1, $arr);
                $sheet->freezeFirstRow();
                $sheet->cell('A1', function ($cell) {

                });
            });
        })->download('xlsx');
    }

    public function getUpload(Request $request, $id = null) {
        if ($id == '') {
            if ($this->access['is_add'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        if ($id != '') {
            if ($this->access['is_edit'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_users');
        }
        $this->data['id'] = $id;
        return view('core.users.upload', $this->data);
    }

    function postUpload(Request $request) {

        $rules = array(
            'users_sheet' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            // insert employees attendance from excel sheet
            if ($request->file('users_sheet') != NULL) {

                $file = $request->file('users_sheet');  // to get image
                $destionPath = "users_sheet";  // destion path inside "public"
                $fileName = $file->getClientOriginalName();  // to get the name of uploaded file by build-in class  getClientOriginalName()

                $rand = rand(1000, 100000000);
                $newfilename = strtotime(date('Y-m-d H:i:s')) . '-' . $rand . '-' . $fileName;
                $file->move($destionPath, $newfilename);  // to move file to destion path

                $objPHPExcel = \PHPExcel_IOFactory::load("users_sheet/" . $newfilename);   // this can read excel file or  csv file
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $Rows = $objWorksheet->toArray();

                if ($Rows) {
                    $msg = "<ul>";
                    $i = 0;
                    $f = 0;
                    $errorKey = array();
                    foreach ($Rows as $key => $value) {

                        if ($key > 0) {      // to make sure cell not empty
                            if (trim($value[0]) == '') {
                                $f++;
                                $msg.= "<li>The Username Can't be empty at row " . $key . "</li>";
                                continue;
                            }
                            if (trim($value[3]) == '') {
                                $f++;
                                $msg.= "<li>The Email Can't be empty at row " . $key . "</li>";
                                continue;
                            }
                            $checkuser = Users::where('username', trim($value[0]))->exists();
                            if ($checkuser)
                                $msg.="<li>At row " . $key . " : The Username '" . trim($value[0]) . "' has already been taken</li>";
                            $checkemail = Users::where('email', trim($value[3]))->exists();
                            if ($checkemail)
                                $msg.= "<li>At row " . $key . " : The Email '" . trim($value[3]) . "' has already been taken </li>";
                            $checkphone = Users::where('phone_number', trim($value[11]))->where('phone_number', '!=', '')->exists();
                            if ($checkphone)
                                $msg.="<li>At row " . $key . " : The Phone number '" . trim($value[11]) . "' has already been taken </li>";

                            if (!$checkemail && !$checkphone && !$checkuser) {
                                $i++;
                                $department_id = \App\Models\departments::where('title', trim($value[4]))->select('id')->first();
                                $department_id = $department_id->id;
                                $user = new Users();
                                $user->username = trim($value[0]);
                                $user->first_name = trim($value[1]);
                                $user->last_name = trim($value[2]);
                                $user->email = trim($value[3]);
                                $user->department_id = $department_id;
                                $user->created_at = trim($value[5]);
                                $user->last_login = trim($value[6]);
                                $user->reminder = trim($value[7]);
                                $user->updated_at = trim($value[8]);
                                $user->annual_credit = trim($value[9]);
                                $user->per_diem_position_id = trim(intval($value[10]));
                                $user->phone_number = trim($value[11]);
                                $user->employee_finger_id = trim(intval($value[12]));
                                $user->password = \Hash::make('123456');
                                $user->active = 1;
                                $user->entry_by = \Auth::user()->id;
                                $user->group_id = 6;
                                $user->save();
                            } else {
                                $f++;
                                array_push($errorKey, $key);   // the rows that has errors
                            }
                        }
                    }
                }
                if ($msg != '<ul>') {
                    $msg.='</ul>';
                    $errorFile = $this->getErrorTable($newfilename, $errorKey);
                    $error = '<b>' . $f . " row(s) has error / you can check errors at the file : <a href='" . url('core/users/downloaderror/' . $errorFile) . "'>$errorFile </a></b>" . $msg;
                    $request->session()->flash('warning', $error);
                }
                $request->session()->flash('count', " <b> $i </b> User(s) has Successfully Saved");
                return Redirect::to('core/users')->with('messagetext', \Lang::get('core.excel file is uploded successfully') . "<br/> $i User has Successfully Saved")->with('msgstatus', 'success')->withErrors($msg);
            } else {
                return Redirect::back()->with('messagetext', \Lang::get('core.you_must_upload_excel_file'))->with('msgstatus', 'error');
            }
        } else {

            return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    public function getErrorTable($newfilename, $errorKey) {
        $nuRows = count(Excel::load('users_sheet/' . $newfilename)->get());
        $excel = Excel::load('users_sheet/' . $newfilename, function($file) use($errorKey, $nuRows) {
                    $sheet = $file->sheet(0);
                    // set bacground for all rows
                    for ($i = 1; $i <= $nuRows + 1; $i++) {
                        $sheet->row($i, function($row) {
                            $row->setBackground('#FFFFFF');
                        });
                    }

                    // set background for rows that contain errors
                    foreach ($errorKey as $k) {
                        $sheet->row($k + 1, function($row) {
                            $row->setBackground('#FFF000');
                        });
                    }
                })->setFilename('UserErrors_' . strtotime(date('Y-m-d H:i:s')))->store('xlsx', storage_path('excelErrors/'), true);
        $filename = $excel['file'];
        return $filename;
    }

    public function getDownloaderror($filename) {
        Excel::load('storage/excelErrors/' . $filename)->download();
    }

    public function getDepartmentusers($Did) {

        $department = \Illuminate\Support\Facades\DB::table('tb_departments')->where('id', $Did)->first();

        $users = Users::where('department_id', $Did)->orderBy('level', 'asc')->get();

        return view('core.users.order', compact('users', 'department'));
    }

    public function getUpdatelevel(Request $request) {

        $users = json_decode($request->users);
        $i = 1;
        foreach ($users as $val) {
            $user = Users::find($val->id);
            $user->level = $i;
            $user->save();
            $i++;
        }
    }

}
