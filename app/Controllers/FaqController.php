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


class FaqController extends Controller
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
    
	public function createnewfaq(Request $request){
		
		$adminid = Session::get('adminid');
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		$success						= '';
		
		if ($request->isMethod('post')) {
			
					
			$txtposttitle			= $request->input('txtposttitle');		
			$txtposttype			= $request->input('txtposttype');
			$hiddescription			= $request->input('hiddescription');			
			$txtcategory			= $request->input('txtcategory');	
			$txtdisplayin			= $request->input('txtdisplayin');	
			
			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
			$create_by 			= $getmyprofiledatas[0]->id;
			
			$ins_array		= array("title" => $txtposttitle, "description" => $hiddescription, "status" => $txtposttype, "create_by" => $create_by, "create_date" => date("Y-m-d"), "faq_categories" => $txtcategory, "faq_displayin" => $txtdisplayin );

			DB::table("faq")->insert($ins_array);	
			
			$success						= 'ok';
			
		}	
			
		
		
		
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();	
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
		
		$alldatas['successmsg']			= $success;
		
		return view('createnewfaq')->with("alldatas", $alldatas);
		
	}
	
	
	public function faqlist(Request $request){
		
		$adminid = Session::get('adminid');
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		$success						= '';
		
		if ($request->isMethod('post')) {
		
			$txtposttitle		= $request->input('txtposttitle');
			$txtcreatedby		= $request->input('txtcreatedby');
			$txtposteddate		= $request->input('txtposteddate');
			
			$txtstatus			= @$request->input('txtstatus');
			$txtstatus_final	= '';
			
			if($txtstatus!=""){			
			
				foreach($txtstatus as $txtstatusvalue){					
					$txtstatus_final .= $txtstatusvalue.",";					
				}	
			
			}
			
			if($txtstatus_final!=""){
				$txtstatus_final = substr($txtstatus_final,0, strlen($txtstatus_final)-1);	
			}
			
			
				
		}	
		else{
			$txtposttitle		= '';
			$txtcreatedby		= '';
			$txtposteddate		= '';
			$txtstatus_final 	= '';				
		}	
		
		
		
		$alldatas['successmsg']			= $success;		
		
		$alldatas['getallpostdatas'] 		= Common::getallfaqdatas($txtposttitle, $txtcreatedby, $txtposteddate,$txtstatus_final);
		
		$alldatas['bindedtxtposttitle'] 	= $txtposttitle;
		$alldatas['bindedtxtcreatedby'] 	= $txtcreatedby;
		$alldatas['bindedtxtposteddate'] 	= $txtposteddate;
		$alldatas['bindedtxtstatus']		= $txtstatus_final;		
		
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
		
		return view('faqlist')->with("alldatas", $alldatas);
		
	}

	public function deletefaq(Request $request){
		
		if ($request->isMethod('post')) {			
			
			
			$txtdelid = $request->input('delid');
			
			if($txtdelid!=""){				
				DB::table('faq')->where('id', '=', $txtdelid)->delete();
			}
			
			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}
		
	}

	public function editfaq(Request $request){
		
		$adminid 			= Session::get('adminid');
		$editId 			= $request->id;
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		if($editId==""){
			return abort(404);
		}	
		else{
			
			$ss = Common::fetchfaqdatas($editId);
			
			if(sizeof($ss)=="0"){
				return abort(404);
			}	
		
		}	
		
		
		$success						= '';
		
		if ($request->isMethod('post')) {
			
			
					
			$txtposttitle			= $request->input('txtposttitle');					
			$hiddescription			= $request->input('hiddescription');
			$txtstatus				= $request->input('txtstatus');			
			$txtcategory			= $request->input('txtcategory');	
			$txtdisplayin			= $request->input('txtdisplayin');	
			
			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
			$create_by 			= $getmyprofiledatas[0]->id;			
			
			$ins_array		= array("title" => $txtposttitle, "description" => $hiddescription, "status" => $txtstatus, "faq_categories" => $txtcategory, "faq_displayin" => $txtdisplayin);
			$update = DB::table("faq")->where("id", $editId)->update($ins_array);
			
			
			$success						= 'ok';
			
		}
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();	
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
		
		$alldatas['successmsg']			= $success;		
		
		$alldatas['fetchpostsdatas'] 	= Common::fetchfaqdatas($editId);				
		
		$getonlyactivedoctors 		= Common::getonlyactivedoctors();
		$getonlyactivespeciality 	= Common::getonlyactivespeciality();		
		
		$alldatas['getonlyactivedoctors'] 		= $getonlyactivedoctors;
		$alldatas['getonlyactivespeciality'] 	= $getonlyactivespeciality;	
		
		return view('editfaq')->with("alldatas", $alldatas);
		
	}	
	
	public function updatefaqsortorder(Request $request){
		
		if ($request->isMethod('post')) {		
			
			$txtsort 	= $request->input('txtsort');
			$editid 	= $request->input('editid');
			
			if($editid!=""){				
				
				$ins_array		= array("sort_order" => $txtsort);
				$update 		= DB::table("faq")->where("id", $editid)->update($ins_array);
				
			}
			
			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}
		
	}
	
	public function bindeddisplayinfaq(Request $request){
		
		$datastr = '';
		
		$getonlyactivedoctors 		= Common::getonlyactivedoctors();
		$getonlyactivespeciality 	= Common::getonlyactivespeciality();
		
		
		if ($request->isMethod('post')) {
			
			$txtcategory 	= $request->input('txtcategory');
			
			$datastr = '<option label="Choose one" value=""></option>';
			
			if($txtcategory=="1"){
				$datastr .= '<option label="Home Page" value="1">Home Page</option>';  
			}
			else if($txtcategory=="2"){
				
				for ($ii=0;$ii<sizeof($getonlyactivedoctors);$ii++){
					$datastr .= '<option label="'.$getonlyactivedoctors[$ii]->doctor_name.'" value="'.$getonlyactivedoctors[$ii]->id.'">'.$getonlyactivedoctors[$ii]->doctor_name.'</option>';
				}	
				
			}
			else if($txtcategory=="3"){
				
				for ($ii=0;$ii<sizeof($getonlyactivespeciality);$ii++){
					$datastr .= '<option label="'.$getonlyactivespeciality[$ii]->page_title.'" value="'.$getonlyactivespeciality[$ii]->id.'">'.$getonlyactivespeciality[$ii]->page_title.'</option>';
				}
				
			}		
			
			return Response::json(array('status_code' => '1','datas' => $datastr));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}		
		
		
	}	
	
}

