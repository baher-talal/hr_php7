<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Acquisitions;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang;
use DB;

class AcquisitionsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'acquisitions';
    static $per_page = '10';

    public function __construct() {

        date_default_timezone_set("Africa/Cairo");
        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Acquisitions();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
	   });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'acquisitions',
            'return' => self::returnUrl()
        );
    }

    public function getIndex(Request $request) {
        if (\Auth::user()->group_id == 5 || \Auth::user()->group_id == 6) {
            if (!CheckAcquisitionAccess()) {
                return Redirect::to('dashboard')
                                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            }
        }
        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query
        // Filter Search for query
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
        if (\Auth::user()->group_id == 5 || \Auth::user()->group_id == 6) {
            if (CheckAcquisitionAccess()) {
                $filter .= " AND id IN ( select acquisition_id from acquisition_approves where user_id = " . \Auth::user()->id . " )";
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
        $pagination->setPath('acquisitions');

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
        return view('acquisitions.index', $this->data);
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
            $this->data['acquisition_contries'] = DB::table('acquisition_region')->where('acquisition_id', $row->id)->pluck('country_id');

            foreach ($this->data['acquisition_contries'] as $k => $v) {
                $aquisition_operator = DB::table('acquisition_region')->where('acquisition_id', $row->id)->where('country_id', $v)->pluck('operators_ids');
                $this->data['acquisition_operator'][$k] = explode(',', $aquisition_operator[0]); // here K start from 0   and the values are acqusition operators list
                $this->data['old_operators'][$v] = \App\Models\operator::where('country_id', $v)->get();  // here V is country_id
            }

            $this->data['brand_manager_info'] = \App\User::where('id', $row['brand_manager_id'])->first();
        } else {
            $this->data['row'] = $this->model->getColumnTable('acquisitions');
        }
        $this->data['countries'] = \App\Models\countries::all();
        $this->data['operators'] = \App\Models\operator::all();

        $this->data['id'] = $id;
        return view('acquisitions.form', $this->data);
    }

    public function getShow($id = null) {

        if (\Auth::user()->group_id == 5 || \Auth::user()->group_id == 6) {
            if (!CheckAcquisitionAccess()) {
                return Redirect::to('dashboard')
                                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
            }
        }
        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('acquisitions');
        }
        $this->data['is_ceo'] = $this->data['approve_name'] = $this->data['approveStatus'] = false;
        if (\Auth::user()->group_id == 5 || \Auth::user()->group_id == 6) { // manager or employee
            $approveStatus = \App\Models\acquisitionapproves::where('user_id', \Auth::user()->id)->where('acquisition_id', $id)->first();
            $approveStatus = $approveStatus->approve;
            if ($approveStatus == 0) {
                $this->data['approveStatus'] = true;
                $department_name = checkUserApproveName();
                if ($department_name == 'ceo') {  // can't return ceo .. please check this ??
                    $this->data['is_ceo'] = true;
                } else {
                    $this->data['approve_name'] = $department_name . '_approve';
                }
            }
        }

        $this->data['approveHistory'] = \App\Models\acquisitionapproves::where('acquisition_id', $id)->get();
        $this->data['id'] = $id;
        $this->data['access'] = $this->access;

        //COUNTRY AND OPERATOR
        //COUNTRY , OPERATOR AND SERVICESS
        $this->data['countrys'] = [];
        $this->data['all_operators'] = [];
        $acquisition_ops = \DB::table('acquisition_region')->where('acquisition_id', $id)->get();
        foreach ($acquisition_ops as $acquisition_op) {
          $operator_ids = explode(',',$acquisition_op->operators_ids);
          $country= \App\Models\Countries::where('id', $acquisition_op->country_id)->first();
          $operators = \App\Models\Operator::whereIn('id', $operator_ids)->get();
          array_push($this->data['countrys'],$country);
          array_push($this->data['all_operators'],$operators);
        }
        return view('acquisitions.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_acquisitions');

            $id = $this->model->insertRow2($data, $request->input('id'));
            $row = \App\Models\acquisitions::find($id);
            $country_ids = [];
            if ($request->input('id') == '') { // create
                // region for acquisitions
                foreach ($request->all() as $k => $value) {
                    $checkInput = strpos($k, "countries_");
                    if ($checkInput === 0) {
                        $ops["country_id"] = $value;
                        $ops["acquisition_id"] = $id;
                        $key = substr($k, strpos($k, "_") + 1);
                        $opREQUEST = "operator_id_" . $key;
                        $op_arr = $request->$opREQUEST;
                        $ids = implode(',', $op_arr);
                        $ops["operators_ids"] = $ids;
                        DB::table('acquisition_region')->insert($ops);
                        array_push($country_ids, $value);
                    }
                }
            } else {
                $row->country()->detach();
                $row->approve()->detach();
                // region for acquisitions
                foreach ($request->all() as $k => $value) {
                    $checkInput = strpos($k, "countries_");
                    if ($checkInput === 0) { // this mean true
                        $ops["country_id"] = $value;
                        $ops["acquisition_id"] = $id;
                        $key = substr($k, strpos($k, "_") + 1);
                        $opREQUEST = "operator_id_" . $key;
                        $op_arr = $request->$opREQUEST;
                        $ids = implode(',', $op_arr);
                        $ops["operators_ids"] = $ids;
                        DB::table('acquisition_region')->insert($ops);
                        array_push($country_ids, $value);
                    }
                }
            }

            if ($id) {
                // send notifications

                $users = \App\User::whereIn('id', ApproveGroup())->orWhereIn('id', OperationApproveGroup($country_ids))->get();
                foreach ($users as $user) {
                    $phone = $user->phone_number;
                    $subject = 'New Acquisition Has Been Created ';
                    $link = 'acquisitions/show/' . $id;
                    $this->send_sms($phone, $subject, $link);

                    \SiteHelpers::addNotification(1, $user->id, $subject, $link);
                    $acq['acquisition_id'] = $id;
                    $acq['user_id'] = $user->id;
                    $acq['created_at'] = date("Y-m-d H:i:s");
                    $acq['updated_at'] = date("Y-m-d H:i:s");
                    \App\Models\acquisitionapproves::insert($acq);
                }
            }
            if (!is_null($request->input('apply'))) {
                $return = 'acquisitions/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'acquisitions?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('acquisitions/update/' . $request->input('id'))->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('acquisitions')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('acquisitions')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    public function getApprove($id, $approve_name) {

        $this->model->where('id', $id)->update(array($approve_name => 1));
        $row = $this->model->find($id);
        if ($row->operation_approve == 1 && $row->finance_approve == 1 && $row->legal_approve == 1 && $row->ceo_cancel == 0) {
            $this->model->where('id', $id)->update(array('final_approve' => 1));
        }
        return back();
    }

    public function getCancel($id) {

        $this->model->where('id', $id)->update(array('ceo_cancel' => 1, 'final_approve' => 0));
        return back();
    }

    public function getUserinfo(Request $request) {

        $info = \App\User::where('id', $request->id)->first();
        return Response(array('email' => $info->email, 'phone' => $info->phone_number));
    }

    public function getTeamapprove(Request $request) {

        $data['approve'] = $request->approve;
        $data['description'] = $request->description;
        $approve_name = $request->approve_name; // department that approve  ex :  finance_approve
        \App\Models\acquisitionapproves::where('acquisition_id', $request->acquisition_id)->where('user_id', \Auth::user()->id)->update($data);
        $row = $this->model->find($request->acquisition_id);
        if ($approve_name == 'finance_approve' || $approve_name == 'legal_approve') {
            // if value is approve
            if ($data['approve'] == 1) {
                $this->model->where('id', $request->acquisition_id)->update(array($approve_name => 1));
            }
            // if value is semi approve
            elseif ($data['approve'] == 3) {
                // go to creator
                $user = \App\User::find($row->entry_by);
                $phone = $user->phone_number;
                $subject = 'Acquisition Has SemiApprove ';
                $link = 'acquisitions/show/' . $request->acquisition_id;
                $this->send_sms($phone, $subject, $link);
                \SiteHelpers::addNotification(1, $user->id, $subject, $link);
            }
        } elseif ($approve_name == 'operation_team_approve') { // operation team approve case
            // check if there is one approve exists ( min approve )
            if ($row->operation_approve != 1) {
                // if value is approve
                if ($data['approve'] == 1) {
                    $this->model->where('id', $request->acquisition_id)->update(array('operation_approve' => 1));
                }
                // if value is semi approve
                elseif ($data['approve'] == 3) {
                    // go to creator
                    $user = \App\User::find($row->entry_by);
                    $phone = $user->phone_number;
                    $subject = 'Acquisition Has SemiApprove ';
                    $link = 'acquisitions/show/' . $request->acquisition_id;
                    $this->send_sms($phone, $subject, $link);
                    \SiteHelpers::addNotification(1, $user->id, $subject, $link);
                }
            }
        }
        $this->getFinalapprove($request->acquisition_id);
        return back();
    }

    public function getCreatorapprove(Request $request) {
        $data['notified_action'] = $request->notified_action;
        $data['notified_description'] = $request->notified_description;
        \App\Models\acquisitionapproves::where('acquisition_id', $request->acquisition_id)->where('id', $request->approve_id)->update($data);
        $row = $this->model->find($request->acquisition_id);
        $approve_row = \App\Models\acquisitionapproves::find($request->approve_id);
        if ($request->notified_action == 1) { // acquistion creator is approved
            $department = \App\Models\departments::where('manager_id', $approve_row->user_id)->whereIn('id', DeptIds())->first();
            if ($department) {
                $department_name = strtolower($department->title);
            } else {
                $department_name = "operation";
            }
            $approve_name = $department_name . "_approve";
            $this->model->where('id', $request->acquisition_id)->update(array($approve_name => 1));
            // notification (approve) to approve user
            $user = \App\User::find($approve_row->user_id);
            $phone = $user->phone_number;
            $subject = 'Acquisition Has Approved ';
            $link = 'acquisitions/show/' . $request->acquisition_id;
            $this->send_sms($phone, $subject, $link);
            \SiteHelpers::addNotification(1, $user->id, $subject, $link);
        } else {
            // notification (disapprove) to  approve user
            $user = \App\User::find($approve_row->user_id);
            $phone = $user->phone_number;
            $subject = 'Acquisition Has DisApproved ';
            $link = 'acquisitions/show/' . $request->acquisition_id;
            $this->send_sms($phone, $subject, $link);
            \SiteHelpers::addNotification(1, $user->id, $subject, $link);
        }
        $this->getFinalapprove($request->acquisition_id);
        return back();
    }

    public function getFinalapprove($id) {


        $row = $this->model->find($id);
        if ($row->operation_approve == 1 && $row->finance_approve == 1 && $row->legal_approve == 1 && $row->ceo_cancel == 0) {
            $this->model->where('id', $id)->update(array('final_approve' => 1));
        }
    }

}
