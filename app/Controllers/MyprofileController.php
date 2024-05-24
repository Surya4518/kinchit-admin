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
use Illuminate\Support\Facades\Http;
use App\Common;


class MyprofileController extends Controller
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
    	
		
	public function myprofile(Request $request){
		
		
		
		$adminid = Session::get('adminid');
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		$success		= '';
		
		$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
		$insertupdateId 	= $getmyprofiledatas[0]->id;
		
		if ($request->isMethod('post')) {
			
			if(isset($request->txtimgfile)){
				$imageName = time().'.'.$request->txtimgfile->extension();
				$request->txtimgfile->move(public_path('medias'), $imageName);
			}
			else{
				$imageName = '';	
			}	
			
			
			
			$txtfirstname		= $request->input('txtfirstname');
			$txtlastname		= $request->input('txtlastname');
			$txtdesignation		= $request->input('txtdesignation');
			$txtpassword		= $request->input('txtpassword');			
			$txtemail			= $request->input('txtemail');
			$txtwebsite			= $request->input('txtwebsite'); 
			$txtphone			= $request->input('txtphone'); 
			$txtaddress			= $request->input('txtaddress'); 
			$txttwitter			= $request->input('txttwitter');
			$txtfacebook		= $request->input('txtfacebook');
			$txtgoogle			= $request->input('txtgoogle'); 
			$txtlinkedin		= $request->input('txtlinkedin');
			$txtgithub			= $request->input('txtgithub');
			$txtdescription		= $request->input('txtdescription'); 
			
			if($imageName==''){
					
				if($txtpassword!=""){					
					$insarray 		= array("firstname" => $txtfirstname,"lastname" => $txtlastname, "designation" => $txtdesignation, "password" => md5($txtpassword), "email" => $txtemail, "website" => $txtwebsite, "phone" => $txtphone, "address" => $txtaddress, "twitter_link" =>$txttwitter, "fbook_link" => $txtfacebook, "googleplus_link" => $txtgoogle, "linkedin_link" => $txtlinkedin, "github_link" => $txtgithub, "biographical" => $txtdescription );
				}
				else{
					$insarray 		= array("firstname" => $txtfirstname,"lastname" => $txtlastname, "designation" => $txtdesignation, "email" => $txtemail, "website" => $txtwebsite, "phone" => $txtphone, "address" => $txtaddress, "twitter_link" =>$txttwitter, "fbook_link" => $txtfacebook, "googleplus_link" => $txtgoogle, "linkedin_link" => $txtlinkedin, "github_link" => $txtgithub, "biographical" => $txtdescription );
				}		
			}
			else{
				
				if($txtpassword!=""){	
					$insarray 		= array("firstname" => $txtfirstname,"lastname" => $txtlastname, "designation" => $txtdesignation, "password" => md5($txtpassword), "email" => $txtemail, "website" => $txtwebsite, "phone" => $txtphone, "address" => $txtaddress, "twitter_link" =>$txttwitter, "fbook_link" => $txtfacebook, "googleplus_link" => $txtgoogle, "linkedin_link" => $txtlinkedin, "github_link" => $txtgithub, "biographical" => $txtdescription, "profile_pic" => $imageName );
				}
				else{
					$insarray 		= array("firstname" => $txtfirstname,"lastname" => $txtlastname, "designation" => $txtdesignation, "email" => $txtemail, "website" => $txtwebsite, "phone" => $txtphone, "address" => $txtaddress, "twitter_link" =>$txttwitter, "fbook_link" => $txtfacebook, "googleplus_link" => $txtgoogle, "linkedin_link" => $txtlinkedin, "github_link" => $txtgithub, "biographical" => $txtdescription, "profile_pic" => $imageName );
				}		
			}	
			
			
			$update = DB::table("adminusers")->where("id", $insertupdateId)->update($insarray);
			
			$success		= 'ok';
		
		}	
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();		
		
		$alldatas['getsubadmindatas'] 			= Common::getsubadmindatas($insertupdateId);
		
		$alldatas['hideditid']					= $insertupdateId;
		
		$alldatas['successmsg']			= $success;
		
		return view('myprofile')->with("alldatas", $alldatas);
		
	}	
	
}
