<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mytasks;
use App\Models\Contracts;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class MytasksController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'mytasks';
    static $per_page = '10';

    public function __construct() {

        date_default_timezone_set("Africa/Cairo");
        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Mytasks();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'mytasks',
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

        // to add condition in index view for sximo
        $userId = \Auth::user()->id;
        $filter .= " AND assign_to_id =  '{$userId}' ";
        if ($request->contract) {
            $filter .= " AND commitment_id IN ( select id from tb_commitments where contract_id= '{$request->contract}') ";
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
        $pagination->setPath('mytasks');

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
        return view('mytasks.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_tasks');
        }


        $this->data['id'] = $id;
        return view('mytasks.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_tasks');
        }
        $cUser = \Session::get('uid');
        if ($cUser == $this->data['row']->assign_to_id) {
            if ($this->data['row']->status == 0)
                \App\Models\tasks::where('id', $id)->update(array('status' => '1'));
            \App\Models\tasks::where('id', $id)->update(array('seen' => '1'));
        }
        $this->data['id'] = $id;
        $this->data['history'] = get_task_history($id);
        $this->data['access'] = $this->access;
        return view('mytasks.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_mytasks');

            $id = $this->model->insertRow($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'mytasks/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'mytasks?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('mytasks/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('mytasks')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('mytasks')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    public function getPick($id) {
        date_default_timezone_set("Africa/Cairo");
        $workingTasks = \App\Models\tasks::where('assign_to_id', \Auth::user()->id)->where('status', 3)->count();
        if ($workingTasks > 0) {
            return back()->with('messagetext', \Lang::get('core.note_error') . '<br/> Another Task Not Finished')->with('msgstatus', 'error');
        }
        \App\Models\tasks::where('id', $id)->update(array('status' => 3, 'seen' => 1));
        $data['task_id'] = $id;
        $data['start_time'] = date("Y-m-d H:i:s");
        $this->model = new \App\Models\tasktime();
        $this->model->insertRow2($data, null);
        return back();
    }

    public function getPending($id) {
        date_default_timezone_set("Africa/Cairo");
        \App\Models\tasks::where('id', $id)->update(array('status' => 2));
        $task_history = \App\Models\tasktime::where('task_id', $id)->latest()->first();
        $data['end_time'] = date("Y-m-d H:i:s");


        //  var_dump($data) ; die;

        $this->model = new \App\Models\tasktime();
        $this->model->insertRow2($data, $task_history->id);
        // update working hours of task
        $time = get_diff_taskhistory($task_history->id);
        $task = \App\Models\tasks::find($id);
        $oldtime = str_replace('.', ':', $task->working_hours);
        $h = "h";
        if (strpos($oldtime, '0:') !== false) {
            $h = "H";
        }
        $working_hours = date("$h.i", strtotime($oldtime . " +" . $time['hour'] . " hours  +" . $time['min'] . " minutes"));
        $task->working_hours = $working_hours;
        $task->save();

        //update working hours of commitment
        $commitment = \App\Models\commitments::find($task->commitment_id);
        $oldtime = str_replace('.', ':', $commitment->working_hours);
        $h = "h";
        if (strpos($oldtime, '0:') !== false) {
            $h = "H";
        }
        $working_hours = date("$h.i", strtotime($oldtime . " +" . $time['hour'] . " hours  +" . $time['min'] . " minutes"));
        $commitment->working_hours = $working_hours;
        $commitment->save();
        //update working hours of project
        $contract = \App\Models\contracts::find($commitment->contract_id);
        $oldtime = str_replace('.', ':', $contract->working_hours);
        $h = "h";
        if (strpos($oldtime, '0:') !== false) {
            $h = "H";
        }
        $working_hours = date("$h.i", strtotime($oldtime . " +" . $time['hour'] . " hours  +" . $time['min'] . " minutes"));
        $contract->working_hours = $working_hours;
        $contract->save();
        return back();
    }

    public function getFinished($id) {
        date_default_timezone_set("Africa/Cairo");
        \App\Models\tasks::where('id', $id)->update(array('status' => 4));
        $task_history = \App\Models\tasktime::where('task_id', $id)->latest()->first();
        $data['end_time'] = date("Y-m-d H:i:s");
        $this->model = new \App\Models\tasktime();
        $this->model->insertRow2($data, $task_history->id);
        // update working hours of task
        $time = get_diff_taskhistory($task_history->id);
        $task = \App\Models\tasks::find($id);
        $oldtime = str_replace('.', ':', $task->working_hours);
        $h = "h";
        if (strpos($oldtime, '0:') !== false) {
            $h = "H";
        }
        $working_hours = date("$h.i", strtotime($oldtime . " +" . $time['hour'] . " hours  +" . $time['min'] . " minutes"));
        $task->working_hours = $working_hours;
        $task->save();

        //update working hours of commitment
        $commitment = \App\Models\commitments::find($task->commitment_id);
        $oldtime = str_replace('.', ':', $commitment->working_hours);
        $h = "h";
        if (strpos($oldtime, '0:') !== false) {
            $h = "H";
        }
        $working_hours = date("$h.i", strtotime($oldtime . " +" . $time['hour'] . " hours  +" . $time['min'] . " minutes"));
        $commitment->working_hours = $working_hours;
        $commitment->save();
        //update working hours of project
        $contract = \App\Models\contracts::find($commitment->contract_id);
        $oldtime = str_replace('.', ':', $contract->working_hours);
        $h = "h";
        if (strpos($oldtime, '0:') !== false) {
            $h = "H";
        }
        $working_hours = date("$h.i", strtotime($oldtime . " +" . $time['hour'] . " hours  +" . $time['min'] . " minutes"));
        $contract->working_hours = $working_hours;
        $contract->save();

        // check if all tasks finished
        $commitment_progress = get_commitment_progress($task->commitment_id);
        $alltasks = $commitment_progress['alltasks'];
        $completedtasks = $commitment_progress['completedtasks'];
        if ($alltasks == $completedtasks) {
            // send SMS TO employee
           // $to_employee = \App\Models\departments::Find($commitment->department_id)->manager_id;
            $employee = \App\User::where('id',$contract->brand_manager_id)->first();
            $phone = $employee->phone_number;
            $subject = 'All Tasks Finished In Commitment ' . $commitment->commitment;
            $link = 'mycommitments/show/' . $commitment->id;
            $this->send_sms($phone, $subject, $link);
        }
        //check if all tasks in all commitment in the contract finished
        $contract_progress = get_contract_progress($contract->id);
        $allovertasks = $contract_progress['alltasks'];
        $completedovertasks = $contract_progress['completedtasks'];
        if ($allovertasks == $completedovertasks) {
            // send SMS TO task_management
            $employee = \App\User::where('group_id', 10)->first();
            $phone = $employee->phone_number;
            $subject = 'All Tasks Finished In Project ' . $contract->title;
            $link = 'contracts/show/' . $contract->id;
            $this->send_sms($phone, $subject, $link);
        }
        return back();
    }

    public function getProjects(Request $request) {
        $Cmodel = new Contracts();

        $this->info = $Cmodel->makeInfo('contracts');

        $this->access = $Cmodel->validAccess($this->info['id']);

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'contracts',
            'return' => self::returnUrl()
        );
        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query
        // Filter Search for query
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
         $userId = \Auth::user()->id;
        $filter .= " AND id IN (select contract_id from tb_commitments where tb_commitments.id IN (select commitment_id from tb_tasks where assign_to_id= '{$userId}'))";

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
        $results = $Cmodel->getRows($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('contracts');

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
        return view('mytasks.projects', $this->data);
    }

}
