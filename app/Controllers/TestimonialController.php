<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use DB;
use Input;
use Session;
use Storage;
use App\Common;

class TestimonialController extends Controller
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


        $testimonial=Testimonial::all();
            $speciality = DB::table('speciality')->where('status', "1")->get();
            $doctors = DB::table('doctors')->where('status', "1")->get();
            $packages = DB::table('package')->where('status', "1")->get();




        return view('listvideo_testimonial',compact('alldatas','testimonial','speciality','doctors','packages'));
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

        $speciality = DB::table('speciality')->where('status', "1")->get();
        $doctors = DB::table('doctors')->where('status', "1")->get();
        $packages = DB::table('package')->where('status', "1")->get();

        // dd($speciality);
        // sort_order


        return view('createvideo_testimonial',compact('alldatas','speciality','doctors','packages'));
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
            $this->validate($request, [
                'name' => 'required',
                'status' => 'required',
                'title' => 'required',
                // 'testimonial_video' =>'required',
                'testimonial_image' =>'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'description' => 'required',

            ]);

            $testimonial = new Testimonial;

            $testimonial->name = $request->name;
            $testimonial->status = $request->status;
            $testimonial->description = $request->description;
            $testimonial->speciality_id = $request->speciality_id;
            $testimonial->doctor_id = $request->doctor_id;
            $testimonial->package_id = $request->package_id;
            $testimonial->title = $request->title;
            $testimonial->testmonial_video = $request->testimonial_video;

            // if($request->testimonial_image==""){

            //     if ($request->hasFile('testimonial_video'))
            //     {
            //     $path = $request->file('testimonial_video')->store('testimonial_video', ['disk'=>'my_files']);
            //     $testimonial->testmonial_video = $path;
            //     }

            // }else{

                if(isset($request->testimonial_image)){
                    $imageName = time().'.'.$request->testimonial_image->extension();
                    $request->testimonial_image->move(public_path('medias'), $imageName);
                    $testimonial->testmonial_image = $imageName;
                }

            // }

      $testimonial->save();

      return  redirect()->route('testimonial.index')->with('success','Testimonial has been Added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
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



        $testimonial=Testimonial::find($id);
        $speciality = DB::table('speciality')->where('status', "1")->get();
        $doctors = DB::table('doctors')->where('status', "1")->get();
        $packages = DB::table('package')->where('status', "1")->get();

        return view('editvideo_testimonial',compact('alldatas','testimonial','speciality','doctors','packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'title' => 'required',
            'testimonial_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
        ]);
        $testimonial=Testimonial::find($id);
        $testimonial->name = $request->name;
        $testimonial->status = $request->status;
        $testimonial->description = $request->description;
        $testimonial->speciality_id = $request->speciality_id;
            $testimonial->doctor_id = $request->doctor_id;
            $testimonial->package_id = $request->package_id;
            $testimonial->title = $request->title;
            $testimonial->testmonial_video = $request->testimonial_video;


            // if ($request->hasFile('testimonial_video'))
            // {
            // $path = $request->file('testimonial_video')->store('testimonial_video', ['disk'=>'my_files']);
            // $testimonial->testmonial_video = $path;
            // }

            if(isset($request->testimonial_image)){
                $imageName = time().'.'.$request->testimonial_image->extension();
                $request->testimonial_image->move(public_path('medias'), $imageName);
                $testimonial->testmonial_image = $imageName;
            }

           $testimonial->save();

  return  redirect()->route('testimonial.index')->with('success','Testimonial has been updated successfully.');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return  redirect()->route('testimonial.index')->with('success','Testimonial has been Deleted successfully.');
    }
}
