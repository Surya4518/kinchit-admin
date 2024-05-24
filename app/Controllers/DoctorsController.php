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
use Illuminate\Support\Str;
use App\Common;


class DoctorsController extends Controller
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
    
	public function createnewdoctors(Request $request){
		
		$adminid = Session::get('adminid');
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
		$create_by 			= $getmyprofiledatas[0]->id;
		
		$success						= '';		
		$currenttab						= 1;
		$editid							= '';
		$successtype					= '';		
		
		
		if ($request->isMethod('post')) {			
			
			
			if($request->input('hidsubmitfrm1')!=""){
				
				// General Tab
				
				$txtdoctorname		= $request->input('txtdoctorname');	
				$txtdesignation		= $request->input('txtdesignation');
				$txttotalyrsofexp	= $request->input('txttotalyrsofexp');
				$txtdegreeone		= $request->input('txtdegreeone');
				$txtdegreetwo		= $request->input('txtdegreetwo');
				$txtdegreethree		= $request->input('txtdegreethree');
				$txtdegreefour		= $request->input('txtdegreefour');
				$txtdegreefive		= $request->input('txtdegreefive');
				$txtspecialty		= $request->input('txtspecialty');
				$hidtxtadditionalinfo	= $request->input('hidtxtadditionalinfo');
				$txtstatus			= $request->input('txtstatus');
				
				$hideditid1			= $request->input('hideditid1');
				
				$txtdepartment		= $request->input('txtdepartment');
				$sort_order		= $request->input('sort_order');
				
				
				$ins_array			= array("doctor_name" => $txtdoctorname, "doctor_designation" => $txtdesignation, "doctor_totalyrofexp" => $txttotalyrsofexp, "doctor_degree1" => $txtdegreeone, "doctor_degree2" => $txtdegreetwo, "doctor_degree3" => $txtdegreethree, "doctor_degree4" => $txtdegreefour, "doctor_degree5" => $txtdegreefive, "doctor_specialty" => $txtspecialty, "doctor_specialty_info" => $hidtxtadditionalinfo,  "status" => $txtstatus,  "create_by" => $create_by, "create_date" => date("Y-m-d"), "doctor_department" => $txtdepartment,"sort_order"=> $sort_order  );
				
				if($hideditid1==""){				
					DB::table("doctors")->insert($ins_array);				
					$editid 	= DB::getPdo()->lastInsertId();
					
					$ins_slug_arr		= array("doctor_slug" => Str::slug($txtdoctorname." ".$txtdesignation." ".$editid));
					DB::table("doctors")->where("id", $editid)->update($ins_slug_arr);
					
					$success						= 'General information inserted successfully';
				}
				else{
					$editid 	= $hideditid1;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					
					$ins_slug_arr		= array("doctor_slug" => Str::slug($txtdoctorname." ".$txtdesignation." ".$editid));
					DB::table("doctors")->where("id", $editid)->update($ins_slug_arr);
					
					$success						= 'General information updated successfully';
				}		
				
				$currenttab						= 2;
				// General Tab
				
			} // if($request->input('hidsubmitfrm1')!=""){	
			
			if($request->input('hidsubmitfrm2')!=""){	
			
				$hideditid2			= $request->input('hideditid2');
				
				if(isset($request->txtimgfile)){
					
					$gallerydatas	= Common::fetchdoctordatas($hideditid2);		
					$gallery_image	= $gallerydatas[0]->doctor_proffileimg;
					
					if($gallery_image!=""){					
						@unlink(public_path("medias/").$gallery_image);					
					}
					
					$imageName = time().'.'.$request->txtimgfile->extension();
					$request->txtimgfile->move(public_path('medias'), $imageName);
				}
				else{
					$imageName = '';	
				}	
				
				
				$ins_array		= array("doctor_proffileimg" => $imageName, "create_by" => $create_by, "create_date" => date("Y-m-d"));
				if($hideditid2==""){		
					
					DB::table("doctors")->insert($ins_array);
					$editid 	= DB::getPdo()->lastInsertId();
					$success						= 'Profile image uploaded successfully';
				}
				else{
					$editid 	= $hideditid2;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					$success						= 'Profile image uploaded successfully';
				}							
				
				
				$currenttab						= 3;
			
			} // if($request->input('hidsubmitfrm2')!=""){	
			
			if($request->input('hidsubmitfrm3')!=""){	
				
				$hidtxtbriefprofile			= $request->input('hidtxtbriefprofile');	
				$hidtxteducationalinfo		= $request->input('hidtxteducationalinfo');	
				$hidtxtachievementinfo		= $request->input('hidtxtachievementinfo');	
				$hidtxtresearchinfo			= $request->input('hidtxtresearchinfo');
				$hidtxtexpertisein			= $request->input('hidtxtexpertisein');
				
				$hideditid3			= $request->input('hideditid3');
				
				$ins_array					= array( "doctor_briefinfo" => $hidtxtbriefprofile, "doctor_educational" => $hidtxteducationalinfo, "doctor_achievementsinfo" => $hidtxtachievementinfo, "doctor_researchinfo" => $hidtxtresearchinfo, "create_by" => $create_by, "create_date" => date("Y-m-d"), "doctor_expertise_in" => $hidtxtexpertisein );
				
				if($hideditid3==""){				
					DB::table("doctors")->insert($ins_array);
					$editid = DB::getPdo()->lastInsertId();
					$success						= 'Additonal details inserted successfully';
				}
				else{
					$editid 	= $hideditid3;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					$success						= 'Additonal details updated successfully';
				}		
				
				
				$currenttab						= 4;
				
				
			} // if($request->input('hidsubmitfrm3')!=""){	
			
			if($request->input('hidsubmitfrm4')!=""){
				
				$txtseometatitle		= $request->input('txtseometatitle');
				$txtseometakeywords		= $request->input('txtseometakeywords');
				$txtseometadescription	= $request->input('txtseometadescription');
				
				$hideditid4			= $request->input('hideditid4');
				
				$ins_array		= array("doctor_seo_metatitle" => $txtseometatitle, "doctor_seo_metakeywords" => $txtseometakeywords, "doctor_seo_metadescription" => $txtseometadescription, "create_by" => $create_by, "create_date" => date("Y-m-d") );
				
				if($hideditid4==""){
					DB::table("doctors")->insert($ins_array);
					$editid 	= DB::getPdo()->lastInsertId();
					$success						= 'SEO details inserted successfully';
				}
				else{
					$editid 	= $hideditid4;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					$success						= 'SEO details updated successfully';
				}		
				
				
				$currenttab						= 1;
				
			} // if($request->input('hidsubmitfrm4')!=""){	
			
		}	
			
		
		
		
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();		
		
		$alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();		
		
		$alldatas['successmsg']			= $success;
		$alldatas['currenttab']			= $currenttab;		
		$alldatas['editid']				= $editid;
		
		if($editid==""){
			$editid = 0;	
		}			
		
		$alldatas['fetchdoctordatas']	= Common::fetchdoctordatas($editid);
		
			
		
		return view('createnewdoctors')->with("alldatas", $alldatas);
		
	}
	
	
	public function doctorslist(Request $request){
		
		$adminid = Session::get('adminid');
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		$success						= '';
		
		if ($request->isMethod('post')) {
		
			$txtposttitle		= $request->input('txtposttitle');
			$txtcreatedby		= $request->input('txtcreatedby');
			$txtposteddate		= $request->input('txtposteddate');			
			$txtspecialty		= $request->input('txtspecialty');	
			
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
			$txtspecialty		= '';	
		}	
		
		
		
		$alldatas['successmsg']			= $success;		
		
		$alldatas['getallpostdatas'] 		= Common::getalldoctorsdatas($txtposttitle, $txtcreatedby, $txtposteddate,$txtstatus_final, $txtspecialty);
		
		$alldatas['bindedtxtposttitle'] 	= $txtposttitle;
		$alldatas['bindedtxtcreatedby'] 	= $txtcreatedby;
		$alldatas['bindedtxtposteddate'] 	= $txtposteddate;
		$alldatas['bindedtxtstatus']		= $txtstatus_final;
		$alldatas['bindedtxtspecialty']		= $txtspecialty;		
		
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();				
		
		return view('doctorslist')->with("alldatas", $alldatas);
		
	}

	public function deletedoctor(Request $request){
		
		if ($request->isMethod('post')) {			
			
			
			$txtdelid = $request->input('delid');
			
			if($txtdelid!=""){
						
				$gallerydatas	= Common::fetchdoctordatas($txtdelid);		
				$gallery_image	= $gallerydatas[0]->doctor_proffileimg;
				
				if($gallery_image!=""){					
					@unlink(public_path("medias/").$gallery_image);					
				}
				
				DB::table('doctors')->where('id', '=', $txtdelid)->delete();
			}
			
			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}
		
	}

	public function editdoctor(Request $request){
		
		$adminid = Session::get('adminid');
		$editId 			= $request->id;
		
		if(!(isset($adminid))){		  
			return Redirect::to("/"); 
		}		
		
		if($editId==""){
			return abort(404);
		}	
		else{
			
			$ss = Common::fetchdoctordatas($editId);
			
			if(sizeof($ss)=="0"){
				return abort(404);
			}	
		
		}	
		
		$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");		
		$create_by 			= $getmyprofiledatas[0]->id;
		
		$success						= '';		
		$currenttab						= 1;
		$editid							= '';
		$successtype					= '';		
		
		
		if ($request->isMethod('post')) {			
			
			
			if($request->input('hidsubmitfrm1')!=""){
				
				// General Tab
				
				$txtdoctorname		= $request->input('txtdoctorname');	
				$txtdesignation		= $request->input('txtdesignation');
				$txttotalyrsofexp	= $request->input('txttotalyrsofexp');
				$txtdegreeone		= $request->input('txtdegreeone');
				$txtdegreetwo		= $request->input('txtdegreetwo');
				$txtdegreethree		= $request->input('txtdegreethree');
				$txtdegreefour		= $request->input('txtdegreefour');
				$txtdegreefive		= $request->input('txtdegreefive');
				$txtspecialty		= $request->input('txtspecialty');
				$hidtxtadditionalinfo	= $request->input('hidtxtadditionalinfo');
				$txtstatus			= $request->input('txtstatus');
				
				$hideditid1			= $request->input('hideditid1');
				
				$txtdepartment		= $request->input('txtdepartment');
				 $sort_order		= $request->input('sort_order');
				
				$ins_array			= array("doctor_name" => $txtdoctorname, "doctor_designation" => $txtdesignation, "doctor_totalyrofexp" => $txttotalyrsofexp, "doctor_degree1" => $txtdegreeone, "doctor_degree2" => $txtdegreetwo, "doctor_degree3" => $txtdegreethree, "doctor_degree4" => $txtdegreefour, "doctor_degree5" => $txtdegreefive, "doctor_specialty" => $txtspecialty, "doctor_specialty_info" => $hidtxtadditionalinfo,  "status" => $txtstatus,  "create_by" => $create_by, "create_date" => date("Y-m-d"), "doctor_department" => $txtdepartment ,"sort_order"=> $sort_order);
				
				if($hideditid1==""){				
					DB::table("doctors")->insert($ins_array);				
					$editid 	= DB::getPdo()->lastInsertId();
					
					$ins_slug_arr		= array("doctor_slug" => Str::slug($txtdoctorname." ".$txtdesignation." ".$editid));
					DB::table("doctors")->where("id", $editid)->update($ins_slug_arr);
					
					$success						= 'General information inserted successfully';
				}
				else{
					$editid 	= $hideditid1;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					
					$ins_slug_arr		= array("doctor_slug" => Str::slug($txtdoctorname." ".$txtdesignation." ".$editid));
					DB::table("doctors")->where("id", $editid)->update($ins_slug_arr);
					
					$success						= 'General information updated successfully';
				}		
				
				$currenttab						= 1;
				// General Tab
				
			} // if($request->input('hidsubmitfrm1')!=""){	
			
			if($request->input('hidsubmitfrm2')!=""){	
			
				$hideditid2			= $request->input('hideditid2');
				
				if(isset($request->txtimgfile)){
					
					$gallerydatas	= Common::fetchdoctordatas($hideditid2);		
					$gallery_image	= $gallerydatas[0]->doctor_proffileimg;
					
					if($gallery_image!=""){					
						@unlink(public_path("medias/").$gallery_image);					
					}
					
					$imageName = time().'.'.$request->txtimgfile->extension();
					$request->txtimgfile->move(public_path('medias'), $imageName);
				}
				else{
					$imageName = '';	
				}	
				
				
				$ins_array		= array("doctor_proffileimg" => $imageName, "create_by" => $create_by, "create_date" => date("Y-m-d"));
				if($hideditid2==""){		
					
					DB::table("doctors")->insert($ins_array);
					$editid 	= DB::getPdo()->lastInsertId();
					$success						= 'Profile image uploaded successfully';
				}
				else{
					$editid 	= $hideditid2;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					$success						= 'Profile image uploaded successfully';
				}							
				
				
				$currenttab						= 2;
			
			} // if($request->input('hidsubmitfrm2')!=""){	
			
			if($request->input('hidsubmitfrm3')!=""){	
				
				$hidtxtbriefprofile			= $request->input('hidtxtbriefprofile');	
				$hidtxteducationalinfo		= $request->input('hidtxteducationalinfo');	
				$hidtxtachievementinfo		= $request->input('hidtxtachievementinfo');	
				$hidtxtresearchinfo			= $request->input('hidtxtresearchinfo');
				$hidtxtexpertisein			= $request->input('hidtxtexpertisein');
				
				$hideditid3			= $request->input('hideditid3');
				
				$ins_array					= array( "doctor_briefinfo" => $hidtxtbriefprofile, "doctor_educational" => $hidtxteducationalinfo, "doctor_achievementsinfo" => $hidtxtachievementinfo, "doctor_researchinfo" => $hidtxtresearchinfo, "create_by" => $create_by, "create_date" => date("Y-m-d"), "doctor_expertise_in" => $hidtxtexpertisein );
				
				if($hideditid3==""){				
					DB::table("doctors")->insert($ins_array);
					$editid = DB::getPdo()->lastInsertId();
					$success						= 'Additonal details inserted successfully';
				}
				else{
					$editid 	= $hideditid3;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					$success						= 'Additonal details updated successfully';
				}		
				
				
				$currenttab						= 3;
				
				
			} // if($request->input('hidsubmitfrm3')!=""){	
			
			if($request->input('hidsubmitfrm4')!=""){
				
				$txtseometatitle		= $request->input('txtseometatitle');
				$txtseometakeywords		= $request->input('txtseometakeywords');
				$txtseometadescription	= $request->input('txtseometadescription');
				
				$hideditid4			= $request->input('hideditid4');
				
				$ins_array		= array("doctor_seo_metatitle" => $txtseometatitle, "doctor_seo_metakeywords" => $txtseometakeywords, "doctor_seo_metadescription" => $txtseometadescription, "create_by" => $create_by, "create_date" => date("Y-m-d") );
				
				if($hideditid4==""){
					DB::table("doctors")->insert($ins_array);
					$editid 	= DB::getPdo()->lastInsertId();
					$success						= 'SEO details inserted successfully';
				}
				else{
					$editid 	= $hideditid4;
					DB::table("doctors")->where("id", $editid)->update($ins_array);
					$success						= 'SEO details updated successfully';
				}		
				
				
				$currenttab						= 4;
				
			} // if($request->input('hidsubmitfrm4')!=""){	
			
		}	
			
		
		
		
		
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();			
		
		$alldatas['successmsg']			= $success;
		$alldatas['currenttab']			= $currenttab;		
		$alldatas['editid']				= $editId;		
					
		
		$alldatas['fetchdoctordatas']	= Common::fetchdoctordatas($editId);
		$alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();	
			
		
		return view('editdoctor')->with("alldatas", $alldatas);
		
	}	
	
	public static  function setashomepagedoctors(Request $request){
		
		if ($request->isMethod('post')) {		
			
			$checkedvalues 		= $request->input('checkedvalues');
			$txtdelid 			= $request->input('delid');
				
			$ins_array		= array("is_homepage" => $checkedvalues);
			$update 		= DB::table("doctors")->where("id", $txtdelid)->update($ins_array);				
			
			
			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}
		
	}	
	
	
	 public function updatedoctorsortorder(Request $request){

		if ($request->isMethod('post')) {

			$txtsort 	= $request->input('txtsort');
			$editid 	= $request->input('editid');

			if($editid!=""){

				$ins_array		= array("sort_order" => $txtsort);
				$update 		= DB::table("doctors")->where("id", $editid)->update($ins_array);

			}

			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}

	}
	
	
}

