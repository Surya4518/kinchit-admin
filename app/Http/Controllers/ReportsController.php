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
use Carbon\{Carbon};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Common;
use App\Models\{
    User
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Rap2hpoutre\FastExcel\{FastExcel, SheetCollection};

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('reports.user-report.index', compact('alldatas'));
    }

    public function GenerateUserReport(Request $request)
    {
        // dd($request->all());
        $file_name = $request->user . '_report_';

        $user_details = DB::table('wpu6_users')
            ->select('wpu6_users.*', 'userprofile_dt.first_name', 'userprofile_dt.last_name', 'userprofile_dt.dob', 'userprofile_dt.gender', 'userprofile_dt.acharyan', 'userprofile_dt.phone_number', 'userprofile_dt.address_1', 'userprofile_dt.address_2', 'userprofile_dt.area', 'userprofile_dt.city', 'userprofile_dt.state', 'userprofile_dt.country', 'userprofile_dt.qualification')
            ->leftJoin('userprofile_dt', 'userprofile_dt.user_id', '=', 'wpu6_users.ID')
            ->whereBetween('wpu6_users.user_registered', [$request->from_date, $request->to_date])
            ->when($request->user, function ($query) use ($request) {
                return $query->where('wpu6_users.user_type', 'LIKE', $request->user);
            })
            ->whereNull('wpu6_users.deleted_at')
            ->orderByDesc('wpu6_users.ID')
            ->get();
        // dd($user_details);
        if ($user_details->isNotEmpty()) {
            return (new FastExcel($user_details))
                ->download($file_name . $request->from_date . '.xlsx', function ($user) {
                    $arr['Nice Name'] = $user->user_nicename;
                    $arr['First Name'] = $user->first_name;
                    $arr['Last Name'] = $user->last_name;
                    $arr['Display Name'] = $user->display_name;
                    $arr['User Login'] = $user->user_login;
                    $arr['User Email'] = $user->user_email;
                    $arr['Date Of Birth'] = date("d-m-Y", strtotime($user->dob));
                    $arr['Gender'] = $user->gender;
                    $arr['Acharyan'] = $user->acharyan;
                    $arr['Mobile No'] = $user->phone_number;
                    $arr['Address'] = $user->address_1 . ', ' . $user->address_2 . ', ' . $user->city;
                    $arr['State'] = $user->state;
                    $arr['Country'] = $user->country;
                    $arr['Qualification'] = $user->qualification;
                    return $arr;
                });
        } else {
            $alldatas['userinfo'] = Common::userinfo();
            $alldatas['toprightmenu'] = Common::toprightmenu();
            $alldatas['mainmenu'] = Common::mainmenu();
            $alldatas['footer'] = Common::footer();
            $alldatas['sidenavbar'] = Common::sidenavbar();
            $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
            return view('reports.user-report.partials.no_data_message', ['report_type' => 'user', 'alldatas' => $alldatas]);
        }
    }

}
