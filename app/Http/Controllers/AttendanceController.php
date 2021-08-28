<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang    ;
use Carbon\Carbon;

class AttendanceController extends Controller
{ // start in 18-12-2017

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'attendance';
    static $per_page = '100';

    public function __construct()
    {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Attendance();

        $this->info = $this->model->makeInfo($this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'attendance',
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
        $pagination->setPath('attendance');

        $this->data['rowData'] = $results['rows'];
//        dd($this->data['rowData']);
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
        return view('attendance.index', $this->data);
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

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_attendance');
        }


        $this->data['id'] = $id;
        return view('attendance.form', $this->data);
    }

    function getUpload(Request $request, $id = null)
    {

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
            $this->data['row'] = $this->model->getColumnTable('tb_attendance');
        }


        $this->data['id'] = $id;
        return view('attendance.upload', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_attendance');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('attendance.view', $this->data);
    }

    function postSave(Request $request)
    {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_attendance');

            $id = $this->model->insertRow2($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'attendance/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'attendance?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('attendance/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                ->withErrors($validator)->withInput();
        }
    }

    function postUpload(Request $request)
    {

        $rules = array(
            'attendance_sheet' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            // insert employees attendance from excel sheet
            if ($request->file('attendance_sheet') != NULL) {

                $file = $request->file('attendance_sheet');  // to get image
                $destionPath = "attendance_sheet";  // destion path inside "public"
                $fileName = $file->getClientOriginalName();  // to get the name of uploaded file by build-in class  getClientOriginalName()

                $rand = rand(1000, 100000000);
                $newfilename = strtotime(date('Y-m-d H:i:s')) . '-' . $rand . '-' . $fileName;
                $file->move($destionPath, $newfilename);  // to move file to destion path

                $objPHPExcel = \PHPExcel_IOFactory::load("attendance_sheet/" . $newfilename);   // this can read excel file or  csv file
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $Rows = $objWorksheet->toArray();

                if ($Rows) {
                    foreach ($Rows as $key => $value) {


                        if ($key > 0 && trim(intval($value[0])) != 0) {

                            $date = date("Y-m-d", strtotime(trim($value[2])));
                            $Attendance = new Attendance();
                            $Attendance->employee_finger_id = trim(intval($value[0]));
                            $Attendance->employee_name = trim($value[1]);
                            $Attendance->date = $date;
                            $Attendance->work_day = trim($value[3]);
                            $Attendance->day_type = trim($value[4]);
                            $Attendance->sign_in = trim($value[5]);
                            $Attendance->sign_out = trim($value[6]);
                            $Attendance->work_hours = trim($value[7]);
                            $Attendance->overtime = trim($value[8]);
                            $Attendance->short_minutes = trim($value[9]);
                            $Attendance->leave_type = trim($value[10]);
                            $Attendance->entry_by = \Auth::user()->id;
                            $Attendance->created_at = date("Y-m-d H:i:s");
                            $Attendance->updated_at = date("Y-m-d H:i:s");
                            $Attendance->save();
                        }
                    }
                }

                return Redirect::to('attendance')->with('messagetext', \Lang::get('core.excel file is uploded successfully'))->with('msgstatus', 'success');
            } else {
                return Redirect::back()->with('messagetext', \Lang::get('core.you_must_upload_excel_file'))->with('msgstatus', 'error');
            }
        } else {

            return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('attendance')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('attendance')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    function postSign(Request $request)
    {

        if (!isset(\Auth::user()->id)) {
            $message = "You must login";
            return Redirect::to('dashboard')->with('messagetext', $message)->with('msgstatus', 'error');
        }
        $currentUser = User::where('id', \Auth::user()->id)->first();
        if (!$currentUser) {
            $message = "You must login";
            return Redirect::to('dashboard')->with('messagetext', $message)->with('msgstatus', 'error');
        }


        if ($currentUser && $currentUser->ivas_login_inside == 1) {  // login inside
            date_default_timezone_set('Africa/Cairo');

            $weekNameArray = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            $week_no = date('w');
            $week_day_name = $weekNameArray[$week_no];
            if ($week_day_name == "Friday" || $week_day_name == "Saturday") {
                $dayType = "RESTDAY";
            } else {
                $dayType = "WORKDAY";
            }


            $currentUser = User::findOrFail(\Auth::user()->id);

            if (isset($currentUser->employee_finger_id)) {
                $employee_finger_id = $currentUser->employee_finger_id;
            } else {
                $employee_finger_id = "";
            }

            if (!is_null($request->input('sign_in'))) {  // sign_in
                $Attendance = new Attendance();
                $Attendance->employee_finger_id = $employee_finger_id;
                $Attendance->employee_id = \Auth::user()->id;
                $Attendance->employee_name = $currentUser->first_name . " " . $currentUser->last_name;
                $Attendance->date = date("Y-m-d");
                $Attendance->work_day = $week_day_name;
                $Attendance->day_type = $dayType;
                $Attendance->sign_in = date("h:i A");
                $Attendance->entry_by = \Auth::user()->id;
                $Attendance->created_at = date("Y-m-d H:i:s");
                $Attendance->updated_at = date("Y-m-d H:i:s");
                $Attendance->save();
                $message = "You make Sign In successfully";
            } else {  // sign_out
                $attendance = Attendance::where('employee_id', \Auth::user()->id)->where('date', date('Y-m-d'))->first();
                $attendance->sign_out = date("h:i A");
                $attendance->save();
                $message = "You make Sign Out successfully";
            }

            return Redirect::to('dashboard')->with('messagetext', $message)->with('msgstatus', 'success');
        } else {
            $message = "You login outside IVAS company";
            return Redirect::to('dashboard')->with('messagetext', $message)->with('msgstatus', 'error');
        }
    }

    // make synchrous from punch database daily
    function punch(Request $request)
    {

        ini_set('max_execution_time', 60000000000);
        ini_set('memory_limit', '-1');

        date_default_timezone_set('Africa/Cairo');
        if(isset($request->date) AND $request->date !="" ){
            $punch_date = $request->date ;
        }else{
            $punch_date = date("Y-m-d", strtotime("-1 Day"));
        }


        $subject = 'punch sync for prev Day  :' . $punch_date . " at  time : " . Carbon::now()->format('Y-m-d H:i:s');
        $email = 'emad@ivas.com.eg';
        $this->sendMail($subject, $email);


        $weekNameArray = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $week_no = date('w', strtotime($punch_date));
        $week_day_name = $weekNameArray[$week_no];


        $offset = 0;
        $lmt = 10;
        while (true) {

            //   $attendances =  $this->sms_update_hr_punch($punch_date,$offset,$lmt) ;


            $attendances = \DB::connection('punch')->select("SELECT userid , date ,daytype,daytype,att_in,att_out,workhour  FROM attendance  WHERE date= '" . $punch_date . "'  LIMIT " . $offset . "," . $lmt . ";");


            if (count($attendances) == 0) {
                break;
            }
            $query = "INSERT INTO tb_attendance ( employee_finger_id,employee_name,employee_id,date,work_day,day_type,sign_in,sign_out,work_hours,overtime,short_minutes,created_at,updated_at) VALUES";

            $tuple = " ('%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'),";
            $values = "";

            foreach ($attendances as $att ){
                $attendance =   (object)$att  ;
                $employee_finger_id = $attendance->userid;

                $user = User::where('employee_finger_id', $employee_finger_id)->first();
                if ($user) {
                    $employee_name = $user->first_name . " " . $user->last_name;
                    $employee_id = $user->id;
                } else {
                    $employee_name = "";
                    $employee_id = "";
                }

                $date = $attendance->date;
                $work_day = $week_day_name;
                if ($attendance->daytype == "W") {
                    $day_type = "WORKDAY";
                } else {
                    $day_type = "RESTDAY";
                }



                if($attendance->workhour != "0.00")
                    $sign_in =date("g:i a", strtotime($attendance->att_in)) ;
                else
                    $sign_in = "" ;

                if($attendance->workhour != "0.00")
                    $sign_out = date("g:i a", strtotime($attendance->att_out))  ;
                else
                    $sign_out = "" ;


                // 1 - calculate overtime
                $work_hours = $attendance->workhour;
                if ($work_hours != 0) {
                    $diff = abs(strtotime($sign_in) - strtotime($sign_out));
                    $tmins = $diff / 60;
                    $hours = floor($tmins / 60);
                    $mins = $tmins % 60;
                    $time = $hours . '.' . $mins;


                    if ($time > 8) {  // overtime calculated after 8 h
                        $overtime = $time - 8;
                    } else {
                        $overtime = 0;
                    }


                    // 2 - calculate short minutes

                    $diff_minutes = max((strtotime($sign_in) - strtotime("09:00")) / 60, 0);  // we put here max(DIFF,0)  to take 0 if value is minus


                    if ($diff_minutes <= 30)
                        $short_minutes = 0;
                    else {
                        $diff_hours = floor($diff_minutes / 60);
                        $diff_mins = $diff_minutes % 60;
                        $short_minutes = $diff_hours . '.' . $diff_mins;
                    }
                } else {
                    $short_minutes = $overtime = 0;
                }
                $created_at = date("Y-m-d H:i:s");
                $updated_at = date("Y-m-d H:i:s");


                $values .= sprintf($tuple, $employee_finger_id, $employee_name, $employee_id, $date, $work_day, $day_type, $sign_in, $sign_out, $work_hours, $overtime, $short_minutes, $created_at, $updated_at);
                $atte = \DB::table('tb_attendance')->select('*')->where('employee_finger_id',$employee_finger_id)->where('date',$date)->first();
                if(!$values == "")
                {
                  if($atte){
                    \DB::table('tb_attendance')->where('employee_finger_id',$employee_finger_id)
                    ->update([
                      'employee_name' => $employee_name,
                      'employee_id' => $employee_id,
                      'date' => $date,
                      'work_day' => $work_day,
                      'day_type' => $day_type,
                      'sign_in' => $sign_in,
                      'sign_out' => $sign_out,
                      'work_hours' => $work_hours,
                      'overtime' => $overtime,
                      'short_minutes' => $short_minutes,
                      'created_at' => $created_at,
                      'updated_at' => $updated_at
                    ]);
                  }else{
                    \DB::table('tb_attendance')->insert([
                      'employee_finger_id' => $employee_finger_id,
                      'employee_name' => $employee_name,
                      'employee_id' => $employee_id,
                      'date' => $date,
                      'work_day' => $work_day,
                      'day_type' => $day_type,
                      'sign_in' => $sign_in,
                      'sign_out' => $sign_out,
                      'work_hours' => $work_hours,
                      'overtime' => $overtime,
                      'short_minutes' => $short_minutes,
                      'created_at' => $created_at,
                      'updated_at' => $updated_at
                    ]);
                  }
                }
            }
            // if (!$values == "") {
            //     $query = $query . $values;
            //     $query = rtrim($query, ","); // Remove trailing comma
            //     // echo $query ; die;
            //     \DB::insert($query);
            // }
            $offset += $lmt;
        }

        echo "Database updated successfully for day :".$punch_date;


    }


    public function refresh_punch()
    {
      $command = "php artisan run:punch";
      $ex = exec($command);
      if($ex)
        return back()->with(['message' => \SiteHelpers::alert('success', 'Success Update Date From Punch')]);
      else
        return back()->with(['message' => \SiteHelpers::alert('error', 'Error In Command')]);
    }

    public function sendMail($subject, $email)
    {

        $message = '<!DOCTYPE html>
					<html lang="en-US">
						<head>
							<meta charset="utf-8">
						</head>
						<body>
							<h2> punch sync for :' . Carbon::now()->format('Y-m-d') . '</h2>



						</body>
					</html>';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $email;

        @mail($email, $subject, $message, $headers);
    }


    static function over($employee_finger_id, $date)
    {
        // get overtimes for users
        $user = User::where('employee_finger_id', $employee_finger_id)->first();
        if ($user) {
            $user_id = $user->id;
            $time = \App\Models\Overtimes::where('employee_id', $user_id)->where('date', $date)->first();
            if ($time) {
                $overtime = $time;
            } else {
                $overtime = 'none';
            }
        } else {
            $overtime = 'none';
        }
        return $overtime;

    }


    static function vacation($employee_finger_id, $date)
    {
        // get overtimes for users
        $user = User::where('employee_finger_id', $employee_finger_id)->first();
        //dd($user);
        $check = 0;
        if ($user) {
            $user_id = $user->id;
            $sql = "SELECT * FROM tb_vacations WHERE employee_id = {$user_id} AND
                    (

                      tb_vacations.from = '{$date}'
                                    OR
                                    tb_vacations.to = '{$date}'
                                    OR
                                    ( tb_vacations.from < '{$date}'     AND  tb_vacations.to >  '{$date}'   )
                    )
                 ";

            $vacat = \DB::select($sql);

            if ($vacat) {
                $check=1;
                $vacation = $vacat;
            } else {
              $sql = "SELECT * FROM `tb_permissions` WHERE `employee_id` = {$user_id} AND `date` = '{$date}' ";
                  $vacat = \DB::select($sql);
                  //dd(\DB::select($sql));die;
                if ($vacat) {
                    $vacation = $vacat;
                } else {
                    $vacation = 'none';
                }
            }
        } else {
            $vacation = 'none';
        }
        return [$vacation , $check];

    }
}
