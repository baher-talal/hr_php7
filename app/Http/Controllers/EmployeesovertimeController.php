<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employeesovertime;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class EmployeesovertimeController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'employeesovertime';
    static $per_page = '10';

    public function __construct() {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Employeesovertime();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'employeesovertime',
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
        $pagination->setPath('employeesovertime');

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
        return view('employeesovertime.index', $this->data);
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


         // to edit only the overtime that manager_approved = null
          $EmOvertime =   Employeesovertime::where('id','=',$id)->where('manager_id','=',\Auth::user()->id )->whereNull('manager_approved')->first() ;
            if( $EmOvertime === NULL){
                  return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
              }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_overtimes');
        }


        $this->data['id'] = $id;
        return view('employeesovertime.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $EmOvertime = Employeesovertime::where('id', '=', $id)->where('manager_id', '=', \Auth::user()->id)->first();
        if ($EmOvertime === NULL) {
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
        return view('employeesovertime.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_employeesovertime');

            $id = $this->model->updateVacation($data, $request->input('id'));   // to not update entry_by
                // send notification to employee  if there is reason
            $user = User::find(\Auth::user()->id);
            $Overtime = \DB::table('tb_overtimes')->where('id', $id)->first();
            $Employee = \DB::table('tb_users')->where('id', $Overtime->employee_id)->first();

            if ($Overtime->manager_approved  == 0) { // manager not approved
                $subject = "Your overtime is refused";
                if (strlen(trim($Overtime->manager_reason)) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $Overtime->manager_reason;
                }
            }elseif ($Overtime->manager_approved  == 1) { // if manager is approved then send notification to hr
                $subject = "Your overtime is approved ";
                $hr_subject = "Overtime for " . $Employee->first_name . " " . $Employee->last_name . " is approved by his manager " . $user->first_name . " " . $user->last_name;
                $hr_link = "overtimes/show/" . $id;
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
            $link = 'myovertime/show/' . $id;
            \SiteHelpers::addNotification(\Auth::user()->id, $Overtime->employee_id, $subject, $link);  //  notification to employee under current manager

            // send SMS
               $phone = $Employee->phone_number;
               $this->send_sms($phone,$subject, $link);


            if (!is_null($request->input('apply'))) {
                $return = 'employeesovertime/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'employeesovertime?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('employeesovertime/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('employeesovertime')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('employeesovertime')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
