<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Aggregators;
use Validator , Hash , Input , Redirect;
class AggregatorInterfaceController extends Controller
{
    // hanlde login and log out function
    public function get_login_page()
    {
      return view('aggregator_interface.login');
    }
    public function login(Request $request)
    {
      $validator = Validator::make($request->all(), [
                  'email' => 'required',
                  'password' => 'required'
          ]);
      if ($validator->fails()) {
          return back()->withErrors($validator)->withInput();
      }
      $aggregator = Aggregators::where('aggregator_email',$request->email)->first();
      if($aggregator){
        if(Hash::check($request->password, $aggregator->aggregator_password)){
        \Session::set('aggregator',$aggregator);
        return redirect('/aggregator');}
        else{return back()->with(['message' => \SiteHelpers::alert('error', 'There Are An Error In Password')]);}
      }
      else{
        return back()->with(['message' => \SiteHelpers::alert('error', 'Cant find email address')]);
      }
    }
    public function logout()
    {
      \Session::forget('aggregator');
      return redirect('/aggregator');
    }
    public function index()
    {
      return view('aggregator_interface.index');
    }
    //Aggregator rbt function
    public function get_rbts()
    {
        $title = 'Index - rbt';
        $aggregator = \Session::get('aggregator');
        $rbts = \App\Models\Rbt::where('aggregator_id',$aggregator->id)->get();
        return view('aggregator_interface.rbts',compact('rbts','title'));
    }
    public function search_rbt()
    {
        $operators = \App\Models\Operator::all()->pluck('name','id');
        $occasions = \App\Models\Occasions::all()->pluck('occasion_name','id');
        $providers = \App\Models\providers::all()->pluck('provider_name','id') ;
        return view('aggregator_interface.search_rbt',compact('operators','occasions','providers')) ;
    }
    public function search_result_rbt(Request $request)
    {
        $aggregator = \Session::get('aggregator');
        $rbt_columns = \Schema::getColumnListing('rbts');
        $columns = array(1=>"track_title_en",2=>"track_title_ar",3=>"artist_name_en",4=>"artist_name_ar",
            5=>"album_name", 6=>"code",7=>"social_media_code",8=>"owner",9=>"from",10=>"to",11=>"operator_id",12=>"occasion_id",13=>"aggregator_id",14=>"provider_id", 15=>"type");

        $search_key_value = array() ;
        foreach ($request['search_field'] as $index=>$item) {
            if (strlen($item)==0 || !strcmp($item,"undefined"))
                continue ;
            else {
                if ($index==9){
                    $item = date("Y-m-d",strtotime($item));
                    $search_key_value['from'] = $item ;
                }
                elseif($index==10)
                {
                    $item = date("Y-m-d",strtotime($item));
                    $search_key_value['to'] = $item ;
                }
                elseif (array_search($columns[$index],$rbt_columns))
                {
                    $search_key_value[$columns[$index]] = $item ;
                }
            }
        }
        $string_query = "" ;
        $counter = 0 ;
        $size = count($search_key_value) ;
        foreach ($search_key_value as $index=>$value)
        {
            $sign = "=" ;
            if ($index == "to")
            {
                $sign = "<=" ;
                $index = "created_at" ;
            }
            elseif($index=="from")
            {
                $sign = ">=" ;
                $index = "created_at" ;
            }

            $counter++ ;
            if ($counter == $size)
            {
                $string_query .= "`rbts`.`$index`"." $sign '$value'" ;
            }
            else
            {
                $string_query .= "`rbts`.`$index`"." $sign '$value' AND ";
            }
        }

        $select = "SELECT rbts.* , tb_operators.name AS operator_title, providers.provider_name AS provider_title,occasions.occasion_name AS occasion_title, aggregators.aggregator_name AS aggregator_title
                   FROM rbts
                   JOIN providers ON rbts.provider_id = providers.id
                   JOIN aggregators ON rbts.aggregator_id = aggregators.id
                   JOIN tb_operators ON rbts.operator_id = tb_operators.id
                   LEFT JOIN occasions ON rbts.occasion_id = occasions.id" ;



        if (empty($string_query))
            $where = "";
        else
            $where = " WHERE ".$string_query ;

        $select  .=" where aggregators.id=".$aggregator->id;



        $query = $select.$where;
        $search_result = \DB::select($query) ;
        return $search_result ;
    }
    //Aggregator report function
    public function get_reports()
    {
        $title = 'Index - report';
        $aggregator = \Session::get('aggregator');
        $reports = \App\Models\Report::where('aggregator_id',$aggregator->id)->get();
        return view('aggregator_interface.report',compact('reports','title'));
    }
    public function search_report()
    {
      $aggregator = \Session::get('aggregator');
      $operators = \App\Models\Operator::all()->pluck('name','id');
      $providers = \App\Models\providers::all()->pluck('provider_name','id');
      return view('aggregator_interface.search_report',compact('operators','providers')) ;
    }
    public function search_result_report(Request $request)
    {
        $report_columns = \Schema::getColumnListing('reports');
        $columns = array(1=>"year",2=>"month",3=>"classification",4=>"code",
            5=>"rbt_name", 6=>"rbt_id",7=>"download_no",8=>"total_revenue",9=>"revenue_share",10=>"operator_id",11=>"provider_id",13=>"aggregator_id",12=>"from",14=>"to");

        $search_key_value = array() ;
        foreach ($request['search_field'] as $index=>$item) {
            if (strlen($item)==0 || !strcmp($item,"undefined"))
                continue ;
            else {
                if ($index==13){
                    $item = date("Y-m-d",strtotime($item));
                    $search_key_value['from'] = $item ;
                }
                elseif($index==14)
                {
                    $item = date("Y-m-d",strtotime($item));
                    $search_key_value['to'] = $item ;
                }
                elseif (array_search($columns[$index],$report_columns))
                {
                    $search_key_value[$columns[$index]] = $item ;
                }
            }
        }
        $string_query = "" ;
        $counter = 0 ;
        $size = count($search_key_value) ;
        foreach ($search_key_value as $index=>$value)
        {
            $sign = "=" ;
            if ($index == "to")
            {
                $sign = "<=" ;
                $index = "created_at" ;
            }
            elseif($index=="from")
            {
                $sign = ">=" ;
                $index = "created_at" ;
            }

            $counter++ ;
            if ($counter == $size)
            {
                $string_query .= "`reports`.`$index`"." $sign '$value'" ;
            }
            else
            {
                $string_query .= "`reports`.`$index`"." $sign '$value' AND ";
            }
        }
        $select = "SELECT reports.* , tb_operators.name AS operator_title, providers.provider_name AS provider_title, aggregators.aggregator_name AS aggregator_title
                   FROM reports
                   Left JOIN providers ON reports.provider_id = providers.id
                   JOIN aggregators ON reports.aggregator_id = aggregators.id
                   JOIN tb_operators ON reports.operator_id = tb_operators.id " ;
        if (empty($string_query))
            $where = "";
        else
            $where = " WHERE ".$string_query." ORDER BY reports.total_revenue DESC" ;

        $aggregator = \Session::get('aggregator');
        if($where)
      	   $select  .=" And aggregators.id=".$aggregator->id;
        else
           $select  .=" Where aggregators.id=".$aggregator->id;
        $query = $select.$where;
        $search_result = \DB::select($query) ;
        return $search_result ;
    }
    //profile for aggregator
    public function getProfile()
    {
        $info = \Session::get('aggregator');
        // print_r($info); die ;
        $this->data = array(
            'pageTitle' => 'My Profile',
            'pageNote' => 'View Detail My Info',
            'info' => $info,
        );
        return view('aggregator_interface.profile', $this->data);
    }
    public function postSaveprofile(Request $request)
    {
      $aggregator=\Session::get('aggregator');
      $user = \App\Models\aggregators::find($aggregator->id);
      $rules = array(
                  'aggregator_mobile' => 'required|unique:aggregators,aggregator_mobile,' . $user->id
                  );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {


            if (!is_null(Input::file('aggregator_img'))) {
                $file = $request->file('aggregator_img');
                $destinationPath = './uploads/user/';
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension(); //if you need extension of the file
                $newfilename = $user->id.time(). '.' . $extension;
                $uploadSuccess = $request->file('aggregator_img')->move($destinationPath, $newfilename);
                if ($uploadSuccess) {
                    $data['aggregator_img'] = $newfilename;
                }
            }

            $user->aggregator_name = $request->input('aggregator_name');
            $user->aggregator_mobile = $request->input('aggregator_mobile');
            if (isset($data['aggregator_img']))
                $user->aggregator_img = $data['aggregator_img'];
            $user->save();
            \Session::set('aggregator',$user);
            return Redirect::to('aggregator/profile')->with('message',\SiteHelpers::alert('success', 'Profile has been saved!'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('aggregator/profile')->with('message', \SiteHelpers::alert('error', 'The following errors occurred'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }
    public function postSavepassword(Request $request)
    {
        $rules = array(
            'password' => 'required|alpha_num|between:6,20',
            'password_confirmation' => 'required|alpha_num|between:6,20'
        );
        $aggregator=\Session::get('aggregator');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $user = \App\Models\aggregators::find($aggregator->id);
            $user->aggregator_password = \Hash::make($request->input('password'));
            $user->save();

            return Redirect::to('aggregator/profile')->with('message', \SiteHelpers::alert('success', 'Password has been saved!'));
        } else {
            return Redirect::to('aggregator/profile')->with('message', \SiteHelpers::alert('error', 'The following errors occurred')
                    )->withErrors($validator)->withInput();
        }
    }
    //handle forget password for aggregator
    public function sendPasswordResetToken(Request $request)
    {
      $rules = array(
          'credit_email' => 'required|email'
      );

      $validator = Validator::make(Input::all(), $rules);
      if ($validator->passes()) {
          $aggregator = \App\Models\aggregators::where('aggregator_email', '=', $request->input('credit_email'))->first();
          if ($aggregator) {
              $data = array('token' => $request->input('_token'));
              $to = $request->input('credit_email');
              $subject = "[ " . CNF_APPNAME . " ] REQUEST PASSWORD RESET ";
              $message = view('aggregator_interface.reminder', $data);
              $headers = 'MIME-Version: 1.0' . "\r\n";
              $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $headers .= 'From: ' . CNF_APPNAME . ' <' . CNF_EMAIL . '>' . "\r\n";
              mail($to, $subject, $message, $headers);
              $affectedRows = \App\Models\aggregators::where('aggregator_email', '=', $aggregator->aggregator_email)
                      ->update(['reminder' => $request->input('_token')]);
              //return redirect('aggregator/reset-password/'.$request->input('_token'));
              return Redirect::to('aggregator/login')->with('message', \SiteHelpers::alert('success', 'Please check your email')); // this not make flah
          } else {
              return Redirect::to('aggregator/login')->with('message', \SiteHelpers::alert('error', 'Cant find email address'));
          }
      } else {
          return Redirect::to('aggregator/login')->with('message', \SiteHelpers::alert('error', 'The following errors occurred')
                  )->withErrors($validator)->withInput();
      }
    }
    public function showPasswordResetForm($token)
    {
      $aggregator = \App\Models\aggregators::where('reminder', '=', $token);
      if ($aggregator->count() >= 1) {
          $data = array('verCode' => $token);
          return view('aggregator_interface.reset_password', $data);
      } else {
          return Redirect::to('aggregator/login')->with('message', \SiteHelpers::alert('error', 'Cant find your reset code'));
      }
    }
    public function resetPassword(Request $request , $token)
    {
      //some validation
      $rules = array(
          'password' => 'required|alpha_num|between:6,20|confirmed',
          'password_confirmation' => 'required|alpha_num|between:6,20'
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->passes()) {

          $aggregator = \App\Models\aggregators::where('reminder', '=', $token)->first();
          if ($aggregator) {
              $aggregator = \App\Models\aggregators::find($aggregator->id);
              $aggregator->reminder = '';
              $aggregator->aggregator_password = \Hash::make($request->input('password'));
              $aggregator->save();
          }

          return Redirect::to('aggregator/login')->with('message', \SiteHelpers::alert('success', 'Password has been saved!'));
      } else {
          return Redirect::to('aggregator/reset-password/' . $token)->with('message', \SiteHelpers::alert('error', 'The following errors occurred')
                  )->withErrors($validator)->withInput();
      }
    }
}
