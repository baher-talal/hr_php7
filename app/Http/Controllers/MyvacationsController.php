<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Config;
use App\Models\Myvacations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input;
use Lang;
use Redirect;
use Validator;

class MyvacationsController extends Controller
{

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'myvacations';
    static $per_page = '10';

    public function __construct()
    {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Myvacations();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'myvacations',
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
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'Desc');
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
        $pagination->setPath('myvacations');

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
        return view('myvacations.index', $this->data);
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

// validation for employee vacations limit  // we will remove this check
        /*
        $Employee = User::find(\Auth::user()->id);
        if($Employee->annual_credit == 0 ){  //
        return Redirect::to('dashboard')
        ->with('messagetext', \Lang::get('You has finished all your vacations'))->with('msgstatus','error');
        }
         */

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_vacations');
        }

        $this->data['id'] = $id;
        return view('myvacations.form', $this->data);
    }

    public function getShow($id = null)
    {

        if ($this->access['is_detail'] == 0) {
            return Redirect::to('dashboard')
                ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

// to let each employees see his vacation only
        $MyVacation = Myvacations::where('id', '=', $id)->where('employee_id', '=', \Auth::user()->id)->first();
        if ($MyVacation === null) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_vacations');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('myvacations.view', $this->data);
    }

    public function postSave(Request $request)
    {

// $rules = $this->validateForm();
        $rules = array(
            'type_id' => 'required |integer',
            'from' => 'required',
            'to' => 'required',
            //  'peroid' => 'required |integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_myvacations');

            $user = User::find(\Auth::user()->id);
// dd($user);
            if ($user) {
                $departmentId = $user->department_id;
                $department = \DB::table('tb_departments')->where('id', $departmentId)->first();
                $mangerId = $department->manager_id;
                $manger = User::find($mangerId);
            }

            $data['employee_id'] = $user->id;
            $data['department_id'] = $departmentId;
            $data['manager_id'] = $mangerId;
            $data['date'] = date("Y-m-d");

            if ($data['to'] == $data['from']) {
                $data['peroid'] = 1;
            } elseif ($data['to'] > $data['from']) {
                $date1 = new \DateTime($data['from']);
                $date2 = new \DateTime($data['to']);
                $data['peroid'] = $date2->diff($date1)->format("%a") + 1;
            } else {
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                    ->withErrors('To Date must be greater than or equal From Date')->withInput();
            }

// to make validation that employee vacations  not exceed 21
            if ($user->annual_credit == 0 && $data['type_id'] != 4) { // 4 = unpaid vacation
                return Redirect::back()
                    ->with('messagetext', \Lang::get('You has finished all your vacations !'))->with('msgstatus', 'error');
            } elseif ($user->annual_credit - $data['peroid'] < 0 && $data['type_id'] != 4) {
                return Redirect::back()
                    ->with('messagetext', \Lang::get(' You request vacations days greater than your credit !'))->with('msgstatus', 'error');
            } else {
                if ($data['type_id'] == 2) { // Emergency
                    // count number of emergency vaction has been taken
                    $emergency_vactions = \App\Models\vacations::where('type_id', 2)->where('employee_id', $user->id)->where('from', 'LIKE', date("Y") . "%")->sum('peroid');
                    if ($emergency_vactions == 6) {
                        return Redirect::back()
                            ->with('messagetext', \Lang::get(' You has finished all your emergency vacations !'))->with('msgstatus', 'error');
                    } else {
                        $emergency_credit = 6 - $emergency_vactions;
                        if ($emergency_credit - $data['peroid'] < 0) {
                            return Redirect::back()
                                ->with('messagetext', \Lang::get(' You request vacations days greater than your credit !'))->with('msgstatus', 'error');
                        } else {
                            if ($data['peroid'] > 2) {
                                return Redirect::back()
                                    ->with('messagetext', \Lang::get(" You Can't request more than 2 days Emergency on one time!"))->with('msgstatus', 'error');
                            } else {
                                $enable_vacation_all_days = Config::where('cnf_id', 1)->first(); //enable_vacation_all_days
                                if($enable_vacation_all_days->enable_vacation_all_days == 0){
                                    $dateForm = date('l', strtotime($data['from']));
                                    if ($dateForm == "Thursday" || $dateForm == "Sunday") {
                                        return Redirect::back()
                                            ->with('messagetext', \Lang::get(" You Can't request emergency on Sunday OR Thursday !"))->with('msgstatus', 'error');
                                    }
                                }


                            }
                        }
                    }
                } elseif ($data['type_id'] == 1) { // Annual
                    // check created time
                    date_default_timezone_set("Africa/Cairo");
                    $date1 = new \DateTime();
                    $date2 = new \DateTime($data['from']);
                    $sub = $date1->diff($date2)->invert;
                    // if ($sub != 0) {
                    //     return Redirect::back()
                    //         ->with('messagetext', \Lang::get("You must request Annual vacation before one day at least !"))->with('msgstatus', 'error');
                    // }

                }
            }

            $id = $this->model->insertRow2($data, $request->input('id'));

// mean that department manager make vacation   ... so hr can approve to this
            if ($mangerId == $user->id) {
//$data['manager_approved'] = 1;
                // send notification to hr to can approve or refuse
                $subject = "New vacation request from :  " . $user->first_name . ' ' . $user->last_name;
                $link = 'vacations/update/' . $id;
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

// send notification to manager
            if ($mangerId != $user->id) { // employee make vacation and send notification to his manager
                $subject = "New vacation request from " . $user->first_name . ' ' . $user->last_name;
                $link = 'employeesvacations/update/' . $id;
                \SiteHelpers::addNotification($user->id, $mangerId, $subject, $link);

// send SMS
                if (isset($manger->phone_number)) {
                    $phone = $manger->phone_number;
                    $this->send_sms($phone, $subject, $link);
                }

// if employee is in managers team ...--- send notification and mail to ceo
                if ($departmentId == MANAGER_DEPARTMENT_ID) {

                    $department = \DB::table('tb_departments')->where('id', MANAGER_DEPARTMENT_ID)->first();
                    if ($department) {
                        $manager_user_id = $department->manager_id;
                    }
                    $link = 'vacations/show/' . $id;
                    $manager_user = \DB::table('tb_users')->where('id', $manager_user_id)->first();
                    \SiteHelpers::addNotification($user->id, $manager_user->id, $subject, $link);

// send SMS
                    $phone = $manager_user->phone_number;
                    $this->send_sms($phone, $subject, $link);
                }
            }

            if (!is_null($request->input('apply'))) {
                $return = 'myvacations/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'myvacations?return=' . self::returnUrl();
            }

// Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('myvacations/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('myvacations')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('myvacations')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
