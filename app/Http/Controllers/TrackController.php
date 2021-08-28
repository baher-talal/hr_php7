<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
Input,Lang,
Redirect;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use League\Flysystem\Util\MimeType;
use ZipArchive ;
class TrackController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'track';
    static $per_page = '50';

    public function __construct() {

        //$this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Track();

        $this->info = $this->model->makeInfo($this->module);

        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'track',
            'return' => self::returnUrl()
            );
    }

    public function getIndex(Request $request) {

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
        $pagination->setPath('tracks');

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
        return view('track.index', $this->data);
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
            $this->data['row'] = $this->model->getColumnTable('tb_tracks');
        }


        $this->data['id'] = $id;
        return view('track.form', $this->data);
    }

    function getUpdate2(Request $request, $id = null) {


        // empty file
        $filename = "tracks.inf"; //the name of our file.
        //  File::delete(public_path($filename));

        $new_data = "";
        $filename = "tracks.inf"; //the name of our file.
        $strlength = strlen($new_data); //gets the length of our $content string.
        $create = fopen(public_path($filename), "w"); //uses fopen to create our file.
        $write = fwrite($create, $new_data, $strlength); //writes our string to our file.
        $close = fclose($create); //closes our file





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
            $this->data['row'] = $this->model->getColumnTable('tb_tracks');
        }


        $this->data['id'] = $id;
        return view('track.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
        ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('tb_tracks');
        }

        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('track.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_tracks');
            if ($request->hasFile('track_path')) {
                $ext = $request->file('track_path')->getClientOriginalExtension();
                if ($ext == 'wav' || $ext == 'mp3') {
                    if ($request->input('id')) {
                        $track = Track::find($request->input('id'));
                        if ($track->track_path) {
                            $track_path = $track->track_path;
                            $track_path = explode('/', $track_path);  // ex:   uploads/2017-08-27/TarktoHaway.wav
                            $track_path = $track_path[0] . '/' . $track_path[1];
                            \File::delete($track->track_path);
                            $path = $request->file('track_path')->move($track_path, $track->web_audition_preview);
                            $data['track_path'] = $path;
                        } else {
                            $track_path = 'uploads/etisalat_upload/' . explode(' ', $track->created_at)[0];
                            $path = $request->file('track_path')->move($track_path, $track->web_audition_preview);
                            $data['track_path'] = $path;
                        }
                    } else {
                        $track_path = 'uploads/etisalat_upload/' . date('Y-m-d') . '/';
                        $path = $request->file('track_path')->move($track_path, $data['web_audition_preview']);
                        $data['track_path'] = $path;
                    }
                } else {
                    $request->session()->flash('failed', 'File must be audio');
                    return back();
                }
            }
            $id = $this->model->insertRow2($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'track/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'track?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::back()->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
            ->withErrors($validator)->withInput();
        }
    }

    public function postDelete(Request $request) {
        //  echo "delete" ; die;
        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
        ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::back()
            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::back()
            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    function getDownloadfile() {
        $filename = "tracks.inf";
        return response()->download(public_path($filename));
    }

    function getDownloadinf_old(Request $request) {

        $today = date("Y-m-d");

        // excel download
        if ($this->access['is_excel'] == 0)
            return Redirect::to('')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        ;
        $info = $this->model->makeInfo($this->module);

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        if ($this->module == "groups") {
            $sort = "group_id";
        }
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


        $page = "";  // to get all result as this   $page = $request->input('page', 1); get result from first page only
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
        $fields = $info['config']['grid'];
        $rows = $results['rows'];
        $label_arr = array();

        $content = $this->data['pageTitle'];

        $string = '#|';
        $new_data = "";
        $arr2 = array();
        $arr3 = array();


        foreach ($rows as $row) {
            $arr2['web_audition_preview'] = $row->web_audition_preview;
            $arr2['aip_play_rbt'] = $row->aip_play_rbt;
            $arr2['wap_audition_rbt'] = $row->wap_audition_rbt;
            $arr2['rbt_name'] = $row->rbt_name;
            $arr2['initial_rbt_name'] = $row->initial_rbt_name;
            $arr2['singer_name'] = $row->singer_name;
            $arr2['initial_singer_name'] = $row->initial_singer_name;
            $arr2['singer_gender'] = $row->singer_gender;
            $arr2['value_of_category'] = $row->value_of_category;
            $arr2['rbt_information'] = $row->rbt_information;
            $arr2['rbt_price'] = $row->rbt_price;
            $arr2['validity_period_rbt'] = $row->validity_period_rbt;
            $arr2['language_code'] = $row->language_code;
            $arr2['relative_expiry_rbt'] = $row->relative_expiry_rbt;
            $arr2['language_prompt_rbt'] = $row->language_prompt_rbt;
            $arr2['allowed_cut'] = $row->allowed_cut;
            $arr2['movie_name'] = $row->movie_name;
            $arr2['sub_cp_id'] = $row->sub_cp_id;
            $arr2['price_group_id'] = $row->price_group_id;
            $arr2['company_lyrics'] = $row->company_lyrics;
            $arr2['dt_lyrics'] = $row->dt_lyrics;
            $arr2['company_id_tune'] = $row->company_id_tune;
            $arr2['date_tune'] = $row->date_tune;
            $arr2['company_id'] = $row->company_id;
            $arr2['validity_date'] = $row->validity_date;
            $arr2['allowed_channels'] = $row->allowed_channels;
            $arr2['renew_allowed'] = $row->renew_allowed;
            $arr2['max_download_times'] = $row->max_download_times;
            $arr2['multiple_language_code'] = $row->multiple_language_code;
            $arr2['rbt_name_ml'] = $row->rbt_name_ml;
            $arr2['singer_name_ml'] = $row->singer_name_ml;

            $arr3[] = $arr2;


            $albumId = $row->album_id;
            $Album = Album::findOrFail($albumId);

            //     $new_data .= $string . implode($string, $arr2) . PHP_EOL ;  // work good in windows
            $new_data .= $string . implode($string, $arr2) . "\r\n";     // work good in linux
        }

        // append
        $filename = $Album->name . ".inf"; //the name of our file.
        $strlength = strlen($new_data); //gets the length of our $content string.
        $create = fopen(public_path($filename), "wb"); //uses fopen to create our file.
        $write = fwrite($create, $new_data, $strlength); //writes our string to our file.
        $close = fclose($create); //closes our file

        return response()->download(public_path($filename));
    }

    function postDownloadinf(Request $request) {

        if ($request->has('id')) {

            $ids_arr = $request->input('id');
            $today = date("Y-m-d");
            $string = '#|';
            $new_data = "";
            $arr2 = array();
            $arr3 = array();

            /*
            $tracks = \DB::table('tb_tracks')
                ->whereIn('album_id', $ids_arr)->orderBy('id', 'desc')
                ->get();
            */

            if ($request->input('albumId') !== NULL) { // download selected album tracks
                $tracks = \DB::table('tb_tracks')
                ->where('album_id', $request->input('albumId')) ->whereIn('id',$ids_arr)->orderBy('id', 'desc')
                ->get();
            } else { // download mutli albums
                $tracks = \DB::table('tb_tracks')
                ->whereIn('album_id', $ids_arr)->orderBy('id', 'desc')
                ->get();
            }

            foreach ($tracks as $row) {
                $arr2['web_audition_preview'] = $row->web_audition_preview;
                $arr2['aip_play_rbt'] = $row->aip_play_rbt;
                $arr2['wap_audition_rbt'] = $row->wap_audition_rbt;
                $arr2['rbt_name'] = $row->rbt_name;
                $arr2['initial_rbt_name'] = $row->initial_rbt_name;
                $arr2['singer_name'] = $row->singer_name;
                $arr2['initial_singer_name'] = $row->initial_singer_name;
                $arr2['singer_gender'] = $row->singer_gender;
                $arr2['value_of_category'] = $row->value_of_category;
                $arr2['rbt_information'] = $row->rbt_information;
                $arr2['rbt_price'] = $row->rbt_price;
                $arr2['validity_period_rbt'] = $row->validity_period_rbt;
                $arr2['language_code'] = $row->language_code;
                $arr2['relative_expiry_rbt'] = $row->relative_expiry_rbt;
            //    $arr2['language_prompt_rbt'] = $row->language_prompt_rbt;  // removed
                $arr2['allowed_cut'] = $row->allowed_cut;
              //  $arr2['movie_name'] = $row->movie_name;  // removed
             //    $arr2['sub_cp_id'] = $row->sub_cp_id;  // removed
                $arr2['price_group_id'] = $row->price_group_id;
                $arr2['company_lyrics'] = $row->company_lyrics;
               // $arr2['dt_lyrics'] = $row->dt_lyrics;  // removed
              //  $arr2['company_id_tune'] = $row->company_id_tune;  // removed
              //  $arr2['date_tune'] = $row->date_tune;  // removed
              //  $arr2['company_id'] = $row->company_id;  // removed
                // $arr2['validity_date'] = $row->validity_date;  // removed
                $arr2['allowed_channels'] = $row->allowed_channels;
                $arr2['renew_allowed'] = $row->renew_allowed;
                $arr2['max_download_times'] = $row->max_download_times;
                $arr2['multiple_language_code'] = $row->multiple_language_code;
                $arr2['rbt_name_ml'] = $row->rbt_name_ml;
                $arr2['singer_name_ml'] = $row->singer_name_ml;

                $arr3[] = $arr2;

                $albumId = $row->album_id;
                $Album = Album::findOrFail($albumId);

                //     $new_data .= $string . implode($string, $arr2) . PHP_EOL ;  // work good in windows
                $new_data .= $string . implode($string, $arr2) . "\r\n";     // work good in linux
            }

            // echo $new_data ; die;
            // append
            $filename = "file.inf"; //the name of our file.
            $strlength = strlen($new_data); //gets the length of our $content string.
            $create = fopen(public_path($filename), "wb"); //uses fopen to create our file.
            $write = fwrite($create, $new_data, $strlength); //writes our string to our file.
            $close = fclose($create); //closes our file
            // $files = glob('uploads/2017-08-09/*');
            // dd($files);
            $files = array();
            //array_push($files, public_path($filename));
            foreach ($tracks as $track) {
                if ($track->track_path && \File::exists($track->track_path)) {
                    array_push($files, $track->track_path);
                }
            }

            if (\File::exists('uploads/etisalat_upload/albums_' . date('Y-m-d') . '.zip')) {
                \File::delete('uploads/etisalat_upload/albums_' . date('Y-m-d') . '.zip');
            }

            if (\File::exists('uploads/etisalat_upload/tracks_' . date('Y-m-d') . '.zip')) {
                \File::delete('uploads/etisalat_upload/tracks_' . date('Y-m-d') . '.zip');
            }

            // the old cpmpress
            //   \Zipper::make('uploads/' . $Album->name . '_' . date('Y-m-d') . '.zip')->add(public_path($filename))->add($files)->close();

            //    $album_tracks =    \Zipper::make('uploads/' . $Album->name . '_' . date('Y-m-d') . '.zip')->add(public_path($filename))->add($files)->close();
            //      $inf_file  = \Zipper::make('uploads/' . $Album->name. '.zip')->add(public_path($filename))->close();

            $zip = new ZipArchive();
            $zip_tracks = 'uploads/etisalat_upload/tracks_' . date('Y-m-d').".zip"; // Zip name
            $zip->open($zip_tracks,  ZipArchive::CREATE);
            foreach ($files as $file) {
               // echo $path = "upload/".$file;
                if(file_exists($file)){
                    $zip->addFromString(basename($file),  file_get_contents($file));
                }
                else{
                    echo"file does not exist";
                }
            }
            $zip->close();

            $zip = new ZipArchive();
            $zip_album = 'uploads/etisalat_upload/tracks_'. date('Y-m-d').".zip"; // Zip name
            $zip->open($zip_album,  ZipArchive::CREATE);

                // echo $path = "upload/".$file;
            if(file_exists(public_path($filename))){
                $zip->addFromString(basename(public_path($filename)),  file_get_contents(public_path($filename)));
            }

            if(file_exists(public_path($zip_tracks))){
                $zip->addFromString(basename(public_path($zip_tracks)),  file_get_contents(public_path($zip_tracks)));
            }

            $zip->close();

            return response()->download('uploads/etisalat_upload/tracks_'. date('Y-m-d') . '.zip');
            // return response()->download(public_path($filename));
        } else {
            return Redirect::back()
            ->with('messagetext', 'No Albums Selected')->with('msgstatus', 'error');
        }
    }

    public function tracks() {
        return view('track.tracks', $this->data);
    }

    public function tracksStore(Request $request) {
        if (!file_exists('uploads/etisalat_upload/' . date('Y-m-d') . '/')) {
            mkdir('uploads/etisalat_upload/' . date('Y-m-d') . '/', 0777, true);
        }
        $vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
        $vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file name
        $vpb_file_size = $_FILES['upload_file']['size']; // File Size
        $vpb_uploaded_files_location = 'uploads/etisalat_upload/' . date('Y-m-d') . '/'; //This is the directory where uploaded files are saved on your server

        if(strpos($vpb_file_name,'_') !== false ){
            $vpb_final_location = $vpb_uploaded_files_location . explode('_', $vpb_file_name)[1]; //Directory to save file plus the file to be saved
        }else{
            $vpb_final_location = $vpb_uploaded_files_location . $vpb_file_name; //Directory to save file plus the file to be saved
        }

        //Without Validation and does not save filenames in the database
        if (move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)) {
            //Display the file id
            echo $vpb_file_id;
        } else {
            //Display general system error
            echo 'general_system_error';
        }
    }

}
