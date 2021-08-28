<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vacations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang;

class VacationsController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'vacations';
    static $per_page = '10';

    public function __construct() {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Vacations();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {

            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });
        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'vacations',
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
        $pagination->setPath('vacations');

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
        return view('vacations.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_vacations');
        }


        $this->data['id'] = $id;
        return view('vacations.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $MyVacation = Vacations::where('id', '=', $id)->first();
        if ($MyVacation === NULL) {
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.page_not_found'))->with('msgstatus', 'error');
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_vacations');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('vacations.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_vacations');

            // send notification to employee  if there is reason
            $user = User::find(\Auth::user()->id);
            $vacation = \DB::table('tb_vacations')->where('id', $request->input('id'))->first();
            $Employee = User::where('id', $vacation->employee_id)->first();

            if ($Employee->annual_credit == 0) {
                return Redirect::to('dashboard')
                                ->with('messagetext', \Lang::get($Employee->first_name . ' ' . $Employee->last_name . ' has finished all his vacations !'))->with('msgstatus', 'error');
            } elseif ($Employee->annual_credit - $vacation->peroid < 0) {
                return Redirect::to('dashboard')
                                ->with('messagetext', \Lang::get($Employee->first_name . ' ' . $Employee->last_name . ' request vacations days greater than his credit !'))->with('msgstatus', 'error');
            }

            $id = $this->model->updateVacation($data, $request->input('id'));

            if ($data["manager_approved"] == 0) { // manager not approved
                $subject = "Your vacation is refused";
                if (strlen(trim($data["manager_reason"])) != 0) {  // there is reason for refuse
                    $subject .= " due to : " . $data["manager_reason"];
                }
            } elseif ($data["manager_approved"] == 1) { // if hr is approve then send notification to manager
                $subject = "Your vacation is approved ";
                // update annual_credit for that employee
                $Employee->annual_credit -= $vacation->peroid;
                $Employee->save();
            }

            $link = 'myvacations/show/' . $id;

            \SiteHelpers::addNotification(\Auth::user()->id, $vacation->employee_id, $subject, $link);  //  notification to employee under current manager

              $Employee = User::where('id', $vacation->employee_id)->first();

             // send SMS
               $phone = $Employee->phone_number;
               $this->send_sms($phone,$subject, $link);

            if (!is_null($request->input('apply'))) {
                $return = 'vacations/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'vacations?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('vacations/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    public function postDelete(Request $request) {

        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows
        //  print_r($request->input('id')); die;
        if (count($request->input('id')) >= 1) {

            // if remove vacation increase employee credit
            foreach ($request->input('id') as $id) {
                $vacation = \DB::table('tb_vacations')->where('id', $id)->first();
                $Employee = User::where('id', $vacation->employee_id)->first();
                if ($vacation->manager_approved == 1) { // previous approve
                    // update annual_credit for that employee
                    $Employee->annual_credit += $vacation->peroid;
                    $Employee->save();
                }
            }

            $this->model->destroy($request->input('id'));


            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('vacations')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('vacations')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

}
