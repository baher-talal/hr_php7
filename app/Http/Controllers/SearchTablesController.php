<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Vacations;
use Redirect,Lang;

class SearchTablesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        return view('searchTables.form');
    }

// do serach
    public function search(Request $request) {

        $from = Carbon::createFromFormat('d/m/Y', $request->start)->toDateString();
        $to = Carbon::createFromFormat('d/m/Y', $request->end)->toDateString();
        $table = $request->TableName;
        $Data = DB::table($table)->whereBetween('date', [$from, $to])->paginate(25);
        $this->data['requestInput'] = request()->input();
        $this->data['Data'] = $Data->appends($this->data['requestInput']);
        if ($table == 'tb_travellings')
            $module = rtrim(str_replace("tb_", "", $table), 's');
        else
            $module = str_replace("tb_", "", $table);
        $this->model = new Vacations();
        $info = $this->model->makeInfo($module);

        $this->data['tableGrid'] = $info['config']['grid'];
        $this->data['access'] = $this->model->validAccess($info['id']);
        $this->data['pageTitle'] = $module;


       // print_r($this->data) ; die;

        return view('searchTables.index', $this->data);
    }

    function download(Request $request) {

        $from = Carbon::createFromFormat('d/m/Y', $request->start)->toDateString();
        $to = Carbon::createFromFormat('d/m/Y', $request->end)->toDateString();
        $table = $request->TableName;
        $Data = DB::table($table)->whereBetween('date', [$from, $to])->get();
        if ($table == 'tb_travellings')
            $module = rtrim(str_replace("tb_", "", $table), 's');
        else
            $module = str_replace("tb_", "", $table);
        $this->model = new Vacations();
        $info = $this->model->makeInfo($module);
        $tableGrid = $info['config']['grid'];
        $access = $this->model->validAccess($info['id']);

        if ($access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $arr2 = array();

        foreach ($Data as $row) {
            foreach ($tableGrid as $f) {
                $x = $f['field'];
                if ($f['download'] == '1') {
                    // fix 0 , 1 for manager_approved to be read as No , Yes
                    if ($x == 'manager_approved' && $row->$x === 1) {
                        $row->$x = 'Yes';
                    } elseif ($x == 'manager_approved' && $row->$x === 0) {
                        $row->$x = 'No';
                    }

                    $conn = (isset($f['conn']) ? $f['conn'] : array() );
                    $arr2[$f['label']] = \SiteHelpers::gridDisplay($row->$x, $x, $conn);
                    // }
                }
            }
            $arr3[] = $arr2;
        }
        if (isset($arr3) && count($arr3) > 0) {
            \Excel::create($module . ' From Date ' . $request->start . ' To Date ' . $request->end, function($excel)use($request,$module, $from, $to, $arr3) {

                $excel->sheet($module . '_' . date("d-m-Y"), function ($sheet) use ($arr3) {
                    $sheet->setOrientation('landscape');
                    $sheet->fromArray($arr3);
                });
            })->download('xlsx');
        } else {
            return Redirect::back()
                            ->with('messagetext', 'There is no data')->with('msgstatus', 'error');
        }
    }

}
