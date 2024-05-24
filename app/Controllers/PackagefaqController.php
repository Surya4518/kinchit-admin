<?php

namespace App\Http\Controllers;

use App\Models\Packagefaq;
use Illuminate\Http\Request;
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

class PackagefaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,)
    {
        $adminid 			= Session::get('adminid');
		$editId 			= $request->id;

		if(!(isset($adminid))){
			return Redirect::to("/");
		}

			$ss = Common::fetchpackagedatas($editId);

			if(sizeof($ss)=="0"){
				return abort(404);
			}

		// }


		$success						= '';

		//

		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['successmsg']			= $success;

		$alldatas['fetchpostsdatas']= Common::fetchpackagedatas($editId);



        $package= DB::table('package')->get();
        $package_faq= Packagefaq::all();

		return view('packagefaqlist',compact('package','alldatas','package_faq'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,)
    {
        $adminid 			= Session::get('adminid');
		$editId 			= $request->id;

		if(!(isset($adminid))){
			return Redirect::to("/");
		}

		// if($editId==""){
		// 	return abort(404);
		// }
		// else{

			$ss = Common::fetchpackagedatas($editId);

			if(sizeof($ss)=="0"){
				return abort(404);
			}

		// }


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

		$alldatas['fetchpostsdatas']= Common::fetchpackagedatas($editId);



        $package= DB::table('package')->get();

// dd($package);
		return view('packagefaq',compact('package','alldatas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $input = $request->all();
        Packagefaq::create($input);
        return redirect()->back()->with('success','FAQ has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Packagefaq  $packagefaq
     * @return \Illuminate\Http\Response
     */
    public function show(Packagefaq $packagefaq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Packagefaq  $packagefaq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

        $package= DB::table('package')->get();
        $package_faq= Packagefaq::find($id);
		return view('editpackagefaq',compact('package','alldatas','package_faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Packagefaq  $packagefaq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $package_faq = Packagefaq::find($id);
        $package_faq->title = $request->title;
        $package_faq->description = $request->description;
        $package_faq->order_id = $request->order_id;
        $package_faq->status = $request->status;
        $package_faq->packages_id = $request->packages_id;
        $package_faq->save();

        return redirect()->route('packagefaq.index')->with('success','FAQ has been Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Packagefaq  $packagefaq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $packagefaq = Packagefaq::find($id);

        $packagefaq->delete();

        return  redirect()->route('packagefaq.index',)->with('success','FAQ has been Deleted successfully.');
    }
}
