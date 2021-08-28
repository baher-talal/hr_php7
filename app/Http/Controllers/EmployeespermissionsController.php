<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employeespermissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class EmployeespermissionsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'employeespermissions';
    static $per_page = '10';

    public function __construct() {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Employeespermissions();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'employeespermissions',
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

        // to add condition in index view for sximo
        $managerId = \Auth::user()->id;
        $filter .= " AND manager_id =  '{$managerId}'   AND  employee_id <>  {$managerId} ";


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
        $pagination->setPath('employeespermissions');

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
        return view('employeespermissions.index', $this->data);
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

        // to edit only the permission that manager_approved = null
        $EmPermission = Employeespermissions::where('id', '=', $id)->where('manager_id', '=', \Auth::user()->id)->whereNull('manager_approved')->first();
        if ($EmPermission === NULL) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }




        // make limit to permissions to be 2 per month   // here 2 is PERMISSIONS_PER_MONTH as constant and can chnaged from setting by our HR
        $Permission = \DB::table('tb_permissions')->where('id', $id)->first();
        $Employee = \DB::table('tb_users')->where('id', $Permission->employee_id)->first();



/*
        //  $currentMonth = date("m");
        // to make permission from 21 prev month to 20 current month
        $currentMonth = date("n");
        if ($currentMonth == 1) {
            $prevMonth = 12;
        } else {
            $prevMonth = $currentMonth - 1;
        }

        if ($currentMonth == 12) {
            $nextMonth = 1;
        } else {
            $nextMonth = $currentMonth + 1;
        }


        // Formatting a number with leading zeros in PHP
        // https://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
        $prevMonthL = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);
        $nextMonthL = str_pad($nextMonth, 2, '0', STR_PAD_LEFT);



        $currentDay = date("d");
        if ($currentDay > 20) {  // current to next
            $start_date = date("Y-m-20");
            $end_date = date("Y-" . $nextMonthL . "-21");
        } else { // prev to current
            $start_date = date("Y-" . $prevMonthL . "-21");
            $end_date = date("Y-m-20");
        }

        $currentUserId = \Auth::user()->id;
        // $permissions = \DB::select(\DB::raw("SELECT COUNT(*) AS No_approved_month FROM tb_permissions WHERE  employee_id =  {$Permission->employee_id}  AND manager_approved = 1 and  MONTH(tb_permissions.date) =   {$currentMonth} "));
        $permissions = \DB::select(\DB::raw("SELECT COUNT(*) AS No_approved_month FROM tb_permissions WHERE  employee_id =  {$Permission->employee_id}  AND manager_approved = 1  AND  (date BETWEEN '{$start_date}' AND '{$end_date}')  "));


        if ($permissions && $permissions[0]->No_approved_month >= PERMISSIONS_PER_MONTH) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get($Employee->first_name . " " . $Employee->last_name . ' exceed his/her permissions credit per this month !'))->with('msgstatus', 'error');
        }



*/

        /////////////////////////////////////////////////////////
        /*

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


        $permissions = \DB::select(\DB::raw("SELECT COUNT(*) AS No_approved_month FROM tb_permissions WHERE  employee_id =  {$Permission->employee_id}  AND  (date BETWEEN '{$start_date}' AND '{$end_date}') "));

        $refusedPermissions = \DB::select(\DB::raw("SELECT COUNT(*) AS No_approved_month FROM tb_permissions  WHERE  employee_id =  {$Permission->employee_id}  AND  manager_approved  =  0   AND  (date BETWEEN '{$start_date}' AND '{$end_date}') "));



        // to handle case if there is refused permissions
        if ($permissions && ( $permissions[0]->No_approved_month -  $refusedPermissions[0]->No_approved_month )  >= PERMISSIONS_PER_MONTH) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get($Employee->first_name . " " . $Employee->last_name . ' exceed his/her permissions credit per this month !'))->with('msgstatus', 'error');
        }
  */

        ////////////////////////////////////////////////


        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_permissions');
        }


        $this->data['id'] = $id;
        return view('employeespermissions.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');


        $EmPermission = Employeespermissions::where('id', '=', $id)->where('manager_id', '=', \Auth::user()->id)->first();
        if ($EmPermission === NULL) {
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
        return view('employeespermissions.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_employeespermissions');


            // make limit to permissions to be 2 per month   // here 2 is PERMISSIONS_PER_MONTH as constant and can chnaged from setting by our HR
            $Permission = \DB::table('tb_permissions')->where('id', $request->input('id'))->first();
            $Employee = \DB::table('tb_users')->where('id', $Permission->employee_id)->first();




            $id = $this->model->updateVacation($data, $request->input('id'));  // to not update entry_by
            $Permission = \DB::table('tb_permissions')->where('id', $id)->first();
            // send notification to employee  if there is reason
            $user = User::find(\Auth::user()->id);



            if ($Permission->manager_approved == 0) { // manager not approved
                $subject = "Your permission is refused";
                if (strlen(trim($Permission->manager_reason)) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $Permission->manager_reason;
                }
            } elseif ($Permission->manager_approved == 1) { // if manager is approved then send notification to hr

                $subject = "Your permission is approved ";
                $hr_subject = "Permission for " . $Employee->first_name . " " . $Employee->last_name . " is approved by  " . $user->first_name . " " . $user->last_name;
                $hr_link = "permissions/show/" . $id;
                //  notification to hr
                // $HR = \DB::table('tb_users')->where('group_id', 3)->first();  // first hr in system
                $HRS = \DB::table('tb_users')->where('group_id', 3)->get();  // first hr in system
                foreach ($HRS as $HR) {
                    \SiteHelpers::addNotification(\Auth::user()->id, $HR->id, $hr_subject, $hr_link);
                    // send SMS
                    // $phone = $HR->phone_number;
                    // $this->send_sms($phone,$hr_subject, $hr_link);
                }
            }

            $link = 'mypermissions/show/' . $id;
            \SiteHelpers::addNotification(\Auth::user()->id, $Permission->employee_id, $subject, $link);  //  notification to employee under current manager
            // send SMS
               $phone = $Employee->phone_number;
               $this->send_sms($phone,$subject, $link);

            if (!is_null($request->input('apply'))) {
                $return = 'employeespermissions/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'employeespermissions?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('employeespermissions/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('employeespermissions')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('employeespermissions')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
