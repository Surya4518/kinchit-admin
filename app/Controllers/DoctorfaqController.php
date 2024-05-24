<?php

namespace App\Http\Controllers;

use App\Models\Doctorfaq;
use Illuminate\Http\Request;

use DB;
use Input;
use Session;
use Storage;


use App\Common;

class DoctorfaqController extends Controller
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





        $docdata = DB::table('doctors')->where('id',$id)->get();

        $doctorfaqs = DB::table('doctorsfaq')->where('doctors_id',$id)->get();



        $alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']= $success;

		return view('doctorfaq' ,compact('alldatas','docdata','doctorfaqs'));






        // return view('doctorfaq');
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
        Doctorfaq::create($input);
        return redirect()->back()->with('success','FAQ has been created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctorfaq  $doctorfaq
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctorfaq  $doctorfaq
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

        $doctorfaqs = DB::table('doctorsfaq')->where('id',$id)->get();



        $docdata = DB::table('doctors')->where('id', $doctorfaqs[0]->doctors_id )->get();





        $alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']= $success;

		return view('edit_doctorfaq' ,compact('alldatas','docdata','doctorfaqs'));




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctorfaq  $doctorfaq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {


        $doctorfaqs = Doctorfaq::find($id);
        $doctorfaqs->title = $request->title;
        $doctorfaqs->description = $request->description;
        $doctorfaqs->order_id = $request->order_id;
        $doctorfaqs->status = $request->status;
        $doctorfaqs->doctors_id = $request->doctors_id;
        $doctorfaqs->save();


        return redirect()->route('doctorfaq.index',$doctorfaqs->doctors_id)->with('success','FAQ has been Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctorfaq  $doctorfaq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctorfaqs = Doctorfaq::find($id);
        $id= $doctorfaqs->doctors_id;
        $doctorfaqs->delete();

        return  redirect()->route('doctorfaq.index',$id)->with('success','FAQ has been Deleted successfully.');
    }
}
