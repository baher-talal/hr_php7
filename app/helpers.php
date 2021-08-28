<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

function check_contract_status($id) {

    $status = '';
    $row = \App\Models\contracts::find($id);
    $renew = \App\Models\Contractsrenew::where('contract_id', $id)->first();
    if ($renew)
        $start = new DateTime($renew->end_date);
    else
        $start = new DateTime($row->end_date);
    $now = date("Y-m-d") ;
    $end = new DateTime($now);  // we should make this to neglect times
    $sub = $end->diff($start);
    $diff = $sub->format('%m');

    if (($sub->format('%y') >= 1 || $diff > ContractMonthCheck ) && $sub->invert == 0)  // invert = 0  mean contact  is not expire
        $status = 'success';
    elseif ($diff == ContractMonthCheck && $sub->invert == 0)
        $status = 'info';
    elseif ($diff <= 1 && $sub->invert == 0)
        $status = 'warning';
    elseif ($sub->invert == 1)   // invert = 1  mean contact is expired
        $status = 'danger';
    return $status;
}

function check_task_status($id) {
    $status = '';
    $row = \App\Models\tasks::find($id);
    if ($row->status == 4) {
        $status = 'success';
    } elseif ($row->status == 3) {
        $status = 'info';
    } elseif ($row->status == 2) {
        $status = 'danger';
    } elseif ($row->status == 1 || $row->status == 0) {
        $status = 'default';
    }
    return $status;
}

function get_task_history($id) {

    $rows = \App\Models\tasktime::where('task_id', $id)->get();
    return $rows;
}

function get_diff_taskhistory($id) {

    $tasktime = \App\Models\tasktime::find($id);
    if ($tasktime->end_time == 0) {
        $time = 0;
    } else {
        $start = new DateTime($tasktime->start_time);
        $end = new DateTime($tasktime->end_time);
        $sub = $end->diff($start);
        $time['hour'] = $sub->format('%h');
        $time['min'] = $sub->format('%i');
    }
    return $time;
}

function get_commitment_progress($id) {


    $data['alltasks'] = \App\Models\tasks::where("commitment_id", $id)->count();
    $data['completedtasks'] = \App\Models\tasks::where("commitment_id", $id)->where('status', 4)->count();
    $data['waitingtasks'] = \App\Models\tasks::where("commitment_id", $id)->where('status', 0)->count();
    $data['initialtasks'] = \App\Models\tasks::where("commitment_id", $id)->where('status', 1)->count();
    $data['pendingtasks'] = \App\Models\tasks::where("commitment_id", $id)->where('status', 2)->count();
    $data['workingtasks'] = \App\Models\tasks::where("commitment_id", $id)->where('status', 3)->count();
    $data['notcompletedtasks'] = $data['alltasks'] - $data['completedtasks'];

    return $data;
}

function get_contract_progress($id) {


    $data['alltasks'] = \App\Models\tasks::join('tb_commitments', 'tb_commitments.id', '=', 'tb_tasks.commitment_id')->join('tb_contracts', 'tb_contracts.id', '=', 'tb_commitments.contract_id')->where("tb_contracts.id", $id)->count();
    $data['completedtasks'] = \App\Models\tasks::join('tb_commitments', 'tb_commitments.id', '=', 'tb_tasks.commitment_id')->join('tb_contracts', 'tb_contracts.id', '=', 'tb_commitments.contract_id')->where("tb_contracts.id", $id)->where('tb_tasks.status', 4)->count();
    $data['waitingtasks'] = \App\Models\tasks::join('tb_commitments', 'tb_commitments.id', '=', 'tb_tasks.commitment_id')->join('tb_contracts', 'tb_contracts.id', '=', 'tb_commitments.contract_id')->where("tb_contracts.id", $id)->where('tb_tasks.status', 0)->count();
    $data['initialtasks'] = \App\Models\tasks::join('tb_commitments', 'tb_commitments.id', '=', 'tb_tasks.commitment_id')->join('tb_contracts', 'tb_contracts.id', '=', 'tb_commitments.contract_id')->where("tb_contracts.id", $id)->where('tb_tasks.status', 1)->count();
    $data['pendingtasks'] = \App\Models\tasks::join('tb_commitments', 'tb_commitments.id', '=', 'tb_tasks.commitment_id')->join('tb_contracts', 'tb_contracts.id', '=', 'tb_commitments.contract_id')->where("tb_contracts.id", $id)->where('tb_tasks.status', 2)->count();
    $data['workingtasks'] = \App\Models\tasks::join('tb_commitments', 'tb_commitments.id', '=', 'tb_tasks.commitment_id')->join('tb_contracts', 'tb_contracts.id', '=', 'tb_commitments.contract_id')->where("tb_contracts.id", $id)->where('tb_tasks.status', 3)->count();
    $data['notcompletedtasks'] = $data['alltasks'] - $data['completedtasks'];

    return $data;
}

