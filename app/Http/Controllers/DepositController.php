<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use App\Models\{
    Approvalrequest,
    User,
    Requesttypes
};
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('deposit_details')
            ->leftJoin('wpu6_users', 'deposit_details.user_id', '=', 'wpu6_users.ID')
            ->leftJoin('userprofile_dt', 'wpu6_users.ID', '=', 'userprofile_dt.user_id')
            ->where('deposit_details.is_approved', '=', '0')
            ->get();
        $volunteer = User::where('parent', 'LIKE', '0')
            ->orderBy('ID', 'ASC')
            ->get();
        return view('deposit-request.deposit-pending-requests', compact('alldatas', 'requests', 'volunteer'));
    }

    public function ShowApprovalRequestlist(Request $request)
    {
        $results = DB::table('deposit_details')
            ->select('deposit_details.*', 'wpu6_users.ID', 'userprofile_dt.first_name', 'userprofile_dt.last_name', 'userprofile_dt.phone_number', 'userprofile_dt.created_at')
            ->leftJoin('wpu6_users', 'deposit_details.user_id', '=', 'wpu6_users.ID')
            ->leftJoin('userprofile_dt', 'wpu6_users.ID', '=', 'userprofile_dt.user_id')
            ->where('deposit_details.is_approved', '=', '0')
            ->get();
        return response()->json(['status' => 200, 'data' => $results]);
    }

    public function ApprovedRequests(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('deposit_details')
            ->select('deposit_details.*', 'wpu6_users.ID', 'userprofile_dt.first_name', 'userprofile_dt.last_name', 'userprofile_dt.phone_number', 'userprofile_dt.created_at')
            ->leftJoin('wpu6_users', 'deposit_details.user_id', '=', 'wpu6_users.ID')
            ->leftJoin('userprofile_dt', 'wpu6_users.ID', '=', 'userprofile_dt.user_id')
            ->where('is_approved', '=', '1')
            ->get();
        return view('deposit-request.deposit-approval-requests', compact('alldatas', 'requests'));
    }

    public function RejectRequests(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('deposit_details')
            ->select('deposit_details.*', 'wpu6_users.ID', 'userprofile_dt.first_name', 'userprofile_dt.last_name', 'userprofile_dt.phone_number', 'userprofile_dt.created_at')
            ->leftJoin('wpu6_users', 'deposit_details.user_id', '=', 'wpu6_users.ID')
            ->leftJoin('userprofile_dt', 'wpu6_users.ID', '=', 'userprofile_dt.user_id')
            ->where('is_approved', '=', '2')
            ->get();
        return view('deposit-request.deposit-rejected-requests', compact('alldatas', 'requests'));
    }

    public function ApproveRequestsView(Request $request, $id)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $user = DB::table('deposit_details')
            ->leftJoin('wpu6_users', 'deposit_details.user_id', '=', 'wpu6_users.ID')
            ->leftJoin('userprofile_dt', 'wpu6_users.ID', '=', 'userprofile_dt.user_id')
            ->where('deposit_details.is_approved', '=', '0')
            ->where('deposit_details.id', $id)
            ->get();
        //print_r($user);
        return view('deposit-request.approve_request_view', compact('user', 'alldatas'));
    }

    public function ApproveStatus(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $user = DB::table('deposit_details')
            ->where('id', $request->id)
            ->update(['is_approved' => $request->status]);
        if ($user) {
            return response()->json(['status' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to update status']);
        }
    }
    public function RejectStatus(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $user = DB::table('deposit_details')
            ->where('id', $request->id)
            ->update(['is_approved' => $request->status]);
        if ($user) {
            return response()->json(['status' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to update status']);
        }
    }
}
