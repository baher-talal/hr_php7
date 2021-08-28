<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang;

class PermissionsController extends Controller
{

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'permissions';
    static $per_page = '10';

    public function __construct()
    {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Permissions();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'permissions',
            'return' => self::returnUrl()
        );
    }

    public function getIndex(Request $request)
    {

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
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
        );
        // Get Query
        $results = $this->model->getRows($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('permissions');

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
        return view('permissions.index', $this->data);
    }

    function getUpdate(Request $request, $id = null)
    {

        if ($id == '') {
            if ($this->access['is_add'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        if ($id != '') {
            if ($this->access['is_edit'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        // make limit to permissions to be 2 per month   // here 2 is PERMISSIONS_PER_MONTH as constant and can chnaged from setting by our HR
        $Permission = \DB::table('tb_permissions')->where('id', $id)->first();
        $Employee = \DB::table('tb_users')->where('id', $Permission->employee_id)->first();

        // $currentMonth  = date("m") ;
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

        // get hours of all permission of user & manger approve
        $permissionsHours = \DB::select(\DB::raw("SELECT SUM(hours) AS All_permission_Hours FROM tb_permissions WHERE  employee_id = {$Permission->employee_id}   AND  manager_approved  =  1 AND  (date BETWEEN '{$start_date}' AND '{$end_date}') "));

        // to handle case if exceed  permissions credit
        if ($permissionsHours && $permissionsHours[0]->All_permission_Hours >= PERMISSIONS_Hours_PER_MONTH) {
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get($Employee->first_name . " " . $Employee->last_name . ' exceed his/her permissions credit per this month !'))->with('msgstatus', 'error');
        }


        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_permissions');
        }


        $this->data['id'] = $id;
        return view('permissions.form', $this->data);
    }

    public function getShow($id = null)
    {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_permissions');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('permissions.view', $this->data);
    }

    function postSave(Request $request)
    {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_permissions');


            // make limit to permissions to be 2 per month   // here 2 is PERMISSIONS_PER_MONTH as constant and can chnaged from setting by our HR
            $Permission = \DB::table('tb_permissions')->where('id', $request->input('id'))->first();
            $Employee = \DB::table('tb_users')->where('id', $Permission->employee_id)->first();
            // $currentMonth  = date("m") ;
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

            // get hours of all permission of user & manger approve
            $permissionsHours = \DB::select(\DB::raw("SELECT SUM(hours) AS All_permission_Hours FROM tb_permissions WHERE  employee_id = {$Permission->employee_id}   AND  manager_approved  =  1 AND  (date BETWEEN '{$start_date}' AND '{$end_date}') "));

            // to handle case if exceed  permissions credit
            if ($permissionsHours && $permissionsHours[0]->All_permission_Hours >= PERMISSIONS_Hours_PER_MONTH) {
                return Redirect::to('dashboard')
                    ->with('messagetext', \Lang::get($Employee->first_name . " " . $Employee->last_name . ' exceed his/her permissions credit per this month !'))->with('msgstatus', 'error');
            }

            $id = $this->model->updateVacation($data, $request->input('id'));   // to not update entry_by
            // send notification to employee  if there is reason
            $user = User::find(\Auth::user()->id);
            $permission = \DB::table('tb_permissions')->where('id', $id)->first();
            $Employee = \DB::table('tb_users')->where('id', $permission->employee_id)->first();

            if ($permission->manager_approved == 0) { // hr not approved
                $subject = "Your permission request is refused by your HR ";
                if (strlen(trim($permission->manager_reason)) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $permission->manager_reason;
                }
            } elseif ($permission->manager_approved == 1) { // if hr is approved then send notification to hr
                $subject = "Your permission is approved by your HR";
            }
            $link = 'mypermissions/show/' . $id;
            \SiteHelpers::addNotification(\Auth::user()->id, $permission->employee_id, $subject, $link);  //  notification to employee under current manager

            $Employee = User::where('id', $permission->employee_id)->first();

            // send SMS
            $phone = $Employee->phone_number;
            $this->send_sms($phone, $subject, $link);


            if (!is_null($request->input('apply'))) {
                $return = 'permissions/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'permissions?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('permissions/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                ->withErrors($validator)->withInput();
        }
    }

    public function postDelete(Request $request)
    {

        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('permissions')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('permissions')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
