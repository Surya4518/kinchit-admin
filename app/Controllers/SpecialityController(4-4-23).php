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
use Illuminate\Support\Facades\Validator;

class SpecialityController extends Controller
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

	public function createspeciality(Request $request){

		$adminid = Session::get('adminid');

		if(!(isset($adminid))){
			return Redirect::to("/");
		}

		$success						= '';

		if ($request->isMethod('post')) {



			$txtmenuname		= $request->input('txtmenuname');
			$txtpagetitle		= $request->input('txtpagetitle');
			$txtstatus			= $request->input('txtstatus');
			$txtdepartment		= $request->input('txtdepartment');

			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");
			$create_by 			= $getmyprofiledatas[0]->id;

			$ins_array		= array("page_title" => $txtpagetitle, "page_menuname" => $txtmenuname, "status" => $txtstatus, "create_by" => $create_by, "create_date" => date("Y-m-d"),"department_id" => $txtdepartment,);

			DB::table("speciality")->insert($ins_array);
			$editid 	= DB::getPdo()->lastInsertId();

			$ins_slug_arr		= array("page_slug" => Str::slug($txtpagetitle." ".$editid));
			DB::table("speciality")->where("id", $editid)->update($ins_slug_arr);

			$success						= 'ok';

		}




        $alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']			= $success;



		return view('createspeciality')->with("alldatas", $alldatas);

	}


	public function specialitylist(Request $request){

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

		$alldatas['getallpostdatas'] 		= Common::getallspecialitydatas($txtposttitle, $txtcreatedby, $txtposteddate,$txtstatus_final);

		$alldatas['bindedtxtposttitle'] 	= $txtposttitle;
		$alldatas['bindedtxtcreatedby'] 	= $txtcreatedby;
		$alldatas['bindedtxtposteddate'] 	= $txtposteddate;
		$alldatas['bindedtxtstatus']		= $txtstatus_final;

        $alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();


		return view('specialitylist')->with("alldatas", $alldatas);

	}

	public function deletespeciality(Request $request){

		if ($request->isMethod('post')) {


			$txtdelid = $request->input('delid');

			if($txtdelid!=""){
				DB::table('speciality')->where('id', '=', $txtdelid)->delete();
			}

			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}

	}

	public function editspeciality(Request $request){

		$adminid 			= Session::get('adminid');
		$editId 			= $request->id;

		if(!(isset($adminid))){
			return Redirect::to("/");
		}

		if($editId==""){
			return abort(404);
		}
		else{

			$ss = Common::fetchspecialitydatas($editId);

			if(sizeof($ss)=="0"){
				return abort(404);
			}

		}


		$success						= '';

		$success						= '';
		$currenttab						= 1;
		$editid							= '';
		$successtype					= '';

		if ($request->isMethod('post')) {

			if($request->input('hidsubmitfrm1')!=""){

				$txtmenuname		= $request->input('txtmenuname');
				$txtpagetitle		= $request->input('txtpagetitle');
				$txtstatus			= $request->input('txtstatus');
                $txtdepartment		= $request->input('txtdepartment');
				$hideditid1			= $request->input('hideditid1');

				$ins_array		= array("page_title" => $txtpagetitle, "page_menuname" => $txtmenuname, "status" => $txtstatus, "page_slug" => Str::slug($txtpagetitle." ".$hideditid1),"department_id" =>$txtdepartment	,);

				DB::table("speciality")->where("id", $hideditid1)->update($ins_array);

				$success						= 'General information updated successfully';
				$currenttab						= 1;

			} // if($request->input('hidsubmitfrm1')!=""){

			if($request->input('hidsubmitfrm2')!=""){

				$hideditid2			= $request->input('hideditid2');
				$txtbannertitle		= $request->input('txtbannertitle');
				$txtbannersubtitle	= $request->input('txtbannersubtitle');
				$txtbannerphonebtn	= $request->input('txtbannerphonebtn');
				$txtappointmentbtn	= $request->input('txtappointmentbtn');
				$txtbannerstatus	= $request->input('txtbannerstatus');

				if(isset($request->txtbannerimgfile)){

					$gallerydatas	= Common::fetchspecialitybannerdatas($hideditid2);
					if(sizeof($gallerydatas)!="0"){
						$gallery_image	= $gallerydatas[0]->banner_image;

						if($gallery_image!=""){
							@unlink(public_path("medias/").$gallery_image);
						}
					}

					$imageName = time().'.'.$request->txtbannerimgfile->extension();
					$request->txtbannerimgfile->move(public_path('medias'), $imageName);
				}
				else{
					$imageName = '';
				}


				$chckexistornot 	= Common::fetchspecialitybannerdatas($hideditid2);

				if(sizeof($chckexistornot)=="0"){
					if($imageName==""){
						$insarray = array("banner_title" => $txtbannertitle,"banner_sub_title" => $txtbannersubtitle, "banner_phonenumber_button" => $txtbannerphonebtn, "banner_appointment_button" => $txtappointmentbtn, "banner_status" => $txtbannerstatus, "speciality_refid" => $hideditid2 );
						DB::table("speciality_banner")->insert($insarray);
					}
					else{
						$insarray = array("banner_title" => $txtbannertitle,"banner_sub_title" => $txtbannersubtitle, "banner_phonenumber_button" => $txtbannerphonebtn, "banner_appointment_button" => $txtappointmentbtn, "banner_status" => $txtbannerstatus, "banner_image" =>  $imageName, "speciality_refid" => $hideditid2);
						DB::table("speciality_banner")->insert($insarray);


					}
				}
				else{
					if($imageName==""){
						$insarray = array("banner_title" => $txtbannertitle,"banner_sub_title" => $txtbannersubtitle, "banner_phonenumber_button" => $txtbannerphonebtn, "banner_appointment_button" => $txtappointmentbtn, "banner_status" => $txtbannerstatus );
						DB::table("speciality_banner")->where("speciality_refid", $hideditid2)->update($insarray);
					}
					else{
						$insarray = array("banner_title" => $txtbannertitle,"banner_sub_title" => $txtbannersubtitle, "banner_phonenumber_button" => $txtbannerphonebtn, "banner_appointment_button" => $txtappointmentbtn, "banner_status" => $txtbannerstatus, "banner_image" =>  $imageName );
						DB::table("speciality_banner")->where("speciality_refid", $hideditid2)->update($insarray);
					}
				}

				$success						= 'Banner information updated successfully';
				$currenttab						= 2;

			} // if($request->input('hidsubmitfrm2')!=""){

			if($request->input('hidsubmitfrm3')!=""){


				$txtsectiononetitle		= $request->input('txtsectiononetitle');
				$txtsectiononesubtitle	= $request->input('txtsectiononesubtitle');
				$txtsectiononestatus	= $request->input('txtsectiononestatus');
				$hidsubmitfrm3			= $request->input('hidsubmitfrm3');
				$hideditid3				= $request->input('hideditid3');

				$chckexistornot 	= Common::fetchspecialitysectiononedatas($hideditid3);
				if(sizeof($chckexistornot)=="0"){
					$insarray = array("title" => $txtsectiononetitle,"sub_title" => $txtsectiononesubtitle, "status" => $txtsectiononestatus, "speciality_refid" => $hideditid3 ,);
					DB::table("speciality_sectionone")->insert($insarray);
				}
				else{
					$insarray = array("title" => $txtsectiononetitle,"sub_title" => $txtsectiononesubtitle, "status" => $txtsectiononestatus ,);
					DB::table("speciality_sectionone")->where("speciality_refid", $hideditid3)->update($insarray);
				}

				$success						= 'Section 1 information updated successfully';
				$currenttab						= 3;

			} // if($request->input('hidsubmitfrm3')!=""){

			if($request->input('hidsubmitfrm31')!=""){

				$hideditid31				= $request->input('hideditid31');
				$txtsectiononecaption		= $request->input('txtsectiononecaption');
                $txtsectiononesort_order	= $request->input('sort_order');
				if(isset($request->txtsectiononefile)){
					$imageName = time().'.'.$request->txtsectiononefile->extension();
					$request->txtsectiononefile->move(public_path('medias'), $imageName);
				}
				else{
					$imageName = "";
				}

				$insarray = array("caption" => $txtsectiononecaption,"image_file" => $imageName, "speciality_refid" => $hideditid31,"sort_order" => $txtsectiononesort_order);
				DB::table("speciality_sectionone_image")->insert($insarray);

				$success						= 'Section 1 information updated successfully';
				$currenttab						= 3;



			} // if($request->input('hidsubmitfrm31')!=""){

			if($request->input('hidsubmitfrm5')!=""){

				$hideditid5				= $request->input('hideditid5');
				$txtsectionfivetitle	= $request->input('txtsectionfivetitle');
				$txtsectionfivestatus	= $request->input('txtsectionfivestatus');

				$chckexistornot 	= Common::fetchspecialitysectionfivedatas($hideditid5);

				if(sizeof($chckexistornot)=="0"){
					$insarray = array("title" => $txtsectionfivetitle, "status" => $txtsectionfivestatus, "speciality_refid" => $hideditid5);
					DB::table("speciality_sectiontwo")->insert($insarray);
				}
				else{
					$insarray = array("title" => $txtsectionfivetitle, "status" => $txtsectionfivestatus);
					DB::table("speciality_sectiontwo")->where("speciality_refid", $hideditid5)->update($insarray);
				}

				$success						= 'Section 2 information updated successfully';
				$currenttab						= 5;

			} // if($request->input('hidsubmitfrm5')!=""){

			if($request->input('hidsubmitfrm51')!=""){

				$hideditid51				= $request->input('hideditid51');
				$txtsectiontwocaption		= $request->input('txtsectiontwocaption');
				$txtsectiontwodescription	= $request->input('txtsectiontwodescription');
                $txtsectiontwosort_order	= $request->input('sort_order2');



				if(isset($request->txtsectiontwofile)){
					$imageName = time().'.'.$request->txtsectiontwofile->extension();
					$request->txtsectiontwofile->move(public_path('medias'), $imageName);
				}
				else{
					$imageName = "";
				}

				$insarray = array("caption" => $txtsectiontwocaption, "description" => $txtsectiontwodescription,"image_file" => $imageName, "speciality_refid" => $hideditid51,"sort_order"=>$txtsectiontwosort_order);
				DB::table("speciality_sectiontwo_image")->insert($insarray);

				$success						= 'Section 2 information updated successfully';
				$currenttab						= 5;

			} // if($request->input('hidsubmitfrm51')!=""){

			if($request->input('hidsubmitfrm6')!=""){

				$hideditid6				= $request->input('hideditid6');
				$txtsectionsixtitle	= $request->input('txtsectionsixtitle');
				$txtsectionsixstatus	= $request->input('txtsectionsixstatus');

				$chckexistornot 	= Common::fetchspecialitysectionsixdatas($hideditid6);

				if(sizeof($chckexistornot)=="0"){
					$insarray = array("title" => $txtsectionsixtitle, "status" => $txtsectionsixstatus, "speciality_refid" => $hideditid6);
					DB::table("speciality_sectionthree")->insert($insarray);
				}
				else{
					$insarray = array("title" => $txtsectionsixtitle, "status" => $txtsectionsixstatus);
					DB::table("speciality_sectionthree")->where("speciality_refid", $hideditid6)->update($insarray);
				}

				$success						= 'Section 3 information updated successfully';
				$currenttab						= 6;

			} // if($request->input('hidsubmitfrm6')!=""){

			if($request->input('hidsubmitfrm61')!=""){

				$hideditid61				= $request->input('hideditid61');
				$txtsectionthreecaption		= $request->input('txtsectionthreecaption');
				$txtsectionthreedescription	= $request->input('txtsectionthreedescription');
				$txtsectionthreesort_order	= $request->input('sort_order5');




				if(isset($request->txtsectionthreefile)){
					$imageName = time().'.'.$request->txtsectionthreefile->extension();
					$request->txtsectionthreefile->move(public_path('medias'), $imageName);
				}
				else{
					$imageName = "";
				}

				$insarray = array("caption" => $txtsectionthreecaption, "description" => $txtsectionthreedescription,"image_file" => $imageName, "speciality_refid" => $hideditid61 , "sort_order"=>$txtsectionthreesort_order);
				DB::table("speciality_sectionthree_image")->insert($insarray);

				$success						= 'Section 3 information updated successfully';
				$currenttab						= 6;

			} // if($request->input('hidsubmitfrm61')!=""){

		}

		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']			= $success;
		$alldatas['currenttab']			= $currenttab;
		$alldatas['editid']				= $editId;

		$alldatas['fetchdoctordatas']	= Common::fetchdoctordatas($editId);
		$alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();

		$alldatas['fetchpostsdatas'] 					= Common::fetchspecialitydatas($editId);
		$alldatas['fetchspecialitybannerdatas'] 		= Common::fetchspecialitybannerdatas($editId);

		$alldatas['fetchspecialitysectiononedatas'] 		= Common::fetchspecialitysectiononedatas($editId);
		$alldatas['fetchspecialitysectiononeimgdatas'] 		= Common::fetchspecialitysectiononeimgdatas($editId);

		$alldatas['fetchspecialitysectionfivedatas'] 		= Common::fetchspecialitysectionfivedatas($editId);
		$alldatas['fetchspecialitysectiontwoimgdatas'] 		= Common::fetchspecialitysectiontwoimgdatas($editId);

		$alldatas['fetchspecialitysectionsixdatas'] 		= Common::fetchspecialitysectionsixdatas($editId);
		$alldatas['fetchspecialitysectionthreeimgdatas'] 		= Common::fetchspecialitysectionthreeimgdatas($editId);

		return view('editspeciality')->with("alldatas", $alldatas);

	}

	public function updatespecialitysortorder(Request $request){

		if ($request->isMethod('post')) {

			$txtsort 	= $request->input('txtsort');
			$editid 	= $request->input('editid');

			if($editid!=""){

				$ins_array		= array("sort_order" => $txtsort);
				$update 		= DB::table("speciality")->where("id", $editid)->update($ins_array);

			}

			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}

	}

	public function deletesectiononeimage(Request $request){

		if ($request->isMethod('post')) {


			$txtdelid = $request->input('delid');

			if($txtdelid!=""){
				DB::table('speciality_sectionone_image')->where('id', '=', $txtdelid)->delete();
			}

			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}

	}

	public function deletesectiontwoimage(Request $request){

		if ($request->isMethod('post')) {


			$txtdelid = $request->input('delid');

			if($txtdelid!=""){
				DB::table('speciality_sectiontwo_image')->where('id', '=', $txtdelid)->delete();
			}

			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}

	}

	//

	public function deletesectionthreeimage(Request $request){

		if ($request->isMethod('post')) {


			$txtdelid = $request->input('delid');

			if($txtdelid!=""){
				DB::table('speciality_sectionthree_image')->where('id', '=', $txtdelid)->delete();
			}

			return Response::json(array('status_code' => '1','datas' => array()));
		}
		else{
			return Response::json(array('status_code' => '0','datas' => array()));
		}

	}

    public function updatesectionthreeimage(Request $request){


                $product= DB::table('speciality_sectionthree_image')->where('id', '=', $request->id)->get();

            return response()->json($product);


	}


    public function editsectionthreeimage(Request $request){



$validator = Validator::make($request->all(), [
    'edit_txtsectionthreefile3' => 'nullable|image|mimetypes:jpeg,png,jpg|max:2048',
    'edit_txtsectionthreedescription3' => 'required',
    'edit_txtsectionthreecaption3' => 'required',
    // 'sort_order4' => 'required'
]);

if ($validator->fails()) {
    return response()->json([
        'status' => 400,
        'errors' => $validator->messages(),
    ]);
}

// if (!$request->hasFile('edit_txtsectionthreefile3') && !$request->hasFile('discription_image')) {
//     return response()->json([
//         'status' => 400,
//         'errors' => ['edit_txtsectionthreefile3' => ['At least one file must be provided.']],
//     ]);
// }

if (!$request->has('id3')) {
    return response()->json([
        'status' => 400,
        'errors' => ['id3' => ['ID is required.']],
    ]);
}

$product = DB::table('speciality_sectionthree_image')->where('id', $request->id3)->first();

if (!$product) {
    return response()->json([
        'status' => 400,
        'errors' => ['id3' => ['Invalid ID.']],
    ]);
}

$imageName = $product->image_file;
$discrption_image = $product->discription_image;

if ($request->hasFile('edit_txtsectionthreefile3')) {
    $imageName = time() . '.' . $request->edit_txtsectionthreefile3->extension();
    $request->edit_txtsectionthreefile3->move(public_path('medias'), $imageName);
}

if ($request->hasFile('discription_image')) {
    $imgData = [];
    foreach ($request->file('discription_image') as $file) {
        $name = $file->getClientOriginalName();
        $file->move(public_path().'/medias/', $name);
        $imgData[] = $name;
    }
    $discrption_image = json_encode($imgData);
}

DB::table('speciality_sectionthree_image')->where('id', $request->id3)->update([
    'caption' => $request->edit_txtsectionthreecaption3,
    'description' => $request->edit_txtsectionthreedescription3,
    'image_file' => $imageName,
    'sort_order' => $request->sort_order4 ?? $product->sort_order,
    'discription_image' => $discrption_image,
]);


    return response()->json([
        'status' => 200,
        'message' => 'Section 3 Updated Successfully'
    ]);



}

