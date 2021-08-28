<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\providers;
use Validator , Hash , Input , Redirect;
class ProviderInterfaceController extends Controller
{
    // hanlde login and log out function
    public function get_login_page()
    {
      return view('provider_interface.login');
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
      $provider = providers::where('provider_email',$request->email)->first();
      if($provider){
        if(Hash::check($request->password, $provider->provider_password)){
        \Session::set('provider',$provider);
        return redirect('/provider');}
        else{return back()->with(['message' => \SiteHelpers::alert('error', 'There Are An Error In Password')]);}
      }
      else{
        return back()->with(['message' => \SiteHelpers::alert('error', 'Cant find email address')]);
      }
    }
    public function logout()
    {
      \Session::forget('provider');
      return redirect('/provider');
    }
    public function index()
    {
      return view('provider_interface.index');
    }
    //handle elfinder for provider
    public function elfinder_content(Request $request)
    {
      $provider = \Session::get('provider');
      $data = array();
  		//return public_path().'/uploads/userfiles/';
  		if(!is_dir(public_path().'/uploads/providers/'.$provider->id.'_'.$provider->provider_name)) {
        mkdir(public_path().'/uploads/providers/'.$provider->id.'_'.$provider->provider_name,0777,true);
      }

  			$data['folder'] = './uploads/providers/'.$provider->id.'_'.$provider->provider_name;

  		if(!is_null($request->get('cmd')))
  		{
  			return view('core.elfinder.connector',$data);

  		} else {
  			return view('provider_interface.elfinder',$data);
  		}

    }
    //profile for provider
    public function getProfile()
    {
        $info = \Session::get('provider');
        // print_r($info); die ;
        $this->data = array(
            'pageTitle' => 'My Profile',
            'pageNote' => 'View Detail My Info',
            'info' => $info,
        );
        return view('provider_interface.profile', $this->data);
    }
    public function postSaveprofile(Request $request)
    {
      $provider=\Session::get('provider');
      $user = \App\Models\providers::find($provider->id);
      $rules = array(
                  'provider_mobile' => 'required|unique:providers,provider_mobile,' . $user->id
                  );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {


            if (!is_null(Input::file('provider_logo'))) {
                $file = $request->file('provider_logo');
                $destinationPath = './uploads/user/';
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension(); //if you need extension of the file
                $newfilename = $user->id.time(). '.' . $extension;
                $uploadSuccess = $request->file('provider_logo')->move($destinationPath, $newfilename);
                if ($uploadSuccess) {
                    $data['provider_logo'] = $newfilename;
                }
            }

            $user->provider_name = $request->input('provider_name');
            $user->provider_mobile = $request->input('provider_mobile');
            if (isset($data['provider_logo']))
                $user->provider_logo = $data['provider_logo'];
            $user->save();
            \Session::set('provider',$user);
            return Redirect::to('provider/profile')->with('message',\SiteHelpers::alert('success', 'Profile has been saved!'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('provider/profile')->with('message', \SiteHelpers::alert('error', 'The following errors occurred'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }
    public function postSavepassword(Request $request)
    {
        $rules = array(
            'password' => 'required|alpha_num|between:6,20',
            'password_confirmation' => 'required|alpha_num|between:6,20'
        );
        $provider=\Session::get('provider');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $user = \App\Models\providers::find($provider->id);
            $user->provider_password = \Hash::make($request->input('password'));
            $user->save();

            return Redirect::to('provider/profile')->with('message', \SiteHelpers::alert('success', 'Password has been saved!'));
        } else {
            return Redirect::to('provider/profile')->with('message', \SiteHelpers::alert('error', 'The following errors occurred')
                    )->withErrors($validator)->withInput();
        }
    }
    //handle forget password for provider
    public function sendPasswordResetToken(Request $request)
    {
      $rules = array(
          'credit_email' => 'required|email'
      );

      $validator = Validator::make(Input::all(), $rules);
      if ($validator->passes()) {
          $provider = \App\Models\providers::where('provider_email', '=', $request->input('credit_email'))->first();
          if ($provider) {
              $data = array('token' => $request->input('_token'));
              $to = $request->input('credit_email');
              $subject = "[ " . CNF_APPNAME . " ] REQUEST PASSWORD RESET ";
              $message = view('provider_interface.reminder', $data);
              $headers = 'MIME-Version: 1.0' . "\r\n";
              $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $headers .= 'From: ' . CNF_APPNAME . ' <' . CNF_EMAIL . '>' . "\r\n";
              mail($to, $subject, $message, $headers);
              $affectedRows = \App\Models\providers::where('provider_email', '=', $provider->provider_email)
                      ->update(['reminder' => $request->input('_token')]);
              //return redirect('provider/reset-password/'.$request->input('_token'));
              return Redirect::to('provider/login')->with('message', \SiteHelpers::alert('success', 'Please check your email')); // this not make flah
          } else {
              return Redirect::to('provider/login')->with('message', \SiteHelpers::alert('error', 'Cant find email address'));
          }
      } else {
          return Redirect::to('provider/login')->with('message', \SiteHelpers::alert('error', 'The following errors occurred')
                  )->withErrors($validator)->withInput();
      }
    }
    public function showPasswordResetForm($token)
    {
      $provider = \App\Models\providers::where('reminder', '=', $token);
      if ($provider->count() >= 1) {
          $data = array('verCode' => $token);
          return view('provider_interface.reset_password', $data);
      } else {
          return Redirect::to('provider/login')->with('message', \SiteHelpers::alert('error', 'Cant find your reset code'));
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

          $provider = \App\Models\providers::where('reminder', '=', $token)->first();
          if ($provider) {
              $provider = \App\Models\providers::find($provider->id);
              $provider->reminder = '';
              $provider->provider_password = \Hash::make($request->input('password'));
              $provider->save();
          }

          return Redirect::to('provider/login')->with('message', \SiteHelpers::alert('success', 'Password has been saved!'));
      } else {
          return Redirect::to('provider/reset-password/' . $token)->with('message', \SiteHelpers::alert('error', 'The following errors occurred')
                  )->withErrors($validator)->withInput();
      }
    }
}
