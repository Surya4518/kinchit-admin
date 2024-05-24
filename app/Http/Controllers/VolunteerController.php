<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Input;
use Session;
use Storage;
use Mail;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Common;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $volunteer = User::where('parent', 'LIKE', '0')->whereNotNull('verified_at')
            ->orderBy('ID', 'ASC')
            ->get();
        return view('volunteer.index', compact('volunteer', 'alldatas'));
    }

    public function MemberIndex(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $volunteer = User::where('user_login', 'LIKE', $request->id)->whereNotNull('verified_at')
            ->orderBy('ID', 'ASC')
            ->get();
        return view('volunteer.members', compact('alldatas', 'volunteer'));
    }

    public function ShowVolunteer(Request $request)
    {
        $volunteer = User::where('parent', 'LIKE', '0')->whereNotNull('verified_at')
            ->orderBy('ID', 'ASC')
            ->get();
        return response()->json(['status' => 200, 'data' => $volunteer]);
    }

    public function ShowMemberBelowVolunteer(Request $request)
    {
        $members = User::where('parent', 'LIKE', $request->id)->whereNotNull('verified_at')
            ->orderBy('ID', 'ASC')
            ->get();
        return response()->json(['status' => 200, 'data' => $members]);
    }

    public function ApprovalRequest(Request $request)
    {
        $arr = [
            'from_id' => $request->from_user,
            'request_type' => $request->request_type,
            'request_reason' => $request->reason,
            'request_from' => $request->from_user,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $ins_app_request = DB::table('approval_requests')->insert($arr);
        return response()->json($ins_app_request == true ? ['status' => 200, 'message' => 'Request has been successfully sent'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function EditTheUserProfile(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
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
            ->whereNotNull('wpu6_users.verified_at')
            ->where('wpu6_users.ID', $request->id)
            ->get();
        return view('volunteer.edit', compact('user', 'alldatas'));
    }

    public function CreateTheUserProfile(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $volunteer = User::where('parent', 'LIKE', '0')->whereNotNull('verified_at')
            ->orderBy('ID', 'ASC')
            ->get();
        return view('volunteer.user-create', compact('volunteer', 'alldatas'));
    }

    public function CreateTheDataOfUser(Request $request)
    {
        $check = User::where('user_email', '=', $request->your_email)->orderby('ID','desc')->limit(1)->get();
        $rules = [
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'user_email' => 'required|email',
            'user_gender' => 'required',
            'user_sms_no' => [
                'required',
                'numeric', // Ensure it is a number
                'regex:/^\d{10}$/', // Example: Allow exactly 10 digits
            ],
            'user_wa_no' => [
                'required',
                'numeric', // Ensure it is a number
                'regex:/^\d{10}$/', // Example: Allow exactly 10 digits
            ],
            'date_birth' => 'required',
            'samasar' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city_name' => 'required',
            'state_name' => 'required',
            'country_name' => 'required',
            'pincode' => 'required',
            'qualification' => 'required',
            'workexp' => 'required',
            'special_interest' => 'required',
            'special_skill' => 'required',
            'user_type' => 'required',
            'user_username' => 'required|unique:wpu6_users,user_login',
            'user_password' => 'required',
            'user_photo' => 'required'
        ];
        if($request->user_type == 'member'){
            $rules = [
                'volunteer_id' => 'required'
            ];
            $parent = $request->volunteer_id;
            $username = $request->user_username;
        }elseif($request->user_type == 'volunteer'){
            $parent = '0';
            $uniqueNumber = Str::random(3);
            $username = 'VOL'.$uniqueNumber;
        }elseif($request->user_type == 'kalakshepam'){
            $parent = '3';
            $username = $request->user_username;
        }else{
            $parent = NULL;
            $username = $request->user_username;
        }
        if($check->count() > 0){
                if($check[0]->verified_at == null){
                    $rules = [
                        'your_email' => 'required|email|max:255',
                        'user_name' =>  'required|string|max:255',
                    ];
                }else{
                    $rules = [
                        'your_email' => 'required|email|max:255|unique:wpu6_users,user_email|unique:userprofile_dt,user_email',
                        'user_name' =>  'required|string|max:255|unique:wpu6_users,user_login',
                    ];
                }
            }
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }

        if ($request->file('user_photo')) {
            $image = $request->file('user_photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('user-images/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'user-images/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }

        $user_arr = [
            'parent' => $parent,
            'user_login' => $username,
            'user_pass' => md5($request->user_password),
            'user_nicename' => $request->user_first_name,
            'display_name' => $request->user_first_name . ' ' . $request->user_last_name,
            'user_email' => $request->user_email,
            'user_type' => $request->user_type,
            'verified_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s")
        ];
        $update = User::create($user_arr);
        $user_profile_arr = [
            'user_id' => $update->id,
            'first_name' => $request->user_first_name,
            'last_name' => $request->user_last_name,
            'last_name_2' => $request->user_last_name,
            'dob' => date("Y-m-d", strtotime($request->date_birth)),
            'gender' => $request->user_gender,
            'acharyan' => $request->samasar,
            'user_email' => $request->user_email,
            'phone_number' => $request->user_sms_no,
            'phone_number_wa' => $request->user_wa_no,
            'address_1' => $request->address1,
            'address_2' => $request->address2,
            'city' => $request->city_name,
            'state' => $request->state_name,
            'postcode' => $request->pincode,
            'country' => $request->country_name,
            'qualification' => $request->qualification,
            'hobbies' => $request->special_interest,
            'skills' => $request->speci_skill,
            'work_experience' => $request->workexp,
            'user_image' => $file_path,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $update1 = DB::table('userprofile_dt')->insert($user_profile_arr);
        return response()->json($update == true && $update1 == true ? ['status' => 200, 'message' => 'Successfully updated'] : ['status' => 400, 'message' => 'Failed to update']);
    }

    public function UpdateTheDataOfUser(Request $request)
    {
        $rules = [
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'user_email' => 'required|email|unique:wpu6_users, user_email,' .$request->id,
            'user_sms_no' => [
                'required',
                'numeric', // Ensure it is a number
                'regex:/^\d{10}$/', // Example: Allow exactly 10 digits
            ],
            'user_wa_no' => [
                'required',
                'numeric', // Ensure it is a number
                'regex:/^\d{10}$/', // Example: Allow exactly 10 digits
            ],
            'date_birth' => 'required',
            'samasar' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city_name' => 'required',
            'state_name' => 'required',
            'country_name' => 'required',
            'pincode' => 'required',
            'qualification' => 'required',
            'workexp' => 'required',
            'special_interest' => 'required',
            'special_skill' => 'required',
            'user_username' => 'required',
            'user_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $user_old_data = DB::table('userprofile_dt')->where('user_id', $request->user_edit_id)->get();

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
            'user_login' => $request->user_username,
            'user_nicename' => $request->user_first_name,
            'display_name' => $request->user_first_name . ' ' . $request->user_last_name,
            'user_email' => $request->user_email,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $user_profile_arr = [
            'first_name' => $request->user_first_name,
            'last_name' => $request->user_last_name,
            'last_name_2' => $request->user_last_name,
            'dob' => date("Y-m-d", strtotime($request->date_birth)),
            'gender' => $request->user_gender,
            'acharyan' => $request->samasar,
            'user_email' => $request->user_email,
            'phone_number' => $request->user_sms_no,
            'phone_number_wa' => $request->user_wa_no,
            'address_1' => $request->address1,
            'address_2' => $request->address2,
            'city' => $request->city_name,
            'state' => $request->state_name,
            'postcode' => $request->pincode,
            'country' => $request->country_name,
            'qualification' => $request->qualification,
            'hobbies' => $request->special_interest,
            'skills' => $request->speci_skill,
            'work_experience' => $request->workexp,
            'user_image' => $file_path,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = User::where('id', $request->user_edit_id)->update($user_arr);
        $update1 = DB::table('userprofile_dt')->where('user_id', $request->user_edit_id)->update($user_profile_arr);
        return response()->json($update == true && $update1 == true ? ['status' => 200, 'message' => 'Successfully updated'] : ['status' => 400, 'message' => 'Failed to update']);
    }

    public function DeleteTheUserImage(Request $request)
    {
        $delete_user_image = DB::table('userprofile_dt')->where('user_id', $request->id)->update(['user_image' => NULL, 'updated_at' => date("Y-m-d H:i:s")]);
        return response()->json($delete_user_image == true ? ['status' => 200, 'message' => 'Successfully deleted'] : ['status' => 400, 'message' => 'Failed to delete']);
    }

}