public function updatesection_oneimage(Request $request){


    $product= DB::table('speciality_sectionone_image')->where('id', '=', $request->id)->get();

return response()->json($product);


}


public function editsection_oneimage(Request $request){


// dd($request->all());

$validator = Validator::make($request->all(),[
'edit_txtsectionthreefile' => 'nullable|mimes:jpeg,png,jpg|max:2048',
'edit_txtsectionthreecaption' => 'required',
'sort_order1'=>'required'

]);

if($validator->fails()){
    return response()->json([
    'status' => 400,
    'errors' => $validator->messages(),
]);
}else{

    if($request->edit_txtsectionthreefile == ""){

        $product=DB::table('speciality_sectionone_image')->where('id', $request->id)->update(['caption' => $request->edit_txtsectionthreecaption ,'sort_order' => $request->sort_order1]);

    }
    else{
            if(isset($request->edit_txtsectionthreefile)){
                $imageName = time().'.'.$request->edit_txtsectionthreefile->extension();
                $request->edit_txtsectionthreefile->move(public_path('medias'), $imageName);
            }
            $product=DB::table('speciality_sectionone_image')->where('id', $request->id)->update(['caption' => $request->edit_txtsectionthreecaption ,'image_file' =>$imageName,'sort_order' => $request->sort_order1]);

    }

    return response()->json([
        'status' => 200,
        'message' => 'Section 1 Updated  Successfully'
    ]);

    // return response()->json($product);

}

// $product= DB::table('speciality_sectionthree_image')->where('id', '=', $request->id)->get();






}



