<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class TasksController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'tasks';
    static $per_page = '10';

    public function __construct() {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Tasks();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'tasks',
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

        if ($request->commitment_id) {

            $filter .= " AND commitment_id ='{$request->commitment_id}'";
        } elseif ($request->contract_id && isset($request->status)) {

            if ($request->status == 'completed') {
                $filter .= " AND commitment_id IN ( select id from tb_commitments where contract_id = '{$request->contract_id}') AND status = 4";
            } elseif ($request->status == 'notcompleted') {
                $filter .= " AND commitment_id IN ( select id from tb_commitments where contract_id = '{$request->contract_id}') AND status != 4";
            } elseif ($request->status === "0") {
                $filter .= " AND commitment_id IN ( select id from tb_commitments where contract_id = '{$request->contract_id}') AND status = '{$request->status}'";
            }
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
        $pagination->setPath('tasks');

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
        return view('tasks.index', $this->data);
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
        $this->data['commitment_id'] = $request->commitment_id;
        if ($request->commitment_id) {
            $department_id = \App\Models\commitments::Find($request->commitment_id)->department_id;
            $this->data['users'] = \App\User::where('department_id', $department_id)->where('id', '!=', \Session::get('uid'))->get();
        } elseif ($row) {
            $department_id = \App\User::Find($row->assign_to_id)->department_id;
            $this->data['users'] = \App\User::where('department_id', $department_id)->where('id', '!=', \Session::get('uid'))->get();
        }
        $time_opt = [];
        for ($i = 0; $i < 12; $i++) {
            array_push($time_opt, $i . '.15');
            array_push($time_opt, $i . '.30');
            array_push($time_opt, $i . '.45');
            array_push($time_opt, $i + 1 . '.00');
        }
        $this->data['time_opt'] = $time_opt;
        return view('tasks.form', $this->data);
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
        $this->data['history'] = get_task_history($id);
        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('tasks.view', $this->data);
    }

    function postSave(Request $request) {

        $data = $request->all();
        if ($request->commitment_id)
            $cdata['commitment_id'] = $data['commitment_id'];
        $cdata['id'] = $data['id'];
        foreach ($data['assign_to_id'] as $k => $value) {
            $cdata['assign_to_id'] = $value;
            foreach ($data["taskUser_$k"] as $t => $task) {
                $cdata['task'] = $task;
                $cdata['time'] = $data["tasktimeUser_$k"][$t];
                $id = $this->model->insertRow2($cdata, $request->input('id'));
                //send notifaction
                $current_employee_id = \Session::get('uid');
                $to_employee = $value;
                $subject = 'New Task ' . $task;
                $link = 'mytasks/show/' . $id;
                \SiteHelpers::addNotification($current_employee_id, $to_employee, $subject, $link);

                // Insert logs into database
                if ($request->input('id') == '') {
                    \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
                } else {
                    \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
                }
            }
        }
        if (!is_null($request->input('apply'))) {
            $return = 'tasks/update/' . $id . '?return=' . self::returnUrl();
        } else {
            $return = 'tasks?return=' . self::returnUrl();
        }


        return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
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
            return Redirect::to('tasks')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('tasks')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
