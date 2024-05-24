<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Input;
use Session;
use Storage;
use Mail;
use Carbon\Carbon;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Common;
use App\Models\{
    ManageMatimonyProfiles,
    MangeCommunity,
    ManageSubsection,
    ManageCountry,
    ManageState,
    ManageCity
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ManageMatrimonyProfilesController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('lakshmi-kalyanam.profile.index', compact('alldatas'));
    }

    public function ShowMatrimonyProfiles(Request $request)
    {
        $profiles = ManageMatimonyProfiles::whereNull('deleted_at')
            ->orderby('id', 'desc')
            ->get();
        return response()->json(['status' => 200, 'data' => $profiles]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $community = MangeCommunity::all();
        $subsection = ManageSubsection::all();
        $country = ManageCountry::all();
        $state = ManageState::all();
        $city = ManageCity::all();
        $motherTongues = [
            'Hindi', 'Gujarati', 'Urdu', 'English', 'Punjabi', 'Tamil', 'Marathi', 'Telugu',
            'Malayalam', 'Bengali', 'Kannada', 'Sindhi', 'Konkani', 'Oriya', 'Assamese', 'Marwari',
            'Aka', 'Arabic', 'Arunachali', 'Awadhi', 'Baluchi', 'Bhojpuri', 'Bhutia', 'Brahui',
            'Brij', 'Burmese', 'Chattisgarhi', 'Chinese', 'Coorgi', 'Dogri', 'French', 'Garhwali',
            'Garo', 'Haryanavi', 'Himachali/Pahari', 'Hindko', 'Kakbarak', 'Kanauji', 'Kashmiri',
            'Khandesi', 'Khasi', 'Koshali', 'Kumaoni', 'Kutchi', 'Ladakhi', 'Lepcha', 'Magahi',
            'Maithili', 'Malay', 'Manipuri', 'Miji', 'Mizo', 'Monpa', 'Nepali', 'Pashto', 'Persian',
            'Rajasthani', 'Russian', 'Sanskrit', 'Santhali', 'Seraiki', 'Sinhala', 'Sourashtra',
            'Spanish', 'Swedish', 'Tagalog', 'Tulu', 'Other',
        ];
        return view('lakshmi-kalyanam.profile.create', compact('alldatas', 'community', 'subsection', 'country', 'state', 'city','motherTongues'));
    }

    public function GetTheSubsectioon(Request $request)
    {
        $array = $request->all();
        if (array_key_exists('search', $array)) {
            $search = $array['search'];

            if ($search == null) {
                $data = ManageSubsection::whereNull('deleted_at')->where('religion', '=', $request->id)->get();
            } else {
                $data = ManageSubsection::orderby('name', 'asc')->select('*')->where('name', 'like', '%' . $search . '%')->whereNull('deleted_at')->limit(6)->get();
            }
            return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
        } else {
            $data = ManageSubsection::select('*')->where('religion', '=', $request->id)->whereNull('deleted_at')->latest()->get();
            return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
        }
    }

    public function CreateTheProfile(Request $request)
    {
        // dd($request->all());
        $rules = [
            'profile_name' => 'required|string',
            'profile_gender' => 'required',
            'profile_dob' => 'required|date',
            'profile_mother_tongue' => 'required|string',
            'profile_community' => 'required',
            'profile_subsection' => 'required',
            'profile_acharyan' => 'required|string',
            'profile_spcl_ctgry' => 'required|string',
            'profile_mobile' => 'required|string|regex:/^(\+91[\-\s]?)?[789]\d{9}$/',
            'profile_mobilecode' => 'required',
            'profile_email' => 'required|email|unique:m4winreg_pass,ConfirmEmail',
            'profile_password' => 'required|string|min:8', // Adjust the minimum length as needed
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute must be a string.',
            'email' => 'The :attribute must be a valid email address.',
            'in' => 'The selected :attribute is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'digits' => 'The :attribute must be exactly :digits digits.',
            'regex' => 'The :attribute format is invalid.',
            'unique' => 'The :attribute has already been taken.',
            'date' => 'The :attribute must be a valid date.',
            'min' => 'The :attribute must be at least :min characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $age = Carbon::parse($request->profile_dob)->diffInYears(Carbon::now());
        // dd([
        //     'mem_id' => Session::get('admin_user_id'),
        //     'Prefix' => 'K',
        //     'Termsofservice' => '',
        //     'ConfirmEmail' => $request->profile_email,
        //     'ConfirmPassword' => md5($request->profile_password),
        //     'Name' => $request->profile_name,
        //     'Gender' => $request->profile_gender,
        //     'DOB' => $request->profile_dob,
        //     'Age' => $age,
        //     'Religion' => $request->profile_community,
        //     'Caste' => $request->profile_subsection,
        //     'acharyan' => $request->profile_acharyan,
        //     'Mobile' => $request->profile_mobile,
        //     'mobilecode' => $request->profile_mobilecode,
        //     'Status' => 'Active',
        //     'IP' => $request->ip(),
        //     'last_ip' => $request->ip(),
        //     'specialcategory' => $request->profile_spcl_ctgry,
        //     'mother_tongue' => $request->profile_mother_tongue
        // ]);
        $insert = ManageMatimonyProfiles::create([
            'mem_id' => Session::get('admin_user_id'),
            'Prefix' => 'K',
            'Termsofservice' => '',
            'ConfirmEmail' => $request->profile_email,
            'ConfirmPassword' => md5($request->profile_password),
            'Name' => $request->profile_name,
            'Gender' => $request->profile_gender,
            'DOB' => $request->profile_dob,
            'Age' => $age,
            'Religion' => $request->profile_community,
            'Caste' => $request->profile_subsection,
            'acharyan' => $request->profile_acharyan,
            'Mobile' => $request->profile_mobile,
            'mobilecode' => $request->profile_mobilecode,
            'Status' => 'Active',
            'IP' => $request->ip(),
            'last_ip' => $request->ip(),
            'specialcategory' => $request->profile_spcl_ctgry,
            'mother_tongue' => $request->profile_mother_tongue
        ]);
        $update = ManageMatimonyProfiles::find($insert->id)->update(['MatriID' => 'K' . $insert->id]);
        return response()->json($insert == true && $update == true ? ['status' => 200, 'message' => 'Profile has been created'] : ['status' => 400, 'message' => 'Failed to create profile']);
    }

    public function ChangeTheStatusOfProfile(Request $request)
    {
        $success_story = ManageMatimonyProfiles::find($request->id)->update([
            'Status' => $request->status
        ]);
        return response()->json($success_story == true ? ['status' => 200, 'message' => 'Status has been successfully changed'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $profile = ManageMatimonyProfiles::where('id', '=', $request->id)
            ->whereNull('deleted_at')
            ->get();
        $community = MangeCommunity::all();
        $subsection = ManageSubsection::where('religion','=',$profile[0]->Religion)->get();
        $motherTongues = [
            'Hindi', 'Gujarati', 'Urdu', 'English', 'Punjabi', 'Tamil', 'Marathi', 'Telugu',
            'Malayalam', 'Bengali', 'Kannada', 'Sindhi', 'Konkani', 'Oriya', 'Assamese', 'Marwari',
            'Aka', 'Arabic', 'Arunachali', 'Awadhi', 'Baluchi', 'Bhojpuri', 'Bhutia', 'Brahui',
            'Brij', 'Burmese', 'Chattisgarhi', 'Chinese', 'Coorgi', 'Dogri', 'French', 'Garhwali',
            'Garo', 'Haryanavi', 'Himachali/Pahari', 'Hindko', 'Kakbarak', 'Kanauji', 'Kashmiri',
            'Khandesi', 'Khasi', 'Koshali', 'Kumaoni', 'Kutchi', 'Ladakhi', 'Lepcha', 'Magahi',
            'Maithili', 'Malay', 'Manipuri', 'Miji', 'Mizo', 'Monpa', 'Nepali', 'Pashto', 'Persian',
            'Rajasthani', 'Russian', 'Sanskrit', 'Santhali', 'Seraiki', 'Sinhala', 'Sourashtra',
            'Spanish', 'Swedish', 'Tagalog', 'Tulu', 'Other',
        ];
        return view('lakshmi-kalyanam.profile.edit', compact('profile', 'alldatas','motherTongues','community','subsection'));
    }

    public function UpdateTheProfile(Request $request)
    {
        $rules = [
            'profile_name' => 'required|string',
            'profile_gender' => 'required',
            'profile_dob' => 'required|date',
            'profile_mother_tongue' => 'required|string',
            'profile_community' => 'required',
            'profile_subsection' => 'required',
            'profile_acharyan' => 'required|string',
            'profile_spcl_ctgry' => 'required|string',
            'profile_mobile' => 'required|string|regex:/^(\+91[\-\s]?)?[789]\d{9}$/',
            'profile_mobilecode' => 'required',
            'profile_email' => [
                'required',
                'email',
                Rule::unique('m4winreg_pass', 'ConfirmEmail')->ignore($request->id),
            ]
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute must be a string.',
            'email' => 'The :attribute must be a valid email address.',
            'in' => 'The selected :attribute is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'digits' => 'The :attribute must be exactly :digits digits.',
            'regex' => 'The :attribute format is invalid.',
            'unique' => 'The :attribute has already been taken.',
            'date' => 'The :attribute must be a valid date.',
            'min' => 'The :attribute must be at least :min characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }

        $age = Carbon::parse($request->profile_dob)->diffInYears(Carbon::now());
        $update = ManageMatimonyProfiles::find($request->id)->update([
            'ConfirmEmail' => $request->profile_email,
            'ConfirmPassword' => md5($request->profile_password),
            'Name' => $request->profile_name,
            'Gender' => $request->profile_gender,
            'DOB' => $request->profile_dob,
            'Age' => $age,
            'Religion' => $request->profile_community,
            'Caste' => $request->profile_subsection,
            'acharyan' => $request->profile_acharyan,
            'Mobile' => $request->profile_mobile,
            'mobilecode' => $request->profile_mobilecode,
            'IP' => $request->ip(),
            'last_ip' => $request->ip(),
            'specialcategory' => $request->profile_spcl_ctgry,
            'mother_tongue' => $request->profile_mother_tongue
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Profile has been updated'] : ['status' => 400, 'message' => 'Failed to update profile']);
    }

    public function DeleteTheProfile(Request $request)
    {
        $profile_delete = ManageMatimonyProfiles::find($request->id)->delete();
        return response()->json($profile_delete == true ? ['status' => 200, 'message' => 'Profile deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

}