public function updatesection_twoimage(Request $request){


    $product= DB::table('speciality_sectiontwo_image')->where('id', '=', $request->id)->get();

return response()->json($product);


}


public function editsection_twoimage(Request $request){


// dd($request->all());

$validator = Validator::make($request->all(),[
'edit_txtsectionthreefile2' => 'nullable|mimes:jpeg,png,jpg',
'edit_txtsectionthreedescription2' =>'required',
'edit_txtsectionthreecaption2' => 'required',
'sort_order3' => 'required',

]);

if($validator->fails()){
    return response()->json([
    'status' => 400,
    'errors' => $validator->messages(),
]);
}else{


    if($request->edit_txtsectionthreefile2 == ""){
        $product=DB::table('speciality_sectiontwo_image')->where('id', $request->id2)->update(['caption' => $request->edit_txtsectionthreecaption2,'description' => $request->edit_txtsectionthreedescription2 , 'sort_order'=>$request->sort_order3]);
    }
    else{

        if(isset($request->edit_txtsectionthreefile2)){
            $imageName = time().'.'.$request->edit_txtsectionthreefile2->extension();
            $request->edit_txtsectionthreefile2->move(public_path('medias'), $imageName);
        }
            $product=DB::table('speciality_sectiontwo_image')->where('id', $request->id2)->update(['caption' => $request->edit_txtsectionthreecaption2 ,'description' => $request->edit_txtsectionthreedescription2 ,'image_file' => $imageName,'sort_order'=>$request->sort_order3 ]);


    }

    return response()->json([
        'status' => 200,
        'message' => 'Section 2 Updated  Successfully'
    ]);



}

// $product= DB::table('speciality_sectionthree_image')->where('id', '=', $request->id)->get();






}


