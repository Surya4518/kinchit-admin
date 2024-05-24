<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
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
use App\Models\{
    Requesttypes,
    User
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ExtrasController extends Controller
{
    public function GetRequestTypes(Request $request)
    {
        $user = User::where('user_login', '=', $request->user)->get();
        $data = Requesttypes::where('roll_type', 'like', '%' . $user[0]->user_type . '%')->get();
        return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
    }

    public function ChangePasswordPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('settings.change-password.index', compact('alldatas'));
    }

    public function ChangePassword(Request $request)
    {
        $rules = [
            'oldpass' => 'required',
            'newpass' => 'required|unique:wpu6_users,user_pass', // Assuming 'users' is the table name and 'password' is the column
            'connewpass' => 'required|same:newpass', // Add a rule to ensure the confirmation matches the new password
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'same' => 'The :attribute and :other must match.',
            'unique' => 'The :attribute has already been taken.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        if (User::where('user_pass', md5($request->oldpass))->doesntExist()) {
            return response()->json(['status' => 402, 'message' => 'The old password is incorrect.']);
        }
        if (User::where('user_pass', md5($request->newpass))->exists()) {
            return response()->json(['status' => 402, 'message' => 'The new password is not unique.']);
        }
        $admin_id = Session::get('admin_user_id');
        $update = User::where('ID', $admin_id)->where('user_pass', md5($request->oldpass))->update(['user_pass' => md5($request->newpass)]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Password successfully updated.'] : ['status' => 400, 'message' => 'Failed to  update password.']);
    }

    public function SiteConfigurationPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $cofig_details = DB::table('site_configs')->limit(1)->get();
        return view('settings.site-configuration.index', compact('alldatas', 'cofig_details'));
    }

    public function UpdateSiteConfigurations(Request $request)
    {
        $arr = [
            'web_name' => $request->website_name,
            'web_friendly_name' => $request->websitefrnd_name,
            'web_logo' => $request->websitelogo_name,
            'web_title' => $request->websitetitle_name,
            'meta_descp' => $request->websitedes_name,
            'meta_key' => $request->websitekey_name,
            'web_footer' => $request->websitefoot_name,
            'google_analytics' => $request->websitegoogle_name,
            'from_email' => $request->email_name,
            'to_email' => $request->to_email_name,
            'feedback_email' => $request->feed_name,
            'enquiry_email' => $request->enquiry_name,
            'header_ph_no' => $request->headph_name,
            'admin_email' => $request->adem_name,
            'smtp_host' => $request->host_name,
            'smtp_username' => $request->smtuser_name,
            'smtp_pass' => $request->passwr_name,
            'port_type' => $request->smtp_port_type,
            'port_no' => $request->smtp_port_no,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $update = DB::table('site_configs')->where('id', '=', $request->id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'successfully updated.'] : ['status' => 400, 'message' => 'Failed to  update.']);
    }

    public function SeoConfigurationPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $data = DB::table('seo_metas')->where('id', '=', '1')->get();
        return view('settings.seo-keyword.index', compact('alldatas', 'data'));
    }

    public function UpdateSeoConfigurations(Request $request)
    {
        $fieldMappings = [
            'reg_meta_title' => 'reg_meta_title',
            'reg_meta_description' => 'reg_meta_description',
            'reg_meta_keywords' => 'reg_meta_keywords',

            'login_meta_title' => 'login_meta_title',
            'login_meta_description' => 'login_meta_description',
            'login_meta_keywords' => 'login_meta_keywords',

            'bec_vol_meta_title' => 'bec_vol_meta_title',
            'bec_vol_meta_description' => 'bec_vol_meta_description',
            'bec_vol_meta_keywords' => 'bec_vol_meta_keywords',

            'bec_mem_meta_title' => 'bec_mem_meta_title',
            'bec_mem_meta_description' => 'bec_mem_meta_description',
            'bec_mem_meta_keywords' => 'bec_mem_meta_keywords',

            'aud_meta_title' => 'aud_meta_title',
            'aud_meta_description' => 'aud_meta_description',
            'aud_meta_keywords' => 'aud_meta_keywords',

            'vid_meta_title' => 'vid_meta_title',
            'vid_meta_description' => 'vid_meta_description',
            'vid_meta_keywords' => 'vid_meta_keywords',

            'en_meta_title' => 'en_meta_title',
            'en_meta_description' => 'en_meta_description',
            'en_meta_keywords' => 'en_meta_keywords',

            'dharma_meta_title' => 'dharma_meta_title',
            'dharma_meta_description' => 'dharma_meta_description',
            'dharma_meta_keywords' => 'dharma_meta_keywords',

            'don_meta_title' => 'don_meta_title',
            'don_meta_description' => 'don_meta_description',
            'don_meta_keywords' => 'don_meta_keywords',

            'laksh_meta_title' => 'laksh_meta_title',
            'laksh_meta_description' => 'laksh_meta_description',
            'laksh_meta_keywords' => 'laksh_meta_keywords',
        ];

        $updateArray = [];

        foreach ($fieldMappings as $inputName => $columnName) {
            if ($request->has($inputName)) {
                $updateArray[$columnName] = $request->input($inputName);
            }
        }
        $updateArray['updated_at'] = date("Y-m-d H:i:s");
        $update = DB::table('seo_metas')->where('id', '=', $request->id)->update($updateArray);
        return response()->json($update == true ? ['status' => 200, 'message' => 'successfully updated.'] : ['status' => 400, 'message' => 'Failed to  update.']);
    }
}
