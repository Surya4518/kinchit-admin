<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use DB;
use Input;
use Session;
use Storage;
use App\Common;

class AppointmentController extends Controller
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


        // $testimonial=Testimonial::all();
            $appointments = DB::table('appointments')->orderBy('id', 'desc')->get();
        //     $doctors = DB::table('doctors')->where('status', "1")->get();
        //     $packages = DB::table('package')->where('status', "1")->get();

// dd( $appointments);


        return view('appointment',compact('alldatas','appointments'));


        // return view('appointment');
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

        $ip_appointments = DB::table('ip_enqueiry')->orderBy('id', 'desc')->get();

// dd($ip_appointments);

        return view('ip_appointment',compact('alldatas','ip_appointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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


        // $testimonial=Testimonial::all();
            $appointments = DB::table('appointments')->where('id',$id)->get();


        return view('appointment_view',compact('alldatas','appointments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {


        $appointment=Appointment::find($id);
        $appointment->status=$request->status;
        $appointment->save();

        return response()->json([
            'status' => 200,
            'message' => 'Appointment status has updated'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
