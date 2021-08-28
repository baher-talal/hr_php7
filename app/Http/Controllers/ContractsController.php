<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contracts;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang;
use Illuminate\Support\Facades\DB;
use PDF;

class ContractsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'contracts';
    static $per_page = '10';

    public function __construct() {
        date_default_timezone_set("Africa/Cairo");
        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Contracts();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
	   });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'contracts',
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
        $s = "";
        if ($request->status) {
            if ($request->status == "info") {
                $filter .= " AND TIMESTAMPDIFF(MONTH,CURDATE(),end_date)= " . ContractMonthCheck . " OR (id IN (select contract_id from tb_contracts_renews where contract_id = tb_contracts.id AND  TIMESTAMPDIFF(MONTH,CURDATE(),tb_contracts_renews.end_date)= " . ContractMonthCheck . "))";
                $s .= "info";
            } elseif ($request->status == "warning") {
                $filter .= " AND (TIMESTAMPDIFF(MONTH,CURDATE(),end_date)<= 1 AND TIMESTAMPDIFF(MONTH,CURDATE(),end_date)>= 0 AND id NOT IN (select contract_id from tb_contracts_renews where contract_id = tb_contracts.id)) OR (id IN (select contract_id from tb_contracts_renews where contract_id = tb_contracts.id AND  TIMESTAMPDIFF(MONTH,CURDATE(),tb_contracts_renews.end_date)<= 1 AND  TIMESTAMPDIFF(MONTH,CURDATE(),tb_contracts_renews.end_date) >= 0))";
                $s .= "warning";
            } elseif ($request->status == "danger") {
                $filter .= " AND (TIMESTAMPDIFF(MONTH,CURDATE(),end_date)<= 0 AND id NOT IN (select contract_id from tb_contracts_renews where contract_id = tb_contracts.id)) OR (id IN (select contract_id from tb_contracts_renews where contract_id = tb_contracts.id AND  TIMESTAMPDIFF(MONTH,CURDATE(),tb_contracts_renews.end_date)<= 0))";
                $s .= "danger";
            } elseif ($request->status == "success") {
                $filter .= " AND TIMESTAMPDIFF(MONTH,CURDATE(),end_date)> " . ContractMonthCheck . "  OR (id IN (select contract_id from tb_contracts_renews where contract_id = tb_contracts.id AND  TIMESTAMPDIFF(MONTH,CURDATE(),tb_contracts_renews.end_date)> " . ContractMonthCheck . "))";
                $s .= "success";
            }
        }

