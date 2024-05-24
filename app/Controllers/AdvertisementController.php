<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use DB;
use Input;
use Session;
use Storage;
use App\Common;
use Response;
class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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


		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();

        // $advertisements = Advertisement::all();
        $advertisements = Advertisement::orderBy('id', 'DESC')->get();

        return view('advertisementlist',compact('alldatas','advertisements'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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


		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();




        return view('advertisement',compact('alldatas',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
            'order_id' => 'required',
            'mv_order_id' => 'required',
            'mv_status' => 'required',
            'advertisement_image' =>'required|image|mimes:jpg,jpeg,png,bmp,tiff|max:5000',
        ]);
        $advertisement = new Advertisement;
        $advertisement->title=$request->title;
        $advertisement->status=$request->status;
        $advertisement->order_id=$request->order_id;
        $advertisement->mv_order_id=$request->mv_order_id;
        $advertisement->mv_status=$request->mv_status;
        if(isset($request->advertisement_image)){
            $imageName = time().'.'.$request->advertisement_image->extension();
            $request->advertisement_image->move(public_path('medias'), $imageName);
            $advertisement->advertisement_image = $imageName;
        }
        $advertisement->save();


        return  redirect()->route('advertisement.index')->with('success','Advertisement has been Added successfully !!.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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


		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

		$alldatas['fetchalldepartment'] 	= Common::fetchalldepartment();


        $advertisements = Advertisement::find($id);
        // $advertisements = Advertisement::orderBy('id', 'DESC')->get();
        return view('edit_advertisement',compact('alldatas','advertisements'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $advertisements = Advertisement::find($request->id);
        $advertisements->title=$request->title;
        $advertisements->status=$request->status;
        $advertisements->order_id=$request->order_id;
        $advertisements->mv_order_id=$request->mv_order_id;
        $advertisements->mv_status=$request->mv_status;
        if(isset($request->advertisement_image)){
            $imageName = time().'.'.$request->advertisement_image->extension();
            $request->advertisement_image->move(public_path('medias'), $imageName);
            $advertisements->advertisement_image = $imageName;
        }
        $advertisements->update();


        return  redirect()->route('advertisement.index')->with('success','Advertisement has been Updated successfully !!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisements = Advertisement::find($id);
        $advertisements->delete();

        return  redirect()->route('advertisement.index')->with('success','advertisement has been Deleted successfully.');
    }


    public function sortorder(Request $request){


        // dd($request->all());
        if ($request->isMethod('post')){

            $txtsort 	= $request->input('txtsort');
            $editid 	= $request->input('editid');

            if($editid!=""){

                $ins_array		= array("order_id" => $txtsort);
                $update 		= DB::table("advertisements")->where("id", $editid)->update($ins_array);

            }

            return Response::json(array('status_code' => '1','datas' => array()));
        }
        else{
            return Response::json(array('status_code' => '0','datas' => array()));
        }

    }


    public function mv_sortorder(Request $request){

        if ($request->isMethod('post')) {

            $txtsort 	= $request->input('txtsort');
            $editid 	= $request->input('editid');

            if($editid!=""){

                $ins_array		= array("mv_order_id" => $txtsort);
                $update 		= DB::table("advertisements")->where("id", $editid)->update($ins_array);

            }

            return Response::json(array('status_code' => '1','datas' => array()));
        }
        else{
            return Response::json(array('status_code' => '0','datas' => array()));
        }

    }

}
