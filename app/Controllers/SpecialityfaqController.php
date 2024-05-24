<?php

namespace App\Http\Controllers;

use App\Models\Specialityfaq;
use Illuminate\Http\Request;
use DB;
use Input;
use Session;
use Storage;


use App\Common;

class SpecialityfaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        $adminid = Session::get('adminid');

		if(!(isset($adminid))){
			return Redirect::to("/");
		}

		$success						= '';

		if ($request->isMethod('post')) {



			$txtmenuname		= $request->input('txtmenuname');
			$txtpagetitle		= $request->input('txtpagetitle');
			$txtstatus			= $request->input('txtstatus');

			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");
			$create_by 			= $getmyprofiledatas[0]->id;

			$ins_array		= array("page_title" => $txtpagetitle, "page_menuname" => $txtmenuname, "status" => $txtstatus, "create_by" => $create_by, "create_date" => date("Y-m-d"));

			DB::table("speciality")->insert($ins_array);
			$editid 	= DB::getPdo()->lastInsertId();

			$ins_slug_arr		= array("page_slug" => Str::slug($txtpagetitle." ".$editid));
			DB::table("speciality")->where("id", $editid)->update($ins_slug_arr);

			$success						= 'ok';

		}





		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']			= $success;

        $speciality_data = DB::table('speciality')->where('id',$id)->get();

        $speciality_faqs = DB::table('specialityfaq')->where('speciality_id',$id)->get();
// dd($docdata);
		return view('specialityfaq',compact('alldatas','speciality_data','speciality_faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        Specialityfaq::create($input);
        return redirect()->back()->with('success','FAQ has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specialityfaq  $specialityfaq
     * @return \Illuminate\Http\Response
     */
    public function show(Specialityfaq $specialityfaq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialityfaq  $specialityfaq
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $adminid = Session::get('adminid');

		if(!(isset($adminid))){
			return Redirect::to("/");
		}

		$success						= '';

		if ($request->isMethod('post')) {



			$txtmenuname		= $request->input('txtmenuname');
			$txtpagetitle		= $request->input('txtpagetitle');
			$txtstatus			= $request->input('txtstatus');

			$getmyprofiledatas 	= DB::select("select * from adminusers where email = '".$adminid."' limit 0,1");
			$create_by 			= $getmyprofiledatas[0]->id;

			$ins_array		= array("page_title" => $txtpagetitle, "page_menuname" => $txtmenuname, "status" => $txtstatus, "create_by" => $create_by, "create_date" => date("Y-m-d"));

			DB::table("speciality")->insert($ins_array);
			$editid 	= DB::getPdo()->lastInsertId();

			$ins_slug_arr		= array("page_slug" => Str::slug($txtpagetitle." ".$editid));
			DB::table("speciality")->where("id", $editid)->update($ins_slug_arr);

			$success						= 'ok';

		}





		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']			= $success;



        $speciality_faqs = DB::table('specialityfaq')->where('id',$id)->get();

        $speciality_data = DB::table('speciality')->where('id',$speciality_faqs[0]->speciality_id )->get();


// dd($docdata);
		return view('editspecialityfaq',compact('alldatas','speciality_data','speciality_faqs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialityfaq  $specialityfaq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $specialityfaq = Specialityfaq::find($id);
        $specialityfaq->title = $request->title;
        $specialityfaq->description = $request->description;
        $specialityfaq->order_id = $request->order_id;
        $specialityfaq->status = $request->status;
        $specialityfaq->speciality_id = $request->speciality_id;
        $specialityfaq->save();

        return redirect()->route('specialityfaq.index',$specialityfaq->speciality_id)->with('success','FAQ has been Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialityfaq  $specialityfaq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialityfaq = Specialityfaq::find($id);
        $id= $specialityfaq->speciality_id;
        $specialityfaq->delete();

        return  redirect()->route('specialityfaq.index',$id)->with('success','FAQ has been Deleted successfully.');
    }
}
