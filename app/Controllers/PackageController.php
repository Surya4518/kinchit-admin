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


class PackageController extends Controller
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
    
	public function createnewpackage(Request $request){
		
		$adminid = Session::get('adminid');
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		$success						= '';
		
		if ($request->isMethod('post')) {
			
			
					
			$txtposttitle			= $request->input('txtposttitle');		
			$txtstatus			= $request->input('txtstatus');
			$hiddescription			= $request->input('hiddescription');

			if(isset($request->txtimgfile)){
			
				$imageName = time().'.'.$request->txtimgfile->extension();
				$request->txtimgfile->move(public_path('medias'), $imageName);	
				
				
			}
			else{
				$imageName = '';
			}			
			
			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
			$create_by 			= $getmyprofiledatas[0]->id;
			
			$ins_array		= array("title" => $txtposttitle, "description" => $hiddescription, "status" => $txtstatus, "create_by" => $create_by, "create_date" => date("Y-m-d"), "image_file" => $imageName );
				
			DB::table("package")->insert($ins_array);	
			
			$success						= 'ok';
			
		}	
			
		
		
		
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();	
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
		
		$alldatas['successmsg']			= $success;		
		
		
		
		return view('createnewpackage')->with("alldatas", $alldatas);
		
	}
	
	
	public function packagelist(Request $request){
		
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
		
		$alldatas['getallpostdatas'] 		= Common::getallpackagesdatas($txtposttitle, $txtcreatedby, $txtposteddate,$txtstatus_final);
		
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

		
		return view('packagelist')->with("alldatas", $alldatas);
		
	}

	public function deletepackage(Request $request){
		
		if ($request->isMethod('post')) {			
			
			
			$txtdelid = $request->input('delid');
			
			if($txtdelid!=""){				
				DB::table('package')->where('id', '=', $txtdelid)->delete();
			}
			
			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}
		
	}

	public function editpackage(Request $request){
		
		$adminid 			= Session::get('adminid');
		$editId 			= $request->id;
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		if($editId==""){
			return abort(404);
		}	
		else{
			
			$ss = Common::fetchpackagedatas($editId);
			
			if(sizeof($ss)=="0"){
				return abort(404);
			}	
		
		}	
		
		
		$success						= '';
		
		if ($request->isMethod('post')) {
			
			
					
			$txtposttitle			= $request->input('txtposttitle');					
			$hiddescription			= $request->input('hiddescription');
			$txtstatus				= $request->input('txtstatus');			
			
			if(isset($request->txtimgfile)){
			
				$imageName = time().'.'.$request->txtimgfile->extension();
				$request->txtimgfile->move(public_path('medias'), $imageName);	
				
				
			}
			else{
				$imageName = '';
			}			
			
			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
			$create_by 			= $getmyprofiledatas[0]->id;			
			
			if($imageName==''){
				$ins_array		= array("title" => $txtposttitle, "description" => $hiddescription, "status" => $txtstatus);
				$update = DB::table("package")->where("id", $editId)->update($ins_array);
			}
			else{
				$ins_array		= array("title" => $txtposttitle, "description" => $hiddescription, "status" => $txtstatus, "image_file" => $imageName);
				$update = DB::table("package")->where("id", $editId)->update($ins_array);	
			}	
			
			
			$success						= 'ok';
			
		}
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();	
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
		
		$alldatas['successmsg']			= $success;		
		
		$alldatas['fetchpostsdatas'] 		= Common::fetchpackagedatas($editId);
		
		return view('editpackage')->with("alldatas", $alldatas);
		
	}

	public function updatepackagesortorder(Request $request){
		
		if ($request->isMethod('post')) {		
			
			$txtsort 	= $request->input('txtsort');
			$editid 	= $request->input('editid');
			
			if($editid!=""){				
				
				$ins_array		= array("sort_order" => $txtsort);
				$update 		= DB::table("package")->where("id", $editid)->update($ins_array);
				
			}
			
			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}
		
	}	
	
}

