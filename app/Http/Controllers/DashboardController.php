<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator,
    Input,
    Redirect;

class DashboardController extends Controller {

    protected $databases_base_path ;

    public function __construct() {
        parent::__construct();
        $this->databases_base_path = base_path()."/uploads/databaseBackups/"  ;
    }

    public function getIndex(Request $request) {

        // make check
        $fid =    Session::get('fid') ;
        if( $fid == null)  return   redirect("/user/login") ;


        $data = \Auth::user()->id;
        $method = "aes-128-cbc"; // in java   AES+Base64
        $encryption_key = '!@#$$%~##!@';
        $iv = str_repeat(chr(0), 16);   //  in java  =    AES/CBC/PKCS5Padding    // chr(0) = ""
        $encrypted = openssl_encrypt($data, $method, $encryption_key, 0, $iv);


        // reset ivas_login_inside
        $currentUser = User::where('id', \Auth::user()->id)->first();
        if ($currentUser) {
            $currentUser->ivas_login_inside = 0;
            $currentUser->save();
        }

        $this->data['total_user'] = \DB::table('tb_users')->count();
        $this->data['total_groups'] = \DB::table('tb_groups')->count();
        $this->data['encrypted'] = $encrypted;
        return view('dashboard.index', $this->data);
    }

    public function postResettoken(Request $request) {
        $data = array();
        $data['mobile_token'] = '';
        \DB::table('tb_users')->where('id', $request->input('id'))->update($data);

        echo "true";
    }



    public function getTest(Request $request) {


     $fid =    Session::get('fid') ;

        if( $fid == null){
           return   redirect("/user/login") ;
           echo "yes" ;

        }else{
            echo "no" ;
        }
        dd($fid);
    }

    public function check(Request $request) {
        $check = 0;
        if ($request->url() != "http://10.2.10.10/~hrivashosting/check") {
            $check = 0;
        } else {
            $encrypted = $request->input('key');
            if (isset($encrypted) && $encrypted != "") {
                $method = "aes-128-cbc"; // in java   AES+Base64
                $encryption_key = '!@#$$%~##!@';
                $iv = str_repeat(chr(0), 16);   //  in java  =    AES/CBC/PKCS5Padding    // chr(0) = ""
                $decrypted = openssl_decrypt($encrypted, $method, $encryption_key, 0, $iv);
                $currentUser = User::where('id', $decrypted)->first();
                if ($currentUser) {
                    $currentUser->ivas_login_inside = 1;
                    $currentUser->save();
                    $check = 1;
                }
            }
        }


        return response(json_encode($check))->header('Access-Control-Allow-Origin', '*')
                        ->header('Access-Control-Allow-Credentials', 'true')
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
                        ->header('Access-Control-Max-Age', '28800');
    }

    public function reset() {
        Session::set('check', 0);
        $check = Session::get('check');
        return response(json_encode($check))->header('Access-Control-Allow-Origin', '*')
                        ->header('Access-Control-Allow-Credentials', 'true')
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
                        ->header('Access-Control-Max-Age', '28800');
    }

    public function download_backup(Request $request)
    {
        $file = $this->databases_base_path.$request['path'] ;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function export_DB_backup()
    {
        // $this->backup_tables('localhost',env('DB_USERNAME'),env('DB_PASSWORD'),env('DB_DATABASE'));
        $database_name = env('DB_DATABASE') ;
        $database_password = env('DB_PASSWORD') ;
        $database_username = env('DB_USERNAME') ;
        if($database_password)
            $database_password = "-p".$database_password ;
        else
            $database_password = "" ;

      //   $mysqldump_command = "E:/XAMPP/mysql/bin/mysqldump" ; // for windows
        $mysqldump_command = "mysqldump" ; // for linux server

        $command = "$mysqldump_command -u $database_username $database_password $database_name > ".$this->databases_base_path.date("Y-m-d_H-i-s").'.sql' ;
        $command = str_replace("\\","/",$command) ;


        exec($command) ;
        return Redirect::back()->with('messagetext', 'Database Exported Successfully')->with('msgstatus', 'success');

    }

    public function list_backups()
    {
        $path      = $this->file_build_path("uploads","databaseBackups") ;
        if(! file_exists($path))
            mkdir($path,null, true) ;
        $files     = scandir($path);
        $databases = array() ;
        foreach($files as $file)
            if(strpos($file,".sql"))
                array_push($databases,$file) ;

        $full_path = $this->databases_base_path  ;
        $full_path = str_replace("\\","/",$full_path);
        return view('database.list_backups',compact('databases','full_path')) ;
    }

    public function delete_backup(Request $request)
    {
        $path = $this->databases_base_path.$request['path'] ;
        if(file_exists($path))
            unlink($path) ;
        return Redirect::back()->with('messagetext', 'Back up deleted')->with('msgstatus', 'success');
    }

    public function import_DB_backup(Request $request)
    {

        $imported_path = $this->databases_base_path.$request['path'] ;
        if(! file_exists($imported_path))
        {
            \Session::flash('success','Database not found') ;
            return back() ;
        }

        $database_name = env('DB_DATABASE') ;
        $database_password = env('DB_PASSWORD') ;
        $database_username = env('DB_USERNAME') ;
        if($database_password)
            $database_password = "-p".$database_password ;
        else
            $database_password = "" ;

        // $mysqldump_command = "E:/XAMPP/mysql/bin/mysql" ;  // for windows
        $mysqldump_command = "mysql" ;    // for linux server

        $command = "$mysqldump_command -u $database_username $database_password $database_name < ".$imported_path ;
        $command = str_replace("\\","/",$command) ;
        exec($command) ;
        return Redirect::back()->with('messagetext', 'Database Imported Successfully')->with('msgstatus', 'success');

    }
    public function file_build_path(...$segments) {
        return join(DIRECTORY_SEPARATOR, $segments);
    }






}
