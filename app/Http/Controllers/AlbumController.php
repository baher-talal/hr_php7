<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect;
use Excel;
use App\Models\Track;
use Auth;
use File;

class AlbumController extends Controller
{ // no change

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'album';
    static $per_page = '10';

    public function __construct()
    {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Album();

        $this->info = $this->model->makeInfo($this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'album',
            'return' => self::returnUrl()

        );

    }

    public function getIndex(Request $request)
    {

        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
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
        $pagination->setPath('album');

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
        return view('album.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_albums');
        }


        $this->data['id'] = $id;
        return view('album.form', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_albums');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('album.view', $this->data);
    }

    function postSave(Request $request)
    {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_albums');

            $id = $this->model->insertRow2($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'album/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'album?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');

        } else {

            return Redirect::to('album/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
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
            foreach ($request->input('id') as $id) {
                $album = Album::findOrfail($id);
                foreach ($album->tracks as $track) {
                    if ($track->track_path && File::exists($track->track_path)) {
                        File::delete($track->track_path);
                    }

                    if (File::exists('uploads/etisalat_upload/' . $album->name . '.zip')) {
                        File::delete('uploads/etisalat_upload/' . $album->name . '.zip');
                    }
                }
            }
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('album')
                ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');

        } else {
            return Redirect::to('album')
                ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }

    }

    public function excel()
    {

        return view('album.excel', $this->data);
    }


    public function excelStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excelFile' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $content = array('Single' => array());
        $file = $request->file('excelFile');
        $filename = time().'_'.$file->getClientOriginalName();
        if(!$file->move(base_path().'/uploads/etisalat_upload/excel',  $filename) ){
            return back()->with(['message' => \SiteHelpers::alert('error', 'Failed To Move File')]);
        }
        Excel::filter('chunk')->load(base_path().'/uploads/etisalat_upload/excel/'.$filename)->chunk(250, function ($results) use ($content) {

         //   print_r($results);die;

            foreach ($results as $row) {
                if (isset($row->album) && $row->album != NULL) {  // fix empty rows on excel
                    $album = $row->album;
                    if (array_key_exists($album, $content)) {
                        array_push($content[$album], $row);
                    } else {
                        $content[$album] = array();
                        array_push($content[$album], $row);
                    }
                }


            }



            foreach ($content as $key => $values) {
                if (isset($values[0]->artist_name_english) && $values[0]->artist_name_english != NULL) {
                    $album = new Album();
                    $album->name = $key;
                    $album->artist = $values[0]->artist_name_english;
                    $album->save();
                    if ($album->name == 'Single') {
                        $album->name .= '_' . $album->id;
                        $album->artist = 'Single';
                        $album->save();
                    }
                }


                foreach ($values as $value) {
                    // remove valiadtion for arabic and english
                    /*
                    if (preg_match("/[a-z]/i", $value->rbt_name_arabic) || preg_match("/[a-z]/i", $value->artist_name_arabic) || preg_match("/\p{Arabic}/u", $value->artist_name_english) || preg_match("/\p{Arabic}/u", $value->rbt_name_english)) {
                        continue;
                    }
                    */
                    $track = new Track();
                    $track->album_id = $album->id;
                    $track->web_audition_preview = preg_replace('/\s+/', '', $value->rbt_name_english) . '.wav';
                    $track->aip_play_rbt = preg_replace('/\s+/', '', $value->rbt_name_english) . '.wav';
                    $track->wap_audition_rbt = preg_replace('/\s+/', '', $value->rbt_name_english) . '.wav';
                    $track->language_prompt_rbt = preg_replace('/\s+/', '', $value->rbt_name_english) . '.wav';
                    $track->rbt_name = $value->rbt_name_english;
                    $track->initial_rbt_name = $value->rbt_name_english[0];
                    $track->singer_name = $value->artist_name_english;
                    $track->initial_singer_name = $value->artist_name_english[0];
                    if ($value->gender == 'Male') {
                        $track->singer_gender = 1;
                    } elseif ($value->gender == 'Female') {
                        $track->singer_gender = 2;
                    } else {
                        $track->singer_gender = -1;
                    }
                    $track->value_of_category = $value->category;
                    $track->rbt_information = '';
                    $track->rbt_price = 5;
                    $track->validity_period_rbt = '2030-12-09';
                    $track->language_code = 3;
                    $track->relative_expiry_rbt = 30;
                    $track->allowed_cut = 0;
                    $track->movie_name = '';
                    $track->sub_cp_id = '';
                    $track->price_group_id = 10001;
                    $track->company_lyrics = '';
                    $track->dt_lyrics = '';
                    $track->company_id_tune = '';
                    $track->date_tune = '2030-12-09';
                    $track->company_id = '';
                    $track->validity_date = '';
                    $track->allowed_channels = 'ALL';
                    $track->renew_allowed = 1;
                    $track->max_download_times = '';
                    $track->multiple_language_code = 4;
                    $track->rbt_name_ml = $value->rbt_name_arabic;
                    $track->singer_name_ml = $value->artist_name_arabic;
                    $track->entry_by = Auth::user()->id;
                    $track->track_path = 'uploads/etisalat_upload/' . date('Y-m-d') . '/' . preg_replace('/\s+/', '', $value->rbt_name_english) . '.wav';
                    $track->save();
                }
            }
        });
        $request->session()->flash('success', 'Inserted Successfull');
        return redirect('album');
    }

    public function downloadSample()
    {
        $file = base_path() . "/etisalat_upload/uploading_sample_file.xlsx";

        $headers = array(
            'Content-Type: application/xlsx',
        );
        return response()->download($file, 'Etisalat sample data.xlsx', $headers);
    }
}