function countTasks($id, $commitmentID) {

    $count = \App\Models\tasks::where("assign_to_id", $id)->where("commitment_id", $commitmentID)->count();

    return $count;
}

// return
function ApproveGroup() {
        $ids = \App\Models\departments::where('title', 'like', '%Finance%')->orWhere('title', 'like', '%Legal%')->select('manager_id')->get()->toArray();
    return $ids;
}


// this return regions account manager or all account managers "All"
function OperationApproveGroup($country_ids) {
    $country_title = App\Models\countries::whereIn('id',$country_ids)->pluck('country')->toArray();

    if(in_array('All', $country_title)){
        $operation_dep = \App\Models\departments::where('title', 'like', '%Operation%')->select('id')->first();
        // operation all team ids
        $ids = \App\User::where('department_id', $operation_dep->id)->Where('active', 1)->pluck('id')->toArray();
    }
    else{
        // account manager ids
       $ids = App\Models\countries::whereIn('id',$country_ids)->pluck('account_manager_id')->toArray();
    }
    return $ids;
}

function CheckAcquisitionAccess() {

    $check = \App\Models\acquisitionapproves::where('user_id',\Auth::user()->id)->exists();

    return $check;
}

function checkUserApproveName() {
    // get department name for Finance / Legal  that login user is manager to it
    $department = \App\Models\departments::where('manager_id', \Auth::user()->id)->whereIn('id',  DeptIds())->first();
    if ($department) {
        $department_name = strtolower($department->title);
    }
    else {
        $department_name = "operation_team";
    }
    return $department_name;
}

function checkDeptManager() {
    $department_id = 0;
    $department = \App\Models\departments::where('manager_id', \Auth::user()->id)->first();
    if ($department) {
        $department_id = $department->id;
    }
    return $department_id;
}
function DeptIds() {
    $ids = \App\Models\departments::where('title', 'like', '%Finance%')->orWhere('title', 'like', '%Legal%')->orWhere('title', 'like', '%CEO%')->pluck('id')->toArray();
    return $ids;
}

function get_providers()
{
  $row = \App\Models\providers::all();
  return $row;
}

function months()
{
  return ['January','February','March','April','May','June','July','August','September','October','November','December'];
}

function years()
{
  $current = (int)date("Y");
  $current  -= 10;
  $years = array();
  for($i = 0;$i <= 20;$i++){
    array_push($years, $current++);
  }

  return $years;
}

 function get_track($tarck_id,$country_from_ip)
{
  //$country_from_ip = 1;
  $country = \App\Models\Countries::where('country', 'LIKE', '%' . $country_from_ip . '%')->first();
  $track = \App\Models\Campaignoperatorstracks::where('track_id',$tarck_id)->get();
  $operators = [];
  foreach ($track as $tr) {
    if($country){
      $operator=  \App\Models\Operator::where('id',$tr->operator_id)->where('country_id',$country->id)->first();
    }
    else{
      $operator=  \App\Models\Operator::where('id',$tr->operator_id)->first();
    }
    if($operator){
        $operator->code = $tr->code;
        array_push($operators,$operator);
    }

  }
  return $operators;
}