public function updatespeciality_sectionone_sortorder(Request $request){

    if ($request->isMethod('post')) {

        $txtsort 	= $request->input('txtsort');
        $editid 	= $request->input('editid');

        if($editid!=""){

            $ins_array		= array("sort_order" => $txtsort);
            $update 		= DB::table("speciality_sectionone_image")->where("id", $editid)->update($ins_array);

        }

        return Response::json(array('status_code' => '1','datas' => array()));
    }
    else{
        return Response::json(array('status_code' => '0','datas' => array()));
    }

}

public function updatespeciality_sectiontwo_sortorder(Request $request){

    if ($request->isMethod('post')) {

        $txtsort 	= $request->input('txtsort');
        $editid 	= $request->input('editid');

        if($editid!=""){

            $ins_array		= array("sort_order" => $txtsort);
            $update 		= DB::table("speciality_sectiontwo_image")->where("id", $editid)->update($ins_array);

        }

        return Response::json(array('status_code' => '1','datas' => array()));
    }
    else{
        return Response::json(array('status_code' => '0','datas' => array()));
    }

}

public function updatespeciality_sectionthree_sortorder(Request $request){

    if ($request->isMethod('post')) {

        $txtsort 	= $request->input('txtsort');
        $editid 	= $request->input('editid');

        if($editid!=""){

            $ins_array		= array("sort_order" => $txtsort);
            $update 		= DB::table("speciality_sectionthree_image")->where("id", $editid)->update($ins_array);

        }

        return Response::json(array('status_code' => '1','datas' => array()));
    }
    else{
        return Response::json(array('status_code' => '0','datas' => array()));
    }

}

}

