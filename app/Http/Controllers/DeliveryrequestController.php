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

class DeliveryrequestController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('rmsm_donation')
            ->where('is_approved', '=', '0')
            ->get();
        $volunteer = User::where('parent', 'LIKE', '0')
            ->orderBy('ID', 'ASC')
            ->get();
        return view('delivery-request.delivery-pending-requests', compact('alldatas', 'requests', 'volunteer'));
    }

    public function ShowApprovalRequestlist(Request $request)
    {
        $results = DB::table('rmsm_donation')
            ->where('is_approved', '=', '0')
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
        $requests = DB::table('rmsm_donation')
            ->where('is_approved', '=', '1')
            ->get();
        return view('delivery-request.delivery-approval-requests', compact('alldatas', 'requests'));
    }

    public function RejectRequests(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('rmsm_donation')
            ->where('is_approved', '=', '2')
            ->get();
        return view('delivery-request.delivery-rejected-requests', compact('alldatas', 'requests'));
    }

    public function ApproveRequestsView(Request $request, $id)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $user = DB::table('rmsm_donation')
            ->leftJoin('wpu6_users', 'rmsm_donation.user_id', '=', 'wpu6_users.ID')
            ->where('rmsm_donation.id', $id)
            ->get();
        //print_r($user);
        return view('delivery-request.approve_request_view', compact('user', 'alldatas'));
    }

    public function ApproveStatus(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $user = DB::table('rmsm_donation')
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
        $user = DB::table('rmsm_donation')
            ->where('id', $request->id)
            ->update(['is_approved' => $request->status]);
        if ($user) {
            return response()->json(['status' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to update status']);
        }
    }
}
