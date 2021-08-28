<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mytravelling;
use App\Models\Visadays;
use App\User;
use App\Models\Countryperdiem;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,Lang;

class MytravellingController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'mytravelling';
    static $per_page = '10';

    public function __construct() {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Mytravelling();
      //  var_dump($this->model); die;

        $this->info = $this->model->makeInfo($this->module);
         $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'mytravelling',
            'return' => self::returnUrl()
        );
    }

	// init get from date 28-9-2017
    public function getIndex(Request $request) {

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
        $pagination->setPath('mytravelling');

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
        return view('mytravelling.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_travellings');
        }


        $this->data['id'] = $id;
        return view('mytravelling.form', $this->data);
    }

    public function getShow($id = null) {




        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
            $this->data['currency'] = Countries::where(['id' => $row->country_id])->first()->currency;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_travellings');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('mytravelling.view', $this->data);
    }





    function postSave(Request $request) {

        date_default_timezone_set("Africa/Cairo");
        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_mytravelling');


            $Visadays = Visadays::where('country_id', '=', $request->input('country_id'))->first();
            // return $Visadays ;

            if ($data['to'] == $data['from']) {
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                                ->withErrors('To Date must be greater than  From Date')->withInput();
            } elseif ($data['to'] > $data['from']) {
                $date1 = new \DateTime($data['from']);
                $date2 = new \DateTime($data['to']);
                $peroid = $date2->diff($date1)->format("%a") + 1;


                if ($request->input('want_visa') == 1) {

                    // exculde weekend days from two dates
                    $weekend_days= array(5,6);   // weekend days = Friday and Saturday
                    $no_of_weekend_days = 0 ;
                    for($i=0;$i<$peroid;$i++){
                        $start =date("Y-m-d",strtotime($data['from']." +$i day"));
                        $dayofweek = date('w', strtotime($start));
                        echo $start.'----------'.$dayofweek .'<br>';
                        if(in_array($dayofweek,$weekend_days)){
                            $no_of_weekend_days++;
                        }


                    }

                    $peroid_without_weekend_days= $peroid - $no_of_weekend_days ;


                    if ($Visadays) {
                        $today = date("Y-m-d");
                        $lessFromDate = date("Y-m-d", strtotime($today . "+$Visadays->no_days days"));


                        if ($peroid_without_weekend_days < $Visadays->no_days) {

                            return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                                            ->withErrors('This country visa takes ' . $Visadays->no_days . ' day(s) without weekend days Friday and Saturday' )->withInput();
                        }
                    }
                }
            } else {
                return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                                ->withErrors('To Date must be greater than From Date')->withInput();
            }



            // to let employee create new travelling  "Mytravelling module"
            $user = User::where('id', \Auth::user()->id)->first();

            if ($user) {
                $departmentId = $user->department_id;
                $department = \DB::table('tb_departments')->where('id', $departmentId)->first();
                $mangerId = $department->manager_id;
            }
            $data['employee_id'] = $user->id;
            $data['department_id'] = $departmentId;
            $data['manager_id'] = $mangerId;
            $data['date'] = date("Y-m-d");

            $Mytravelling = new Mytravelling();
            $Mytravelling->employee_id = $user->id;
            $Mytravelling->department_id = $departmentId;
            $Mytravelling->manager_id = $mangerId;
            $Mytravelling->date = date("Y-m-d");
            $Mytravelling->from = $request->input('from');
            $Mytravelling->to = $request->input('to');
            $Mytravelling->country_id = $request->input('country_id');
            $Mytravelling->reason = $request->input('reason');
            $Mytravelling->objectives = $request->input('objectives');
            $Mytravelling->want_visa = $request->input('want_visa');
            $Mytravelling->entry_by = \Auth::user()->id;
            $Mytravelling->save();

            $id = $Mytravelling->id;

            //  $id = $this->model->insertRow2($data, $request->input('id'));
            // mean that department manager make travelling ... so hr can approve to this
            if ($mangerId == $user->id) {
                //$data['manager_approved'] = 1;
                // send notification to hr to can approve or refuse
                $subject = "New travelling request from manager:  " . $user->first_name . ' ' . $user->last_name;


                if ($user->id == CEO_USER_ID) {
                    $Mytravelling->manager_approved = 1;
                    $Mytravelling->cfo_approve = 1;
                    $Mytravelling->ceo_approve = 1;
                    $Mytravelling->save();

                    $link = 'mytravelling/adminassit/' . $id;
                    \SiteHelpers::addNotification($user->id, CEO_USER_ID2, $subject, $link);  // send travelling request to reem if employee is manager + haitham
                    $AdminAssit = User::where('id', CEO_USER_ID2)->first();
                    // send SMS TO CEO Backup = reem
                        $phone = $AdminAssit->phone_number;
                        $this->send_sms($phone,$subject, $link);


                } else {
                    $link = 'mytravelling/admin/' . $id;
                    \SiteHelpers::addNotification($user->id, ADMIN_USER_ID, $subject, $link);    // send travelling request to mayar if employee is manager
                    // send SMS TO Admin
                    $Admin = User::where('id', ADMIN_USER_ID)->first();
                    $phone = $Admin->phone_number;
                    $this->send_sms($phone,$subject,$link);

                }
            }

            // send notification to manager if empployee request travelling from his manager
            if ($mangerId != $user->id) {  // employee make overtime and send notification to his manager
                $subject = "New travelling request from " . $user->first_name . ' ' . $user->last_name;
                $link = 'employeestravelling/update/' . $id;
                \SiteHelpers::addNotification($user->id, $mangerId, $subject, $link);

                // send SMS TO Admin
                $manager = User::where('id', $mangerId)->first();
                $phone = $manager->phone_number;
                $this->send_sms($phone,$subject,$link);

            }



            if (!is_null($request->input('apply'))) {
                $return = 'mytravelling/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'mytravelling?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('mytravelling/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            return Redirect::to('mytravelling')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('mytravelling')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    // admin set cost for travelling
    function getAdmin(Request $request, $id = null) {

        $accessUser = ADMIN_USER_ID;
        if ($this->checkAdmin($accessUser)) {
            $row = $this->model->find($id);
            if ($row->total_cost == NULL) { //  decision not taken yet
                if ($row) {
                    $this->data['row'] = $row;
                } else {
                    $this->data['row'] = $this->model->getColumnTable('tb_travellings');
                }

                $this->data['id'] = $id;
                if ($row) {
                    $travellingRequester = User::where('id', '=', $row->employee_id)->first();
                    $Countryperdiem = Countryperdiem::where(['country_id' => $row->country_id, 'per_diem_position_id' => $travellingRequester->per_diem_position_id])->first();


                    $date1 = new \DateTime($row->from);
                    $date2 = new \DateTime($row->to);
                    $peroid = $date2->diff($date1)->format("%a") + 1;



                    if ($Countryperdiem) {
                        $this->data['cost'] = $Countryperdiem->per_diem_cost*$peroid;
                         $this->data['peroid'] = $peroid ;
                         $this->data['per_diem_cost'] = $Countryperdiem->per_diem_cost ;
                         $this->data['currency'] = Countries::where(['id' => $row->country_id])->first()->currency;
                    } else {
                        $this->data['cost'] = "";
                         $this->data['peroid'] = "";
                         $this->data['per_diem_cost'] = "" ;
                          $this->data['currency'] = "";
                    }

                    if ($row->want_visa == 0) {
                        $this->data['visa_cost'] = 0;
                    } else {
                        $this->data['visa_cost'] = 1;
                    }


                    return view('mytravelling.admin_form', $this->data);
                } else {
                    return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.page_not_found'))->with('msgstatus', 'error');
                }
            } else {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.your make decision to this travelling before !'))->with('msgstatus', 'error');
            }
        } else {
            return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }
    }

    // admin set cost for travelling
    function getAdminassit(Request $request, $id = null) {

        $accessUser = CEO_USER_ID2;  // reem
        if ($this->checkAdmin($accessUser)) {
            $row = $this->model->find($id);
            if ($row->total_cost == NULL) { //  decision not taken yet
                if ($row) {
                    $this->data['row'] = $row;
                } else {
                    $this->data['row'] = $this->model->getColumnTable('tb_travellings');
                }

                $this->data['id'] = $id;
                if ($row) {
                    $travellingRequester = User::where('id', '=', $row->employee_id)->first();
                    $Countryperdiem = Countryperdiem::where(['country_id' => $row->country_id, 'per_diem_position_id' => $travellingRequester->per_diem_position_id])->first();

                    if ($Countryperdiem) {
                        $this->data['cost'] = $Countryperdiem->per_diem_cost;
                    } else {
                        $this->data['cost'] = "";
                    }

                    if ($row->want_visa == 0) {
                        $this->data['visa_cost'] = 0;
                    } else {
                        $this->data['visa_cost'] = 1;
                    }


                    return view('mytravelling.admin_form', $this->data);
                } else {
                    return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.page_not_found'))->with('msgstatus', 'error');
                }
            } else {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.your make decision to this travelling before !'))->with('msgstatus', 'error');
            }
        } else {
            return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }
    }

    function postAdmin(Request $request) {

        // $rules = $this->validateForm();
        $id = $request->input('id');
        $Travelling = Mytravelling::findOrFail($id);

        // make validation depend on want_visa
        if ($Travelling->want_visa == 1) {
            $rules = array(
                'hotel_cost' => 'required',
                'airline_ticket_cost' => 'required',
                'per_diem_cost' => 'required',
                'visa_cost' => 'required',
            );
        } else {
            $rules = array(
                'hotel_cost' => 'required',
                'airline_ticket_cost' => 'required',
                'per_diem_cost' => 'required',
            );
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            //  $id = $this->model->insertRow2($data, $request->input('id'));
            // update current travelling made by admin (mayar)
            $Travelling->hotel_cost = $request->input('hotel_cost');
            $Travelling->airline_ticket_cost = $request->input('airline_ticket_cost');
            $Travelling->per_diem_cost = $request->input('per_diem_cost');
            $Travelling->visa_cost = $request->input('visa_cost');
            $Travelling->total_cost = $request->input('hotel_cost') + $request->input('airline_ticket_cost') + $request->input('per_diem_cost') + $request->input('visa_cost');
            $Travelling->save();


            if ($Travelling->employee_id == CEO_USER_ID) {  // haitham
                // then send notification to reem
                $admin_subject = "Your travelling arrangement is finished";
                $admin_link = "mytravelling/show/" . $id;
                \SiteHelpers::addNotification(\Auth::user()->id, $Travelling->employee_id, $admin_subject, $admin_link);

                // send SMS
                $Employee = User::where('id', $Travelling->employee_id)->first();
                $phone = $Employee->phone_number;
                $this->send_sms($phone,$admin_subject,$admin_link);

            } else {
                // then send notification to cfo
                $admin_subject = "New travelling by our admin";
                $admin_link = "mytravelling/cfo/" . $id;
                \SiteHelpers::addNotification(\Auth::user()->id, CFO_USER_ID, $admin_subject, $admin_link); // main cfo
                \SiteHelpers::addNotification(\Auth::user()->id, CFO_BACKUP_ID, $admin_subject, $admin_link); // backup cfo
                // send SMS TO CFO
                $CFO = User::where('id', CFO_USER_ID)->first();
                $phone = $CFO->phone_number;
                $this->send_sms($phone,$admin_subject,$admin_link);


                // send SMS TO BACKUP CFO
                $BackupCFO = User::where('id', CFO_BACKUP_ID)->first();
                $phone = $BackupCFO->phone_number;
                $this->send_sms($phone,$admin_subject,$admin_link);

            }


            $return = 'mytravelling';


            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.request sented to CFO'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('travelling')->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    // CFO make approve to tavelling
    function getCfo(Request $request, $id = null) {

        if ($this->checkAdmin(CFO_USER_ID) || $this->checkAdmin(CFO_BACKUP_ID)) {
            $row = $this->model->find($id);
            if ($row->cfo_approve == 2) { //  decision not taken yet
                if ($row) {
                    $this->data['row'] = $row;
                   $this->data['currency'] = Countries::where(['id' => $row->country_id])->first()->currency;
                } else {
                    $this->data['row'] = $this->model->getColumnTable('tb_travellings');
                }



                $this->data['id'] = $id;



                if ($row) {
                    return view('mytravelling.cfo_form', $this->data);
                } else {
                    return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.page_not_found'))->with('msgstatus', 'error');
                }
            } else {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.your make decision to this travelling before !'))->with('msgstatus', 'error');
            }
        } else {
            return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }
    }

    function postCfo(Request $request) {

        // $rules = $this->validateForm();
        $id = $request->input('id');
        $Travelling = Mytravelling::findOrFail($id);

        // make validation depend on want_visa
        $rules = array(
            'cfo_approve' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            //  $id = $this->model->insertRow2($data, $request->input('id'));
            // update current travelling made by admin (mayar)
            $Travelling->cfo_approve = $request->input('cfo_approve');
            $Travelling->cfo_reason = $request->input('cfo_reason');
            $Travelling->save();


            if ($request->input('cfo_approve') == 1) {
                // then send notification to ceo
                $ceo_subject = "New travelling by CFO";
                $ceo_link = "mytravelling/ceo/" . $id;
                \SiteHelpers::addNotification(\Auth::user()->id, CEO_USER_ID, $ceo_subject, $ceo_link);
                \SiteHelpers::addNotification(\Auth::user()->id, CEO_USER_ID2, $ceo_subject, $ceo_link);

                // send SMS TO CEO
                $Ceo = User::where('id', CEO_USER_ID)->first();
                $phone = $Ceo->phone_number;
                $this->send_sms($phone,$ceo_subject,$ceo_link);

                // send SMS TO CEO Backup
                $CeoBackup = User::where('id', CEO_USER_ID2)->first();
                $phone = $CeoBackup->phone_number;
                $this->send_sms($phone,$ceo_subject,$ceo_link);

            } else {  // cfo reject
                // so  send notification to travelling requester
                $subject = "Your travelling is refued by CFO";
                if (strlen(trim($request->input('cfo_reason'))) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $request->input('cfo_reason');
                }

                $link = "mytravelling/show/" . $id;
                \SiteHelpers::addNotification(\Auth::user()->id, $Travelling->employee_id, $subject, $link);

                // send SMS TO CEO Backup
                $Employee = User::where('id', $Travelling->employee_id)->first();
                $phone = $Employee->phone_number;
                $this->send_sms($phone,$subject,$link);

            }


            $return = 'mytravelling';


            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.request sented to CEO'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('travelling')->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    // CEO make approve to tavelling
    function getCeo(Request $request, $id = null) {

        if (\Auth::user()->id == CEO_USER_ID || \Auth::user()->id == CEO_USER_ID2) {

            $row = $this->model->find($id);

            if ($row->ceo_approve == 2) { //  decision not taken yet
                if ($row) {
                    $this->data['row'] = $row;
                    $this->data['currency'] = Countries::where(['id' => $row->country_id])->first()->currency;
                } else {
                    $this->data['row'] = $this->model->getColumnTable('tb_travellings');
                }

                $this->data['id'] = $id;

                if ($row) {
                    return view('mytravelling.ceo_form', $this->data);
                } else {
                    return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.page_not_found'))->with('msgstatus', 'error');
                }
            } else {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.decision to this travelling is taken before !'))->with('msgstatus', 'error');
            }
        } else {
            return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }
    }

    function postCeo(Request $request) {

        // $rules = $this->validateForm();
        $id = $request->input('id');
        $Travelling = Mytravelling::findOrFail($id);

        // make validation depend on want_visa
        $rules = array(
            'ceo_approve' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            //  $id = $this->model->insertRow2($data, $request->input('id'));
            // update current travelling made by admin (mayar)
            $Travelling->ceo_approve = $request->input('ceo_approve');
            $Travelling->ceo_reason = $request->input('ceo_reason');
            $Travelling->save();


            if ($request->input('ceo_approve') == 1) {
                // then send notification to ceo
                $subject = "New travelling  approved by CEO";
                $link = "mytravelling/review/" . $id;
                \SiteHelpers::addNotification(\Auth::user()->id, ADMIN_USER_ID, $subject, $link);

                // send SMS TO Admin
                $Admin = User::where('id', ADMIN_USER_ID)->first();
                $phone = $Admin->phone_number;
                $this->send_sms($phone,$subject,$link);

            } else {  // ceo reject
                // so  send notification to travelling requester
                $subject = "Your travelling is refued by CEO";
                if (strlen(trim($request->input('ceo_reason'))) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $request->input('ceo_reason');
                }

                $link = "mytravelling/show/" . $id;
                \SiteHelpers::addNotification(\Auth::user()->id, $Travelling->employee_id, $subject, $link);

                // send SMS TO requester
                $Employee = User::where('id', $Travelling->employee_id)->first();
                $phone = $Employee->phone_number;
                $this->send_sms($phone,$subject,$link);
            }

            $return = 'mytravelling';

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.request sented to CEO'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('travelling')->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    function getReview(Request $request, $id = null) {

        $accessUser = ADMIN_USER_ID;
        if ($this->checkAdmin($accessUser)) {
            $row = $this->model->find($id);
            if ($row->admin_notes == NULL) { //  decision not taken yet
                if ($row) {
                    $this->data['row'] = $row;

                      $this->data['currency'] = Countries::where(['id' => $row->country_id])->first()->currency;

                } else {
                    $this->data['row'] = $this->model->getColumnTable('tb_travellings');
                }

                $this->data['id'] = $id;

                if ($row) {
                    return view('mytravelling.review_form', $this->data);
                } else {
                    return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.page_not_found'))->with('msgstatus', 'error');
                }
            } else {
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.your make decision to this travelling before !'))->with('msgstatus', 'error');
            }
        } else {
            return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }
    }

    function postReview(Request $request) {

        // $rules = $this->validateForm();
        $id = $request->input('id');
        $Travelling = Mytravelling::findOrFail($id);

        // make validation depend on want_visa
        $rules = array(
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            //  $id = $this->model->insertRow2($data, $request->input('id'));
            // update current travelling made by admin (mayar)
            $Travelling->admin_notes = $request->input('admin_notes');
            $Travelling->save();


            $subject = "Congratulation your travelling is approved by all roles";
            $link = "mytravelling/show/" . $id;
            \SiteHelpers::addNotification(\Auth::user()->id, $Travelling->employee_id, $subject, $link);

            // send SMS TO requester
            $Employee = User::where('id', $Travelling->employee_id)->first();
            $phone = $Employee->phone_number;
            $this->send_sms($phone,$subject,$link);

            $return = 'mytravelling';

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.request sented to CEO'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('travelling')->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    // only access user can view this page
    function checkAdmin($accessUser) {
        $currentUserId = \Auth::user()->id;
        if ($currentUserId == $accessUser) {
            return true;
        } else {
            return FALSE;
        }
    }

    // start our new project by git
    // CEO make approve to tavelling
    function getScalated() {
        date_default_timezone_set("Africa/Cairo");
        $this->managerEscalation();
        $this->adminEscalation();
        $this->cfoEscalation();

      //  $this->sendMail('HR System Escalation',  'emad@ivas.com.eg');

    }

    function managerEscalation() {
        // manager Escalation  [ created from 2 hours BUT no decision from direct manager ]
        $travellings = Mytravelling::where('want_visa', '=', 1)->where('end_escalation', '=', 0)->where('manager_escalated', '=', 0)->where('manager_approved', '=', 2)->where('created_at', '<=', date("Y-m-d H:i:s", time() - 7200))->get();
        if (!$travellings->isEmpty()) {
            foreach ($travellings as $travelling) {
                $travelling->manager_escalated = 1;
                $travelling->save();


                $manger = User::where('id', $travelling->manager_id)->first();
                $subject = "New Escalation in manager  " . $manger->first_name . " " . $manger->last_name . " to not take decision to this travelling before 2 hours";
                $link = 'mytravelling/admin/' . $travelling->id;
                \SiteHelpers::addNotification(1, ADMIN_USER_ID, $subject, $link);

                // send SMS TO Admin
                $Admin = User::where('id', ADMIN_USER_ID)->first();
                $phone = $Admin->phone_number;
                $this->send_sms($phone,$subject,$link);

            }

          //  echo "Escalated manager" . "<br/>";t
             $this->sendMail( $subject . ' Check at: ' . url($link) ."  at",  'emad@ivas.com.eg');
        }
    }

    function adminEscalation() {
        // escalate 2 level  [ created from 4 hours  and manager take decision BUT no decision from admin  ]
        $travellings = Mytravelling::where('want_visa', '=', 1)->where('end_escalation', '=', 0)->where('admin_escalated', '=', 0)->whereNull('total_cost')->where('created_at', '<=', date("Y-m-d H:i:s", time() - 14400))->get();  // 4  hours
        if (!$travellings->isEmpty()) {
            foreach ($travellings as $travelling) {
                $travelling->admin_escalated = 1;
                $travelling->save();

                $admin = User::find(ADMIN_USER_ID);
                $subject = "New Escalation in our admin " . $admin->first_name . " " . $admin->last_name . " to not decision  to this travelling  before 2 hours";
                $link = 'mytravelling/cfo/' . $travelling->id;
                \SiteHelpers::addNotification(1, CFO_USER_ID, $subject, $link);

                // send SMS TO CFO
                $CFO = User::where('id', CFO_USER_ID)->first();
                $phone = $CFO->phone_number;
                $this->send_sms($phone,$subject,$link);

                // send SMS TO CFO Backup
                $CFOBackup = User::where('id', CFO_BACKUP_ID)->first();
                $phone = $CFOBackup->phone_number;
                $this->send_sms($phone,$subject,$link);

            }
            // echo "Escalated admin" . "<br/>";
             $this->sendMail($subject . ' Check at: ' . url($link),  'emad@ivas.com.eg');
        }
    }

    function cfoEscalation() {
        //Escalate CFO after 6 hours  [ created after  6 hours and manager/admin take decision BUT CFO not take yet ]
        $travellings = Mytravelling::where('want_visa', '=', 1)->where('end_escalation', '=', 0)->where('cfo_escalated', '=', 0)->where('cfo_approve', '=', 2)->where('created_at', '<=', date("Y-m-d H:i:s", time() - 21600))->get();  // 6  hours
        if (!$travellings->isEmpty()) {
            foreach ($travellings as $travelling) {
                $travelling->cfo_escalated = 1;
                $travelling->end_escalation = 1;
                $travelling->save();

                $cfo = User::find(CFO_USER_ID);
                $subject = "New Escalation in our CFO " . $cfo->first_name . " " . $cfo->last_name . " to not take finance decision  to this travelling  before 2 hours";
                $link = 'mytravelling/ceo/' . $travelling->id;
                \SiteHelpers::addNotification(1, CEO_USER_ID, $subject, $link);
                // send SMS
                $CEO = User::where('id', CEO_USER_ID)->first();
                $phone = $CEO->phone_number;
                $this->send_sms($phone,$subject,$link);
            }
              // echo "Escalated cfo" . "<br/>";
             $this->sendMail($subject . ' Check at: ' . url($link),  'emad@ivas.com.eg');

        }
    }


    public function sendMail($subject, $email, $Message = NULL) {
        date_default_timezone_set("Africa/Cairo");
        // send mail
        $message = '<!DOCTYPE html>
					<html lang="en-US">
						<head>
							<meta charset="utf-8">
						</head>
						<body>
							<h2>' . $subject . '</h2>
							<h2> Time :  ' . date("Y-m-d H:i:s") . '</h2>



						</body>
					</html>';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:  ' . $email;
        @mail($email, $subject, $message, $headers);

    }

}
