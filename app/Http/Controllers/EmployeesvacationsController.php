<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employeesvacations;
use App\User;
use App\Models\Deductions;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class EmployeesvacationsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'employeesvacations';
    static $per_page = '10';

    public function __construct() {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Employeesvacations();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);

            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'employeesvacations',
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
        $pagination->setPath('employeesvacations');

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
        return view('employeesvacations.index', $this->data);
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
// dd(\Auth::user()->id);
        $EmVacation = Employeesvacations::where('id', '=', $id)->where('manager_id', '=', \Auth::user()->id)->whereNull('manager_approved')->first();
        // dd($EmVacation);
        if ($EmVacation === NULL) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }


        $row = $this->model->find($id);

        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_vacations');
        }


        $this->data['id'] = $id;
        return view('employeesvacations.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_vacations');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('employeesvacations.view', $this->data);
    }

    function postSave(Request $request) {

        //  $rules = $this->validateForm();
        $rules = array(
            'manager_approved' => 'required',
                // 'manager_reason' => 'required'
        );


        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            if ($request->input("manager_approved") != "") {
                $data["manager_approved"] = $request->input("manager_approved");
            }

            $data["manager_reason"] = $request->input("manager_reason");


            // send notification to employee  if there is reason
            $user = User::find(\Auth::user()->id);
            $vacation = \DB::table('tb_vacations')->where('id', $request->input('id'))->first();
            $Employee = User::where('id', $vacation->employee_id)->first();

            // we will remove this check
            /*
              if($Employee->annual_credit == 0  ){
              return Redirect::to('dashboard')
              ->with('messagetext', \Lang::get($Employee->first_name . ' ' . $Employee->last_name.' has finished all his vacations !'))->with('msgstatus','error');
              }elseif ($Employee->annual_credit - $vacation->peroid <  0 ) {
              return Redirect::to('dashboard')
              ->with('messagetext', \Lang::get($Employee->first_name . ' ' . $Employee->last_name.' request vacations days greater than his credit !'))->with('msgstatus','error');
              }
             */

            $id = $this->model->updateVacation($data, $request->input('id'));

            if ($data["manager_approved"] == 0) { // manager not approved
                $subject = "Your vacation is refused";
                if (strlen(trim($data["manager_reason"])) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $data["manager_reason"];
                }
            } elseif ($data["manager_approved"] == 1) { // if manager is approve then send notification to hr
                $subject = "Your vacation is approved ";
                $hr_subject = "Vacation for " . $Employee->first_name . " " . $Employee->last_name . " is approved by  " . $user->first_name . " " . $user->last_name;
                $hr_link = "vacations/show/" . $id;
                //  notification to hr
                // $HR = \DB::table('tb_users')->where('group_id', 3)->first();  // first hr in system
                $HRS = \DB::table('tb_users')->where('group_id', 3)->get();  // first hr in system
                foreach ($HRS as $HR) {
                    \SiteHelpers::addNotification(\Auth::user()->id, $HR->id, $hr_subject, $hr_link);
                    // send SMS
                    // $phone = $HR->phone_number;
                    // $this->send_sms($phone,$hr_subject, $hr_link);
                }

                //  notification to ceo if employee is in managers department
                if ($vacation->department_id == MANAGER_DEPARTMENT_ID) {

                      $department = \DB::table('tb_departments')->where('id', MANAGER_DEPARTMENT_ID)->first();
                      if($department){
                       $manager_user_id =    $department->manager_id ;
                      }

                      $manager_user = \DB::table('tb_users')->where('id', $manager_user_id)->first();

                    \SiteHelpers::addNotification(\Auth::user()->id, $manager_user->id, $hr_subject, $hr_link);

                // send SMS
                    $phone = $manager_user->phone_number;
                    $this->send_sms($phone,$hr_subject, $hr_link);

                }



                // if there is credit in prev year
                // update annual_credit for that employee
                if ($Employee->annual_credit == 0 && $vacation->type_id == 4) {  // 4 = unpaid vacation
                    // add deducation with this period
                    $date = date("Y-m-d");
                    $Deductions = new Deductions();
                    $Deductions->user_id = $Employee->id;
                    $Deductions->deducation_period = $vacation->peroid;
                    $Deductions->reason_id = 2;  // 2= unpaid vacation reason
                    $Deductions->date = date("Y-m-d");
                    $Deductions->month = date("n");
                    $Deductions->year = date("Y");
                    $Deductions->vacation_id = $vacation->id;
                    $Deductions->entry_by = \Auth::user()->id;
                    $Deductions->created_at = date("Y-m-d H:i:s");
                    $Deductions->updated_at = date("Y-m-d H:i:s");
                    $Deductions->save();
                } elseif ($Employee->annual_credit == 0 && $vacation->type_id != 4) {
                    return Redirect::to('dashboard')
                                    ->with('messagetext', \Lang::get($Employee->first_name . ' ' . $Employee->last_name . ' has finished all his vacations !'))->with('msgstatus', 'error');
                } elseif ($Employee->annual_credit - $vacation->peroid < 0) {
                    // add deducation with this period difference
                    $date = date("Y-m-d");
                    $Deductions = new Deductions();
                    $Deductions->user_id = $Employee->id;
                    $Deductions->deducation_period = $vacation->peroid - $Employee->annual_credit;
                    $Deductions->reason_id = 2;  // 2= unpaid vacation reason
                    $Deductions->date = date("Y-m-d");
                    $Deductions->month = date("n");
                    $Deductions->year = date("Y");
                    $Deductions->vacation_id = $vacation->id;
                    $Deductions->entry_by = \Auth::user()->id;
                    $Deductions->created_at = date("Y-m-d H:i:s");
                    $Deductions->updated_at = date("Y-m-d H:i:s");
                    $Deductions->save();

                    $Employee->annual_credit = 0;
                    $Employee->save();
                } else {  // employee has enough credit
                    $Employee->annual_credit -= $vacation->peroid;
                    $Employee->save();
                }
            }

            $link = 'myvacations/show/' . $id;

            \SiteHelpers::addNotification(\Auth::user()->id, $vacation->employee_id, $subject, $link);  //  notification to employee under current manager

            // send SMS
                $phone = $Employee->phone_number;
                $this->send_sms($phone,$subject, $link);


            return Redirect::to('employeesvacations')->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {
            return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }

        /*
          $validator = Validator::make($request->all(), $rules);
          // print_r($validator) ;die;
          if ($validator->passes()) {

          $data = $this->validatePost('tb_employeesvacations');

          $id = $this->model->insertRow2($data, $request->input('id'));

          if (!is_null($request->input('apply'))) {
          $return = 'employeesvacations/update/' . $id . '?return=' . self::returnUrl();
          } else {
          $return = 'employeesvacations?return=' . self::returnUrl();
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

         */
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
            return Redirect::to('employeesvacations')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('employeesvacations')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    public function vacationapproved($id) {

        $vacationId = $id;
        if ($vacationId && $vacationId != "") {
            $userId = \Auth::user()->id;

            $user = User::find(\Auth::user()->id);

            $vacation = Employeesvacations::where('id', '=', $vacationId)->where('manager_id', '=', $userId)->first();
            if ($vacation) {
                $Manager = User::find($vacation->manager_id);
                $vacation->manager_approved = 1;
                $vacation->save();
                // send notificaton to employee that his manager approved to his vacation
                $subject = "Your vacation is approved by your manager " . $Manager->first_name . ' ' . $Manager->last_name;
                $link = 'myvacations/show/' . $vacation->id;
                \SiteHelpers::addNotification($userId, $vacation->employee_id, $subject, $link);

                return Redirect::back()
                                ->with('messagetext', \Lang::get('The vacation is approved'))->with('msgstatus', 'success');
            } else {
                return Redirect::to('employeesvacations')
                                ->with('messagetext', 'Access Denied')->with('msgstatus', 'error');
            }
        }
    }

}
