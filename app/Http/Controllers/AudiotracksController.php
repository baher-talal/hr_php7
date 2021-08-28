<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Audiotracks;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;
use GetId3;
use GetId3_lib;

class AudiotracksController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();
	public $module = 'audiotracks';
	static $per_page	= '10';

	public function __construct()
	{

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Audiotracks();

		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);

		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'audiotracks',
			'return'	=> self::returnUrl()

		);

	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query
		// Filter Search for query
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query
		$results = $this->model->getRows( $params );

		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
		$pagination->setPath('audiotracks');

		$this->data['rowData']		= $results['rows'];
		// Build Pagination
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();
		// Row grid Number
		$this->data['i']			= ($page * $params['limit'])- $params['limit'];
		// Grid Configuration
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any

		// Master detail link if any
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
		// Render into template
		return view('audiotracks.index',$this->data);
	}



	function getUpdate(Request $request, $id = null)
	{

		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('0','error');
		}

		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('audio_tracks');
		}


		$this->data['id'] = $id;
		return view('audiotracks.form',$this->data);
	}

	public function getShow( $id = null)
	{

		if($this->access['is_detail'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');

		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('audio_tracks');
		}


        $operator = $row->operators_id;
		$metadata = \DB::table('audio_tracks')->where('operators_id', $operator)->get();
        $this->data['metadata'] = $metadata;

		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		return view('audiotracks.view',$this->data);
	}

	function postSave( Request $request)
	{

		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost('tb_audiotracks');


			$acceptAudioTypes = array('wav', 'mp3'); // Media formats.
			if(!is_null($request->file('sound_path'))) {
				if(!in_array($request->file('sound_path')->getClientOriginalExtension(), $acceptAudioTypes)) {
					return Redirect::to('audiotracks/update/'.$request->input('id'))->with('messagetext',\Lang::get('Audio File (WAV - MP3) formats only allowed files!'))->with('msgstatus','error')
					->withErrors($validator)->withInput();
				}

		


                // Operator GetID3
                $currentOperator = $data['operators_id'];
				$sampleOperatorTrack = \DB::table('get_audio_details')->where('operators_id', $currentOperator)->first();
                require_once('getID3/getid3/getid3.php');
                $getID3 = new getID3;
				
				// ***
            	$filename = 'uploads/media/' .$sampleOperatorTrack->track_sample_path;
                $ThisFileInfoSampleOfOperator = $getID3->analyze($filename);
                getid3_lib::CopyTagsToComments($ThisFileInfoSampleOfOperator);
                $this->data['ThisFileInfoSampleOfOperator'] = $ThisFileInfoSampleOfOperator;


                // Current Track
                $currentFilename = 'uploads/media/' . $data['sound_path'];
                $ThisFileInfoCurrentSound = $getID3->analyze($currentFilename);
                getid3_lib::CopyTagsToComments($ThisFileInfoCurrentSound);
                $this->data['ThisFileInfoCurrentSound'] = $ThisFileInfoCurrentSound;

            		$data['sound_meta_data'] = strtoupper($ThisFileInfoCurrentSound['fileformat']) .
                ' / ' . $ThisFileInfoCurrentSound['audio']['sample_rate'] . ' Hz ' .
                ' / ' . (($ThisFileInfoCurrentSound['fileformat'] != 'mp3') ? $ThisFileInfoCurrentSound['audio']['bits_per_sample'] . ' Bit ' : '') .

                ' / ' . round($ThisFileInfoCurrentSound['audio']['bitrate'] / 1000).' Kbps' .
                ' / ' . $ThisFileInfoCurrentSound['audio']['channelmode'] .
                ' / ' . (($ThisFileInfoCurrentSound['fileformat'] != 'mp3') ? $ThisFileInfoCurrentSound['audio']['codec'] : '') .
                ' / ' . floor($ThisFileInfoCurrentSound['playtime_seconds'] / 3600) . gmdate(":i:s", $ThisFileInfoCurrentSound['playtime_seconds'] % 3600);


			



// Start Comparison

            // Format Comparison.
            if($ThisFileInfoCurrentSound['fileformat'] == $ThisFileInfoSampleOfOperator['fileformat']) {
                $return = 'audiotracks/update/'.$request->input('id').'?return='.self::returnUrl();
            } else {
                return Redirect::to('audiotracks/update/'.$request->input('id'))->with('messagetext',\Lang::get('Please change the format to: ' .$ThisFileInfoSampleOfOperator['fileformat']))->with('msgstatus','error')
                    ->withErrors($validator)->withInput();
            }

            // Sample rate comparison.
            if($ThisFileInfoCurrentSound['audio']['sample_rate'] == $ThisFileInfoSampleOfOperator['audio']['sample_rate']) {
                $return = 'audiotracks/update/'.$request->input('id').'?return='.self::returnUrl();
            } else {
                return Redirect::to('audiotracks/update/'.$id)->with('messagetext',\Lang::get('Please change the sample rate to: ' .$ThisFileInfoSampleOfOperator['audio']['sample_rate'] . ' Hz'))->with('msgstatus','error')
                    ->withErrors($validator)->withInput();
            }

            // Bit rate comparison.
            if($ThisFileInfoCurrentSound['audio']['bitrate'] == $ThisFileInfoSampleOfOperator['audio']['bitrate']) {
                $return = 'audiotracks/update/'.$request->input('id').'?return='.self::returnUrl();
            } else {
                return Redirect::to('audiotracks/update/'.$request->input('id'))->with('messagetext',\Lang::get('Please change the bit rate to: ' .$ThisFileInfoSampleOfOperator['audio']['bitrate'] . ' Kbps'))->with('msgstatus','error')
                    ->withErrors($validator)->withInput();
            }

            // Channels comparison.
            if($ThisFileInfoCurrentSound['audio']['channelmode'] == $ThisFileInfoSampleOfOperator['audio']['channelmode']) {
                $return = 'audiotracks/update/'.$request->input('id').'?return='.self::returnUrl();
            } else {
                return Redirect::to('audiotracks/update/'.$request->input('id'))->with('messagetext',\Lang::get('Please change the channel mode to: ' .$ThisFileInfoSampleOfOperator['audio']['channelmode'] . ' Kbps'))->with('msgstatus','error')
                    ->withErrors($validator)->withInput();
            }

            // Resolution comparison.
            if($ThisFileInfoCurrentSound['audio']['bits_per_sample'] == $ThisFileInfoSampleOfOperator['audio']['bits_per_sample']) {
                $return = 'audiotracks/update/'.$request->input('id').'?return='.self::returnUrl();
            } else {
                return Redirect::to('audiotracks/update/'.$request->input('id'))->with('messagetext',\Lang::get('Please change the resolution to: ' . (($ThisFileInfoSampleOfOperator['fileformat'] != 'mp3') ? $ThisFileInfoSampleOfOperator['audio']['bits_per_sample'] . ' Bit ' : '')))->with('msgstatus','error')
                    ->withErrors($validator)->withInput();
            }

            // Codecs comparison.
            if($ThisFileInfoCurrentSound['audio']['codec'] == $ThisFileInfoSampleOfOperator['audio']['codec']) {
                $return = 'audiotracks/update/'.$request->input('id').'?return='.self::returnUrl();
            } else {
                return Redirect::to('audiotracks/update/'.$request->input('id'))->with('messagetext',\Lang::get('Please change the channel mode to: ' . (($ThisFileInfoSampleOfOperator['fileformat'] != 'mp3') ? $ThisFileInfoSampleOfOperator['audio']['codec'] : '')))->with('msgstatus','error')
                    ->withErrors($validator)->withInput();
            }


// End Comparison

}





            $id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->input('apply')))
			{
				$return = 'audiotracks/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'audiotracks?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');

		} else {

			return Redirect::to('audiotracks/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}

	}

	public function postDelete( Request $request)
	{

		if($this->access['is_remove'] ==0)
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows
		if(count($request->input('id')) >=1)
		{
			$this->model->destroy($request->input('id'));

			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('id'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('audiotracks')
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');

		} else {
			return Redirect::to('audiotracks')
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}

	}


}
