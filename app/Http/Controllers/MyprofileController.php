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
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class MyprofileController extends Controller
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


	public function myprofile(Request $request){



		$adminid = Session::get('adminid');


		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();

        $user = DB::table('wpu6_users')
            ->leftJoin('userprofile_dt', 'userprofile_dt.user_id', '=', 'wpu6_users.ID')
            ->select(
                'userprofile_dt.*',
                'wpu6_users.user_login AS userlogin',
                'wpu6_users.user_type AS user_type',
                'wpu6_users.user_pass AS userpassword',
                'wpu6_users.ID AS user_main_id',
                'wpu6_users.user_nicename AS nicename',
                'wpu6_users.user_email AS usermail',
                'wpu6_users.display_name AS displayname'
            )
            ->where('wpu6_users.ID', $request->id)
            ->get();

        return view('myprofile', compact('user', 'alldatas'));

	}

    public function UpdateMyProfile(Request $request)
    {
    $rules = [
        'user_first_name' => 'required|alpha',
        'user_last_name' => 'required|alpha',
        'user_email' => 'required',
        'user_sms_no' => 'required|numeric|digits:10',
        'date_birth' => 'required',
        'user_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'user_username' =>'required',
    ];
    $messages = [
        'required' => 'The :attribute field is required.',
        'mimes' => 'The :attribute must be a file of type: :values.'
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
    }
    $user_old_data = DB::table('userprofile_dt')->where('user_id',$request->user_edit_id)->get();

    if ($request->file('user_photo')) {
        $image = $request->file('user_photo');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('user-images/' . date("Y") . '/' . date("m"));
        $image->move($destinationPath, $filename);
        $file_path = 'user-images/' . date("Y") . '/' . date("m") . '/' . $filename;
    } else {
        $file_path = $user_old_data[0]->user_image;
    }

    $user_arr = [
        'user_nicename' => $request->user_first_name,
        'display_name' => $request->user_first_name.' '.$request->user_last_name,
        'user_email' => $request->user_email,
         'user_login' =>$request->user_username,
        'updated_at' => date("Y-m-d H:i:s")
    ];
    $user_profile_arr = [
        'first_name' => $request->user_first_name,
        'last_name' => $request->user_last_name,
        'dob' => date("Y-m-d",strtotime($request->date_birth)),
        'user_email' => $request->user_email,
        'phone_number' => $request->user_sms_no,
        
        'user_image' => $file_path,
        'updated_at' => date("Y-m-d H:i:s")
    ];
    $update = User::where('id', $request->user_edit_id)->update($user_arr);
    $update1 = DB::table('userprofile_dt')->where('user_id', $request->user_edit_id)->update($user_profile_arr);

    session(['adminid' => $request->user_username]);
    // dd(Session()->all());

    return response()->json($update == true && $update1 == true ? ['status' => 200, 'message' => 'Successfully updated'] : ['status' => 400, 'message' => 'Failed to update']);
}


}
