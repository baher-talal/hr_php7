<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Myovertime;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class MyovertimeController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'myovertime';
    static $per_page = '10';

    public function __construct() {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Myovertime();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'myovertime',
            'return' => self::returnUrl()
        );
    }

    public function getIndex(Request $request) {

        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'Desc');
        // End Filter sort and order for query
        // Filter Search for query
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


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
        $pagination->setPath('myovertime');

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
        return view('myovertime.index', $this->data);
    }

    function getUpdate(Request $request, $id = null) {

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
            $this->data['row'] = $this->model->getColumnTable('tb_overtimes');
        }


        $this->data['id'] = $id;
        return view('myovertime.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        // to let each employees see his overtime only
        $Myovertime = Myovertime::where('id', '=', $id)->where('employee_id', '=', \Auth::user()->id)->first();
        if ($Myovertime === NULL) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_overtimes');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('myovertime.view', $this->data);
    }

    function postSave(Request $request) {
        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_myovertime');

            /*
            if (!preg_match('/^(0[0-8])\.([0-5][0-9])$/', $data['no_hours'])) {
                 return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors('Overtime Hours format must be like Hours.minutes like 01.30 and for fullDay write 08.00 ')->withInput();
            }
            */



            $time1 = strtotime($data['from']);
            $time2 = strtotime($data['to']);
            $diff = $time2 - $time1;
            $time_diff = date('H:i', $diff);
            $time_hours = date('H', $diff);
            $time_minutes = date('i', $diff);
            $time_minutes_percentage = ($time_minutes * 100) / 60 ;
            if($time_minutes_percentage == 0){
                $time_minutes_percentage .= 0 ;
            }




          if ($time_hours > 8 || $time_hours == 8 && $time_minutes > 0) {
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')->withErrors('Overtime peroid should not exceed 8  hours')->withInput();
            }
            $data['no_hours'] = $time_hours.'.'.$time_minutes_percentage;




            // to let employee create new overtime  "Myovertime module"
            $user = User::find(\Auth::user()->id);
            if ($user) {
                $departmentId = $user->department_id;
                $department = \DB::table('tb_departments')->where('id', $departmentId)->first();
                $mangerId = $department->manager_id;
                 $manger = User::find($mangerId);
            }

            $data['employee_id'] = $user->id;
            $data['department_id'] = $departmentId;
            $data['manager_id'] = $mangerId;
           // $data['no_hours'] = str_replace(":", ".", $data['no_hours']);





            $id = $this->model->insertRow2($data, $request->input('id'));
            // mean that department manager make overtime   ... so hr can approve to this
            if ($mangerId == $user->id) {
                //$data['manager_approved'] = 1;
                // send notification to hr to can approve or refuse
                $subject = "New overtime request from manager:  " . $user->first_name . ' ' . $user->last_name;
                $link = 'overtimes/update/' . $id;
                // $HR = \DB::table('tb_users')->where('group_id', 3)->first();  // first hr in system
                $HRS = \DB::table('tb_users')->where('group_id', 3)->get();  // first hr in system
                $hr_subject = '';
                $hr_link = '';
                foreach ($HRS as $HR) {
                    \SiteHelpers::addNotification(\Auth::user()->id, $HR->id, $hr_subject, $hr_link);
                    // send SMS
                    // $phone = $HR->phone_number;
                    // $this->send_sms($phone,$hr_subject, $hr_link);
                }
            }



            // send notification to manager if empployee request overtime from his manager
            if ($mangerId != $user->id) {  // employee make overtime and send notification to his manager
                $subject = "New overtime request from " . $user->first_name . ' ' . $user->last_name;
                $link = 'employeesovertime/update/' . $id;
                \SiteHelpers::addNotification($user->id, $mangerId, $subject, $link);

                // send SMS
                    $phone = $manger->phone_number;
                    $this->send_sms($phone,$subject, $link);

            }



            if (!is_null($request->input('apply'))) {
                $return = 'myovertime/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'myovertime?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    public function postDelete(Request $request) {

        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('myovertime')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('myovertime')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
