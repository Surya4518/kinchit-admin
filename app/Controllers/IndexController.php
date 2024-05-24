<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Session;
use Storage;
use Mail;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;


class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
		$adminid = Session::get('adminid');
	  
		if(isset($adminid)){		  
			return Redirect::to("dashboard"); 
		} 
		
		if ($request->isMethod('post')) {
			$txtusername	= $request->input('txtusername');
			Session::put('adminid', $txtusername);

			return Redirect::to("dashboard");	
		}	
		
		return view('index');		
		
    }
	
	public function logout(){
		
		
		Session::flush();		
		
		return Redirect::to("/");

	}
	
	public function forgetpassword(Request $request)
    {
      return view('forgetpassword');	
	} 

	public function loginverify(Request $request)
    {
        
		if ($request->isMethod('post')) {
			
			$txtusername	= $request->input('txtusername');
			$txtpassword	= $request->input('txtpassword');
			
			$userdatas = DB::select("select * from adminusers where status = 1 and email = '".$txtusername."' and password = '".md5($txtpassword)."' limit 0,1 ");
			
			if(sizeof($userdatas)=="0"){
				return Response::json(array('status_code' => '0'));	
			}	
			else{
				return Response::json(array('status_code' => '1'));	
			}	
			
		}
		else{
			return Response::json(array('status_code' => '0'));	
		}		
		
    }

	public function verifyemailid(Request $request){
		
		if ($request->isMethod('post')) {
			
			$type 			= $request->type;
			$txtemailid		= $request->txtemailid;
			
			$userdatas 		= DB::select("select * from adminusers where email = '".$txtemailid."' and status = 1 limit 0,1 ");
			
			if(sizeof($userdatas)=="0"){
				return Response::json(array('status_code' => '0'));
			}
			else{
				
				$to_name 	= $userdatas[0]->nickname;
				$to_email 	= $userdatas[0]->email;
				
				$six_digit_random_number = mt_rand(100000, 999999);
				
				$data = array('userdisplayname'=>$to_name, "newpwd" => $six_digit_random_number);
				
				Mail::send('forgotpasswordemailsbody', $data, function($message) use ($to_name, $to_email) {
				$message->to($to_email, $to_name)->subject('Password reset :: Chettinad Super Speciality Hospital');
				$message->from('info@smlimousine.com','Chettinad Super Speciality Hospital');
				});
				
				$insert_arr	= array( 'password' 	=> md5($six_digit_random_number) );
				
				$update = DB::table("adminusers")->where("id", $userdatas[0]->id)->update($insert_arr);
				
				
				return Response::json(array('status_code' => '1'));
				
			}		
			
		}
		else{
			return Response::json(array('status_code' => '0'));	
		}	
		
	}	
	
	public function verifysuperadminemail(Request $request){
		
		if ($request->isMethod('post')) {
			
			$type 			= $request->type;
			$txtemail		= $request->txtemail;
			$editid			= $request->editid;
			
			$subquery		= '';
			
			
			if($editid!=""){
				$subquery		.= ' and id!= '.$editid;	
			}	
			
			
			$userdatas 		= DB::select("select * from adminusers where email = '".$txtemail."' ".$subquery."  limit 0,1 ");
			
			if(sizeof($userdatas)=="0"){
				return Response::json(array('status_code' => '0'));	
			}	
			else{
				return Response::json(array('status_code' => '1'));	
			}	

		}	
		else{
			return Response::json(array('status_code' => '0'));	
		}	
		
	}
}
