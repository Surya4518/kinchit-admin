<?php

namespace App\Http\Controllers;

use App\Models\Artical;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;
use Input;
use Session;
use Storage;
use Response;
use App\Common;
use Illuminate\Support\Facades\Validator;

class ArticalController extends Controller
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

        $categorys = DB::table("categorys")->get();
        // $articals=Artical::all();
        $articals = Artical::with('category')->get();

        return view('list_articals',compact('alldatas','categorys','articals'));
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

        $categorys = DB::table("categorys")->get();

        // dd($categorys);
        // $advertisements = Advertisement::orderBy('id', 'DESC')->get();

        return view('articals',compact('alldatas','categorys'));
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
        Artical::create($input);
        return  redirect()->route('artical.index')->with('success','Artical has been Added successfully !!.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function show(Artical $artical)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artical  $artical
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

        $categorys = DB::table("categorys")->get();
        // $articals=Artical::all();
        // $articals = Artical::with('category')->get();
        $articals = Artical::find($id);
        return view('edit_artical',compact('alldatas','categorys','articals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $articals = Artical::find($id);
        $articals->topic=$request->topic;
        $articals->category_id=$request->category_id;
        $articals->link=$request->link;
        $articals->sort_order=$request->sort_order;
        $articals->status=$request->status;
        $articals->update();


        return  redirect()->route('artical.index')->with('success','Artical has been Updated successfully !!.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articals = Artical::find($id);
        $articals->delete();

        return  redirect()->route('artical.index')->with('success','Artical has been Deleted successfully.');
        
    }



    public function category_store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
            'status_code' => 400,
            'errors' => $validator->messages(),
        ]);
        }else{
        $input = $request->all();
        Category::create($input);
        return Response::json(array('status_code' => '200','message' => 'Category has been created successfully.'));
        }
    }

public function update_artical_sortorder(Request $request){

        if ($request->isMethod('post')) {

            $txtsort 	= $request->input('txtsort');
            $editid 	= $request->input('editid');

            if($editid!=""){

                $ins_array		= array("sort_order" => $txtsort);
                $update 		= DB::table("articals")->where("id", $editid)->update($ins_array);

            }

            return Response::json(array('status_code' => '1','datas' => array()));
        }
        else{
            return Response::json(array('status_code' => '0','datas' => array()));
        }

    }
}
