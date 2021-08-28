<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mypermissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class MypermissionsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'mypermissions';
    static $per_page = '10';

    public function __construct() {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Mypermissions();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'mypermissions',
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
        $pagination->setPath('mypermissions');

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
        return view('mypermissions.index', $this->data);
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




        // make limit to permissions to be 2 per month   // here 2 is PERMISSIONS_PER_MONTH as constant and can chnaged from setting by our HR
        // to make permission from 21 prev month to 20 current month  ( HR cycle is :  21 to 20)
        $currentDay = date("d");
        $currentMonth = date("n");

        if ($currentMonth == 12) {
            if ($currentDay < 21) {  // ex: 20/12 .... cycle = 21/11 to 20/12 current year
                $prevMonth = 11;
                $nextMonth = 12;
                $prevYear = date("Y");
                $nextYear = date("Y");
            } else {  // ex:  21/12   ... cycle = 21/12  to 20/1 next year
                $prevMonth = 12;
                $nextMonth = 1;
                $prevYear = date("Y");
                $nextYear = date("Y") + 1;
            }
        } elseif ($currentMonth == 1) {
            if ($currentDay < 21) {  // ex: 20/1 .... cycle = 21/12 to 20/1 next year
                $prevMonth = 12;
                $nextMonth = 1;
                $prevYear = date("Y") - 1;
                $nextYear = date("Y");
            } else {  // ex:  21/1   ... cycle = 21/1  to 20/2
                $prevMonth = 1;
                $nextMonth = 2;
                $prevYear = date("Y");
                $nextYear = date("Y");
            }
        } else {  // normal case
            if($currentDay < 21){ // ex: 20/2   ... cycle 21/1 to 20/2  current year
                $prevMonth = $currentMonth-1 ;
                $nextMonth = $currentMonth ;
            }else{  // ex: 21/2   ... cycle 21/2 to 20/3
                $prevMonth = $currentMonth ;
                $nextMonth = $currentMonth + 1;
            }

            $prevYear = date("Y") ;
            $nextYear =  date("Y")  ;
        }


        // Formatting a number with leading zeros in PHP
        // https://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
        $prevMonthL = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);
        $nextMonthL = str_pad($nextMonth, 2, '0', STR_PAD_LEFT);

        $start_date = date($prevYear."-".$prevMonthL."-21");
        $end_date = date($nextYear."-" . $nextMonthL . "-20");

        $currentUserId = \Auth::user()->id;


        // get hours of all permission of user except  manager not approve
        $permissionsHours = \DB::select(\DB::raw("SELECT SUM(hours) AS All_permission_Hours FROM tb_permissions WHERE  employee_id = {$currentUserId} AND  (manager_approved  !=  0 OR manager_approved IS NULL ) AND  (date BETWEEN '{$start_date}' AND '{$end_date}') "));  // SNUM()  return float No#


        // to handle case if exceed  permissions credit
        if ($permissionsHours && $permissionsHours[0]->All_permission_Hours >= PERMISSIONS_Hours_PER_MONTH) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('You exceed your permissions credit per this month !'))->with('msgstatus', 'error');
        }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_permissions');
        }


        $this->data['id'] = $id;
        return view('mypermissions.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        // to let each employees see his vacation only
        $MyPermission = Mypermissions::where('id', '=', $id)->where('employee_id', '=', \Auth::user()->id)->first();
        if ($MyPermission === NULL) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_permissions');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('mypermissions.view', $this->data);
    }

    function postSave(Request $request) {
        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_mypermissions');
            // morning premission
            $type = $request->type;
           if ($type == 1) {
               if($data['from'] != "09:00am")
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')->withErrors('Morning Permission Should Start At 9:00 AM')->withInput();

            }
           elseif ($type == 2) {
               if($data['to'] != "07:00pm")
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')->withErrors('Evening Permission Should End At 7:00 PM')->withInput();

            }
            else{
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')->withErrors('You Should Select Permission Type')->withInput();
            }

            $time1 = strtotime($data['from']);
            $time2 = strtotime($data['to']);
            $diff = $time2 - $time1;
            $time_diff = date('H:i', $diff);
            $time_hours = date('H', $diff);
            $time_minutes = date('i', $diff);

            if ($time1 >= $time2) {
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')->withErrors('Permission To hour must be greater than From hour')->withInput();
            } elseif ($time_hours > PERMISSIONS_Hours_PER_MONTH  ) {
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')->withErrors('Permission peroid should not exceed ' . PERMISSIONS_Hours_PER_MONTH . ' hours')->withInput();
            }
            $data['hours'] = $time_hours;







            // make limit to permissions to be 2 per month   // here 2 is PERMISSIONS_PER_MONTH as constant and can chnaged from setting by our HR
            // to make permission from 21 prev month to 20 current month  ( HR cycle is :  21 to 20)
            $currentDay = date("d");
            $currentMonth = date("n");

            if ($currentMonth == 12) {
                if($currentDay < 21){  // ex: 20/12 .... cycle = 21/11 to 20/12 current year
                    $prevMonth = 11;
                    $nextMonth = 12 ;
                    $prevYear = date("Y")  ;
                    $nextYear =  date("Y")  ;

                }else{  // ex:  21/12   ... cycle = 21/12  to 20/1 next year
                    $prevMonth = 12;
                    $nextMonth = 1 ;
                    $prevYear = date("Y")  ;
                    $nextYear =  date("Y") + 1 ;
                }

            }elseif ($currentMonth == 1){
                if($currentDay < 21){  // ex: 20/1 .... cycle = 21/12 to 20/1 next year
                    $prevMonth = 12;
                    $nextMonth = 1 ;
                    $prevYear = date("Y") - 1 ;
                    $nextYear =  date("Y") ;
                }else{  // ex:  21/1   ... cycle = 21/1  to 20/2
                    $prevMonth = 1 ;
                    $nextMonth = 2 ;
                    $prevYear = date("Y") ;
                    $nextYear =  date("Y") ;
                }


            } else {  // normal case
                if($currentDay < 21){ // ex: 20/2   ... cycle 21/1 to 20/2  current year
                    $prevMonth = $currentMonth-1 ;
                    $nextMonth = $currentMonth ;
                }else{  // ex: 21/2   ... cycle 21/2 to 20/3
                    $prevMonth = $currentMonth ;
                    $nextMonth = $currentMonth + 1;
                }

                $prevYear = date("Y") ;
                $nextYear =  date("Y")  ;
            }


            // Formatting a number with leading zeros in PHP
            // https://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
            $prevMonthL = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);
            $nextMonthL = str_pad($nextMonth, 2, '0', STR_PAD_LEFT);

            $start_date = date($prevYear."-".$prevMonthL."-21");
            $end_date = date($nextYear."-" . $nextMonthL . "-20");

            $currentUserId = \Auth::user()->id;


            // get hours of all permission of user except  manager not approve
            $permissionsHours = \DB::select(\DB::raw("SELECT SUM(hours) AS All_permission_Hours FROM tb_permissions WHERE  employee_id = {$currentUserId}  AND (manager_approved  !=  0 OR manager_approved IS NULL )  AND  (date BETWEEN '{$start_date}' AND '{$end_date}') "));


            // to handle case if exceed  permissions credit
            if ($permissionsHours) {
                if ($permissionsHours[0]->All_permission_Hours >= PERMISSIONS_Hours_PER_MONTH) {
                    return Redirect::to('dashboard')
                                    ->with('messagetext', \Lang::get('You exceed your permissions credit per this month !'))->with('msgstatus', 'error');
                }
                // to handle case user enter hours more than available
                $available_hours= PERMISSIONS_Hours_PER_MONTH - $permissionsHours[0]->All_permission_Hours;
                if ($data['hours'] > $available_hours) {
                    return Redirect::back()
                                    ->with('messagetext', \Lang::get('You only have ' .$available_hours.' hour  permission credit per this month !'))->with('msgstatus', 'error')->withErrors('You only have ' .$available_hours.' hour  permission credit per this month !')->withInput();;
                }
            }


            // to let employee create new permission  "MyPermissions module"
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


            $id = $this->model->insertRow2($data, $request->input('id'));

            // mean that department manager make permission   ... so hr can approve to this
            if ($mangerId == $user->id) {
                //$data['manager_approved'] = 1;
                // send notification to hr to can approve or refuse
                $subject = "New permission request from :  " . $user->first_name . ' ' . $user->last_name;
                $link = 'permissions/update/' . $id;
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
            if ($mangerId != $user->id) {  // employee make permission and send notification to his manager
                $subject = "New permission request from " . $user->first_name . ' ' . $user->last_name;
                $link = 'employeespermissions/update/' . $id;
                \SiteHelpers::addNotification($user->id, $mangerId, $subject, $link);


                // send SMS
                $phone = $manger->phone_number;
                $this->send_sms($phone,$subject,$link);

            }


            if (!is_null($request->input('apply'))) {
                $return = 'mypermissions/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'mypermissions?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('mypermissions/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('mypermissions')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('mypermissions')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
