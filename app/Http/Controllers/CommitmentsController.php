<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commitments;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang    ;
use DateTime;

class CommitmentsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'commitments';
    static $per_page = '10';

    public function __construct() {
         date_default_timezone_set("Africa/Cairo");
        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Commitments();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
	   });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'commitments',
            'return' => self::returnUrl()
        );
    }

    public function getIndex(Request $request) {

        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query 
        // Filter Search for query		
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

        if ($request->contract_id) {
            $filter .= " AND contract_id ='{$request->contract_id}'";
        }
        if (\Auth::user()->group_id == 5) {
            $filter .= " AND entry_by ='" . \Auth::user()->id . "'";
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
        $pagination->setPath('commitments');

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
        return view('commitments.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_commitments');
        }
        $this->data['contract_id'] = $request->contract_id;

        $this->data['id'] = $id;
        return view('commitments.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_commitments');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        $this->data['chart'] = get_commitment_progress($id);
        return view('commitments.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_commitments');
            $id = $request->input('id');
//            if ($request->contract_id == "" && $request->project_id == "") {
//                  return Redirect::to('commitments/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
//                            ->withErrors("You Should Select Contract OR Project")->withInput(); 
//            }
            if ($request->contract_id == "") {
                $cdata['contract_id'] = null;
            } else {
                $cdata['contract_id'] = $data['contract_id'];
            }
            if ($request->project_id == "") {
                $cdata['project_id'] = null;
            } else {
                $cdata['project_id'] = $data['project_id'];
            }

            $cdata['id'] = $data['id'];
            foreach ($data['department_id'] as $k => $value) {
                $cdata['department_id'] = $value;
                $cdata['commitment'] = $data['commitment'][$k];
                $cdata['notes'] = $data['notes'][$k];
                $cdata['priority'] = $data['priority'][$k];
                $id = $this->model->insertRow2($cdata, $request->input('id'));

                $current_employee_id = \Session::get('uid');
                $to_employee = \App\Models\departments::Find($data['department_id'][$k])->manager_id;
                $subject = 'New commitment ' . $data['commitment'][$k];
                $link = 'mycommitments/show/' . $id;
                \SiteHelpers::addNotification($current_employee_id, $to_employee, $subject, $link);
                // send SMS TO employee
                $employee = \App\User::where('id', $to_employee)->first();
                $phone = $employee->phone_number;
                $this->send_sms($phone, $subject, $link);
                // add to commitment users               
                $cUser = new \App\Models\commitmentsescalation();
                $cUser->commitment_id = $id;
                $cUser->user_id = $to_employee;
                $cUser->save();
            }
            if (!is_null($request->input('apply'))) {
                $return = 'commitments/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'commitments?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('commitments/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('commitments')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('commitments')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    public function getCheckdelay() {
        // get all commitments
        $commitments = \App\Models\commitments::all();

        foreach ($commitments as $commitment) {            
            if ($commitment->approve == 0 ) {
                // get last record for this commit in table commitments_user
                $row = \App\Models\commitmentsescalation::where('commitment_id', $commitment->id)->get()->last(); 
               
                if ($row) {                   
                    $end = new DateTime();                    
                    $start = new DateTime($row->created_at);
                    $sub = $end->diff($start);   
                    if ($sub->format('%h') >= DELAY_TIME_IN_HOURS) {
                        // check if current user is manager
                        $is_manager = \App\Models\departments::where('manager_id',$row->user_id)->first();
                        if($is_manager){
                            $next_user = \App\User::where('department_id',$is_manager->id)->where('level',1)->first();
                        }
                        else{
                            $current_user = \App\User::find($row->user_id);
                            $level = ++$current_user->level;
                            $next_user = \App\User::where('department_id',$current_user->department_id)->where('level',$level)->first();
                        }                       
                        // if found user in next level do assign to him
                        if($next_user){
                            $cUser = new \App\Models\commitmentsescalation();
                            $cUser->commitment_id = $commitment->id;
                            $cUser->user_id = $next_user->id;
                            $cUser->save();
                        }
                    }
                }
            }
        }
    }

}