//        dd(check_contract_status(45));
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
        $pagination->setPath('contracts')->appends('status', $s);

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
        return view('contracts.index', $this->data);
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
            $this->data['contract_contries'] = DB::table('contracts_operator')->where('contracts_id', $row->id)->pluck('country_id');
            foreach ($this->data['contract_contries'] as $k => $v) {
                $contract_operator = DB::table('contracts_operator')->where('contracts_id', $row->id)->where('country_id', $v)->pluck('operator_ids');
                $this->data['contract_operator'][$k] = explode(',', $contract_operator[0]);
                $this->data['old_contract_operators'][$v] = \App\Models\operator::where('country_id', $v)->get();
            }
            $this->data['contract_service'] = DB::table('contracts_service')->where('contracts_id', $row->id)->pluck('service_id');
            $this->data['contract_attachments'] = DB::table('tb_contracts_attachments')->where('contract_id', $row->id)->get();
            $this->data['items'] = DB::table('contract_items')->where('contract_id', $row->id)->get();
            $this->data['departments'] = \App\Models\departments::all();
        } else {
            $this->data['contract_attachments'] = $this->data['contract_operator'] = $this->data['contract_contries'] = $this->data['contract_service'] = $this->data['contract_except'] = null;
            $this->data['row'] = $this->model->getColumnTable('tb_contracts');
        }

        $this->data['attachment_types'] = \App\Models\attachmenttypes::all();
        $this->data['countries'] = \App\Models\countries::all();
        $this->data['operators'] = \App\Models\operator::all();

        $this->data['operators_except'] = \App\Models\operator::where('name', '!=', 'All')->get();
        $this->data['services'] = \App\Models\service::all();
        // dd($this->data['services'][0]->id);
        $this->data['id'] = $id;
        $this->data['acquisition_id'] = $request->acquisition_id;

        // if there is acquisition
        if ($request->acquisition_id) {
            $acquisition = \App\Models\acquisitions::find($request->acquisition_id);
            $this->data['acquisition_brand'] = $acquisition->brand_manager_id;
            $this->data['acquisitions_contries'] = DB::table('acquisition_region')->where('acquisition_id', $acquisition->id)->pluck('country_id');
            foreach ($this->data['acquisitions_contries'] as $k => $v) {
                $acquisition_operator = DB::table('acquisition_region')->where('acquisition_id', $acquisition->id)->where('country_id', $v)->pluck('operators_ids');
                $this->data['acquisition_operator'][$k] = explode(',', $acquisition_operator[0]);
                $this->data['old_operators'][$v] = \App\Models\operator::where('country_id', $v)->get();
            }
            $this->data['templates'] = \App\Models\template::where('content_type',$acquisition->content_type)->get();
        }
        else{
            $this->data['templates'] = \App\Models\template::all();
        }

        return view('contracts.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_contracts');
        }
        $this->data['is_ceo'] = $this->data['approve_name'] = $this->data['approveStatus'] = false;
        $approveStatus = \App\Models\contractapproves::where('user_id', \Auth::user()->id)->where('contract_id', $id)->first();
        if ($approveStatus) {
            $approveStatus = $approveStatus->approve;
            if ($approveStatus == 0) { // he not approve yet So open approve form
                $this->data['approveStatus'] = true;
                $department_name = checkUserApproveName();
                if ($department_name == 'ceo') {
                    $this->data['is_ceo'] = true;
                } else {
                    $this->data['approve_name'] = $department_name . '_approve';
                }
            }
        }
        $this->data['approveHistory'] = \App\Models\contractapproves::where('contract_id',$id)->get();
        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        $this->data['chart'] = get_contract_progress($id);
        $this->data['commitments'] = \App\Models\commitments::where('contract_id', $id)->get();

        //COUNTRY , OPERATOR AND SERVICESS
        $this->data['countrys'] = [];
        $this->data['all_operators'] = [];
        $contract_ops = \DB::table('contracts_operator')->where('contracts_id', $id)->get();
        foreach ($contract_ops as $contract_op) {
          $operator_ids = explode(',',$contract_op->operator_ids);
          $country= \App\Models\Countries::where('id', $contract_op->country_id)->first();
          $operators = \App\Models\Operator::whereIn('id', $operator_ids)->get();
          array_push($this->data['countrys'],$country);
          array_push($this->data['all_operators'],$operators);
        }
        $service_ids = \DB::table('contracts_service')->where('contracts_id', $id)->pluck('service_id');
        $this->data['services'] = \DB::table('tb_services')->whereIn('id', $service_ids)->get();
        //return [$this->data['countrys'],$this->data['all_operators']];
        return view('contracts.view', $this->data);
    }

    function postSave(Request $request) {
      // $x  = [];
      // foreach ($request->item as $k => $item) {
      //   foreach ($request->dep_id[$k] as $key => $value) {
      //   array_push($x,$request->dep_id[$k][$key]);
      //   }
      // }
      //   return $x;
        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_contracts');
            if ($request->brand_manager_id == "") {
                $data['brand_manager_id'] = null;
            }
            if ($request->acqisition_id == "") {
                $data['acqisition_id'] = null;
            }
            if ($request->template_id == "") {
                $data['template_id'] = null;
            }

            $id = $this->model->insertRow2($data, $request->input('id'));
            $row = \App\Models\contracts::find($id);
            $country_ids = [];

            if ($request->input('id') == '') { // create
                // region for contract
                foreach ($request->all() as $k => $value) {
                    $checkInput = strpos($k, "countries_");
                    if ($checkInput === 0) {
                        $ops["country_id"] = $value;
                        $ops["contracts_id"] = $id;
                        $key = substr($k, strpos($k, "_") + 1);
                        $opREQUEST = "operator_id_" . $key;
                        $op_arr = $request->$opREQUEST;
                        $ids = implode(',', $op_arr);
                        $ops["operator_ids"] = $ids;
                        DB::table('contracts_operator')->insert($ops);
                        array_push($country_ids, $value);
                    }
                }
                $row->service()->attach($request->service_id);
                if ($data['contract_type'] != 2) {
                    // add items
                    //return $request->dep_id;
                    foreach ($request->item as $k => $item) {
                      //return isset($request->dep_id[2]);
                        $items["department_id"] = isset($request->dep_id[$k])?implode(',',$request->dep_id[$k]): 'no department';
                        $items["item"] = $item;
                        $items["contract_id"] = $id;
                        if (!isset($request->dep_id[$k]))
                            unset($items["department_id"]);
                        DB::table('contract_items')->insert($items);

                    }
                }
            } else {

                $row->country()->detach();
                $row->approve()->detach();
                // region for contract
                foreach ($request->all() as $k => $value) {
                    $checkInput = strpos($k, "countries_");
                    if ($checkInput === 0) {
                        $ops["country_id"] = $value;
                        $ops["contracts_id"] = $id;
                        $key = substr($k, strpos($k, "_") + 1);
                        $opREQUEST = "operator_id_" . $key;
                        $op_arr = $request->$opREQUEST;
                        $ids = implode(',', $op_arr);
                        $ops["operator_ids"] = $ids;
                        DB::table('contracts_operator')->insert($ops);
                        array_push($country_ids, $value);
                    }
                }
                $row->service()->sync($request->service_id);
                // update items
                $row->item()->delete();
                if ($data['contract_type'] != 2) {
                  foreach ($request->item as $k => $item) {
                      $items["department_id"] = isset($request->dep_id[$k])?implode(',',$request->dep_id[$k]): 'no department';
                      $items["item"] = $item;
                      $items["contract_id"] = $id;
                      if (!isset($request->dep_id[$k]))
                          unset($items["department_id"]);
                      DB::table('contract_items')->insert($items);
                  }
                }
            }
            $attachment_types = \App\Models\attachmenttypes::all();
            foreach ($attachment_types as $val) {
                $uname = "attachments_" . $val->id;
                if (!is_null(Input::file($uname))) {
                    $files = $request->$uname;
                    foreach ($files as $k => $value) {  // mutliple files for specific type
                        $file = $request->file($uname)[$k];
                        $destinationPath = './uploads/contracts/';
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension(); //if you need extension of the file
                        $rand = rand(10, 1000);
                        $newfilename = \strtotime(date('Y-m-d H:i:s')) . '-' . $rand . '-' . $filename;
                        $uploadSuccess = $value->move($destinationPath, $newfilename);
                        if ($uploadSuccess) {
                            $f = new \App\Models\contractsattachments;
                            $f->attachment_path = $newfilename;
                            $f->attachment_type_id = $val->id;
                            $f->contract_id = $id;
                            $row->attachments()->save($f);
                        }
                    }
                }
            }

            if ($row->contract_type == 1 && $row->final_approve == 0 && $row->ceo_cancel == 0) {
                // send notifications to all managers (finance / legal / operation )
                $users = \App\User::whereIn('id', ApproveGroup())->orWhereIn('id', OperationApproveGroup($country_ids))->get(); // the users that we system will send notifications to
                foreach ($users as $user) {
                    // send SMS
                    $phone = $user->phone_number;
                    $subject = 'New Contract Has Been Created ';
                    $link = 'contracts/show/' . $id;
                    $this->send_sms($phone, $subject, $link);

                    // send notification
                    \SiteHelpers::addNotification(1, $user->id, $subject, $link);

                    // create contract approve for each user
                    $app['contract_id'] = $id;
                    $app['user_id'] = $user->id;
                    $app['created_at'] = date("Y-m-d H:i:s");
                    $app['updated_at'] = date("Y-m-d H:i:s");
                    \App\Models\contractapproves::insert($app);
                }
            }

            if (!is_null($request->input('apply'))) {
                $return = 'contracts/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'contracts?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('contracts/update/')->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('contracts')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('contracts')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    function getOperator(Request $request) {

        $operators = \App\Models\operator::where('country_id', $request->id)->get();
        $op = '';
        if ($operators) {
            foreach ($operators as $key => $val) {
                $op.= "<option  value ='$val->id' >$val->name</option>";
            }
        }
        return $op;
    }

    function getRemoveattach(Request $request) {

        $file = \App\Models\contractsattachments::FindOrFail($request->id);
        $file->delete();
        if (file_exists($file->attachment_path)) {
            unlink($file->attachment_path);
        }
        return 'success';
    }

    public function getChart() {

        $this->data['notExpired'] = $this->data['expired'] = $this->data['fourExpired'] = $this->data['oneExpired'] = 0;
        $contrctsData = \App\Models\contracts::all();

        foreach ($contrctsData as $val) {
            $status = check_contract_status($val->id);
            if ($status == 'success')
                $this->data['notExpired'] +=1;   // not pired yet as expire > 4 months
            elseif ($status == 'info')
                $this->data['fourExpired'] +=1;  // will be expired with 4 months
            elseif ($status == 'warning')
                $this->data['oneExpired'] +=1;   // will be expired with one month
            elseif ($status == 'danger')
                $this->data['expired'] +=1;    // contract already expired
        }

        // print_r($this->data) ; die;

        $this->data['access'] = $this->access;
        return view('contracts.chart', $this->data);
    }

    public function download_pdf($id) {

        $row = \App\Models\contracts::FindOrFail($id);
        $items = DB::table('contract_items')->where('contract_id', $id)->get();
        $content = view('template.preview', compact('items', 'row'))->render();
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle($row->title);

        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'ar';
        $lg['w_page'] = 'page';
        // set some language-dependent strings (optional)
        $pdf::setLanguageArray($lg);
        $pdf::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf::setFontSubsetting(true);
        $pdf::SetFont('freeserif', '', 12);
        $pdf::AddPage();
        $pdf::writeHTML($content, true, false, true, false, '');
        $filename = 'template ' . $row->id . '-' . date("d/m/Y") . '.pdf';
        $pdf::Output($filename);
    }

    public function getNotificationperiod() {
        date_default_timezone_set("Africa/Cairo");
        // get all contracts
        $contracts = \App\Models\contracts::all();
        foreach ($contracts as $contract) {
            $renew = \App\Models\Contractsrenew::where('contract_id', $contract->id)->first();
            if ($renew)
                $start = new \DateTime($renew->end_date);
            else
                $start = new \DateTime($contract->end_date);

            $end = new \DateTime();

            $sub = $end->diff($start);
            $diff = $sub->format('%m');
            if ($sub->format('%y') == 0 && $diff <= $contract->notification_period_months && $sub->invert == 0) {
                // send notifcation to manager

                $employee = \App\User::where('id', $contract->brand_manager_id)->first();

                if ($employee) {
                    $phone = $employee->phone_number;
                    $subject = 'The Contract have less than ' . $contract->notification_period_months . ' month to expired';
                    $link = 'contracts/show/' . $contract->id;
                    $this->send_sms($phone, $subject, $link);
                    \SiteHelpers::addNotification(1, $employee->id, $subject, $link);
                }
            }
        }
    }

    public function getApprove($id, $approve_name) {

        $this->model->where('id', $id)->update(array($approve_name => 1));
        $row = $this->model->find($id);
        if ($row->operation_approve == 1 && $row->finance_approve == 1 && $row->legal_approve == 1 && $row->ceo_cancel == 0) {
            $this->model->where('id', $id)->update(array('final_approve' => 1));
            // send notification to brand manager
            $contract = \App\Models\contracts::find($id);
            $employee = \App\User::where('id', $contract->brand_manager_id)->first();
            if ($employee) {
                $phone = $employee->phone_number;
                $subject = 'The Contract Has Been Approved ' . $id;
                $link = 'contracts/show/' . $id;
                $this->send_sms($phone, $subject, $link);
                \SiteHelpers::addNotification(1, $employee->id, $subject, $link);
            }

            // send commitment notification to users from items
            $contract_items = \App\Models\contractsitems::where('contract_id', $id)->get();
            foreach ($contract_items as $item) {
                if ($item->department_id) {
                  $department_ids = explode(',',$item->department_id);
                  foreach($department_ids as $dep_id){
                    $cdata['department_id'] = $dep_id; //dep
                    $cdata['contract_id'] = $id; //contract id
                    $cdata['commitment'] = $item->item; //commitment
                    $cdata['priority'] = 3;
                    $commitment_id = \App\Models\commitments::insertGetId($cdata);
                    $to_employee = \App\Models\departments::Find($dep_id)->manager_id;
                    $subject = 'New commitment ';
                    $link = 'mycommitments/show/' . $commitment_id;
                    \SiteHelpers::addNotification(1, $to_employee, $subject, $link);
                    // send SMS TO employee
                    $employee = \App\User::where('id', $to_employee)->first();
                    if ($employee) {
                        $phone = $employee->phone_number;
                        $this->send_sms($phone, $subject, $link);
                    }
                    // add to commitment users
                    $cUser = new \App\Models\commitmentsescalation();
                    $cUser->commitment_id = $commitment_id;
                    $cUser->user_id = $to_employee;
                    $cUser->save();
                  }
                }
            }
        }
        return back();
    }

    public function getCancel($id) {

        $this->model->where('id', $id)->update(array('ceo_cancel' => 1, 'final_approve' => 0));
        return back();
    }

    public function getTeamapprove(Request $request) {

        $data['approve'] = $request->approve;
        $data['description'] = $request->description;
        $approve_name = $request->approve_name;
        \App\Models\contractapproves::where('contract_id', $request->contract_id)->where('user_id', \Auth::user()->id)->update($data);
        $row = $this->model->find($request->contract_id);
        if ($approve_name == 'finance_approve' || $approve_name == 'legal_approve') {
            // if value is approve
            if ($data['approve'] == 1) {
                $this->model->where('id', $request->contract_id)->update(array($approve_name => 1));
            }
            // if value is semi approve
            elseif ($data['approve'] == 3) {
                // go to creator
                $user = \App\User::find($row->entry_by);
                $phone = $user->phone_number;
                $subject = 'Contract Has SemiApprove ';
                $link = 'contracts/show/' . $request->contract_id;
                $this->send_sms($phone, $subject, $link);
                \SiteHelpers::addNotification(1, $user->id, $subject, $link);
            }
        } elseif ($approve_name == 'operation_team_approve') {
            // check if there is one approve exists ( min approve )
            if ($row->operation_approve != 1) {
                // if value is approve
                if ($data['approve'] == 1) {
                    $this->model->where('id', $request->contract_id)->update(array('operation_approve' => 1));
                }
                // if value is semi approve
                elseif ($data['approve'] == 3) {
                    // go to creator
                    $user = \App\User::find($row->entry_by);
                    $phone = $user->phone_number;
                    $subject = 'Contract Has SemiApprove ';
                    $link = 'contracts/show/' . $request->contract_id;
                    $this->send_sms($phone, $subject, $link);
                    \SiteHelpers::addNotification(1, $user->id, $subject, $link);
                }
            }
        }
        $this->getFinalapprove($request->contract_id);
        return back();
    }

    public function getCreatorapprove(Request $request) {
        $data['notified_action'] = $request->notified_action;
        $data['notified_description'] = $request->notified_description;
        \App\Models\contractapproves::where('contract_id', $request->contract_id)->where('id', $request->approve_id)->update($data);
        $row = $this->model->find($request->contract_id);
        $approve_row = \App\Models\contractapproves::find($request->approve_id);
        if ($request->notified_action == 1) {
            $department = \App\Models\departments::where('manager_id', $approve_row->user_id)->whereIn('id', DeptIds())->first();
            if ($department) {
                $department_name = strtolower($department->title);
            } else {
                $department_name = "operation";
            }

            $approve_name = $department_name . "_approve";
            // update contract
            $this->model->where('id', $request->contract_id)->update(array($approve_name => 1));
            // notification (approve) to approve user
            $user = \App\User::find($approve_row->user_id);
            $phone = $user->phone_number;
            $subject = 'Contract Has Approved ';
            $link = 'contracts/show/' . $request->contract_id;
            $this->send_sms($phone, $subject, $link);
            \SiteHelpers::addNotification(1, $user->id, $subject, $link);
        } else {
            // notification (disapprove) to  approve user
            $user = \App\User::find($approve_row->user_id);
            $phone = $user->phone_number;
            $subject = 'Contract Has DisApproved ';
            $link = 'contracts/show/' . $request->contract_id;
            $this->send_sms($phone, $subject, $link);
            \SiteHelpers::addNotification(1, $user->id, $subject, $link);
        }
        $this->getFinalapprove($request->contract_id);
        return back();
    }

    public function getFinalapprove($id) {


        $contract  = $this->model->find($id);
        if ($contract->operation_approve == 1 && $contract->finance_approve == 1 && $contract->legal_approve == 1 && $contract->ceo_cancel == 0) {
            // update contract table
            $this->model->where('id', $id)->update(array('final_approve' => 1));

            // send notification to brand manager
            $employee = \App\User::where('id', $contract->brand_manager_id)->first();
            if ($employee) {
                $phone = $employee->phone_number;
                $subject = 'The Contract Has Been Approved ' . $id;
                $link = 'contracts/show/' . $id;
                $this->send_sms($phone, $subject, $link);
                \SiteHelpers::addNotification(1, $employee->id, $subject, $link);
            }

            // send commitment notification to users from items
            $contract_items = \App\Models\contractsitems::where('contract_id', $id)->get();
            foreach ($contract_items as $item) {
                if ($item->department_id) {
                    $cdata['department_id'] = $item->department_id; //dep
                    $cdata['contract_id'] = $id; //contract id
                    $cdata['commitment'] = $item->item; //commitment
                    $cdata['priority'] = 3;  // normal
                    $commitment_id = \App\Models\commitments::insertGetId($cdata);
                    $to_employee = \App\Models\departments::Find($item->department_id)->manager_id;
                    $subject = 'New commitment ';
                    $link = 'mycommitments/show/' . $commitment_id;
                    // send notification to department manager
                    \SiteHelpers::addNotification(1, $to_employee, $subject, $link);
                    // send SMS TO department manager
                    $employee = \App\User::where('id', $to_employee)->first();
                    if ($employee) {
                        $phone = $employee->phone_number;
                        $this->send_sms($phone, $subject, $link);
                    }
                    // add to commitment scalation
                    $cUser = new \App\Models\commitmentsescalation();
                    $cUser->commitment_id = $commitment_id;
                    $cUser->user_id = $to_employee;
                    $cUser->save();
                }
            }
        }
    }


    public function get_provider($id)
    {
      $provider = \App\Models\providers::find($id);
      return $provider;
    }

}
