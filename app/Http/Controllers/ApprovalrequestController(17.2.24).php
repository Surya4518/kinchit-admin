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
use App\Common;
use App\Models\{
    Approvalrequest,
    User,
    Requesttypes
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ApprovalrequestController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $request = Requesttypes::whereNull('deleted_at')->get();
        $volunteer = User::where('parent', 'LIKE', '0')
            ->orderBy('ID', 'ASC')
            ->get();
        return view('approval-requests.index', compact('alldatas', 'volunteer', 'request'));
    }

    public function ShowApprovalRequestlist(Request $request)
    {
        $results = DB::table('approval_requests')
            ->leftJoin('request_types', 'request_types.id', '=', 'approval_requests.request_type')
            ->select('approval_requests.*', 'request_types.request_type AS request')
            ->where('approval_requests.deleted_at', '=', null)
            ->where('approval_requests.is_approved', '=', '0')
            ->when($request->id != '', function ($query) use ($request) {
                return $query->where('approval_requests.request_type', '=', $request->id);
            })
            ->get();
        return response()->json(['status' => 200, 'data' => $results]);
    }

    public function GettheRequesttype(Request $request)
    {
        $requests = DB::table('approval_requests')
            ->where('id', '=', $request->id)
            ->get();
        $user = User::where('ID', '=', $requests[0]->from_id)->get();
        $request_type = DB::table('request_types')->where('id', '=', (int) $requests[0]->request_type)->get();
        return response()->json(['status' => 200, 'id' => $request_type[0]->id, 'from_user' => $requests[0]->from_id, 'old_volunteer' => $user[0]->parent]);
    }

    public function ChangeMembersTo_an_Volunteer(Request $request)
    {
        $update_volunteer = User::where('parent', '=', $request->from_vol)
            ->update(['parent' => $request->to_vol]);
        if ($request->type == 'requested') {
            $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '1']);
        }
        return response()->json($update_volunteer == true ? ['status' => 200, 'message' => 'Members has been successfully changed'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ChangeVolunteerForMemeber(Request $request)
    {
        $update_volunteer = User::where('ID', '=', $request->user_id)
            ->update(['parent' => $request->new_vol]);
        if ($request->type == 'requested') {
            $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '1']);
        }
        return response()->json($update_volunteer == true ? ['status' => 200, 'message' => 'Volunteer has been successfully changed'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function InactiveUserByRequested(Request $request)
    {
        $users = User::where('user_login', '=', $request->user_id)->get();
        if ($users[0]->parent == '0') {
            $members = User::where('parent', '=', $users[0]->user_login)->count();
            if ($members > 0) {
                return response()->json(['status' => 400, 'message' => 'Kindly change the members below this volunteer to another volunteer to inactive the current volunteer.']);
            } else {
                $inactive_user = User::where('user_login', '=', $request->user_id)
                    ->update(['user_status' => '1']);
                if ($request->type == 'requested') {
                    $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '1']);
                }
                return response()->json($inactive_user == true ? ['status' => 200, 'message' => 'Successfully Inactived'] : ['status' => 400, 'message' => 'Failed']);
            }
        } else {
            $inactive_user = User::where('user_login', '=', $request->user_id)
                ->update(['user_status' => '1']);
            if ($request->type == 'requested') {
                $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '1']);
            }
            return response()->json($inactive_user == true ? ['status' => 200, 'message' => 'Successfully Inactived'] : ['status' => 400, 'message' => 'Failed']);
        }
    }

    public function ChangeDonorToMember(Request $request)
    {
        $update_donor = User::where('user_login', '=', $request->user_id)
            ->update(['parent' => $request->vol_id]);
        if ($request->type == 'requested') {
            $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '1']);
        }
        return response()->json($update_donor == true ? ['status' => 200, 'message' => 'Successfully Promoted to Member'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function RejectRequest(Request $request)
    {
        $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '2', 'rejected_reason' => $request->reason]);
        return response()->json($request_type_update == true ? ['status' => 200, 'message' => 'Request has been rejected'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function AprroveToBeAVolunteer(Request $request)
    {
        // dd($request->all());
        $volunteer_update = User::where('user_login', '=', $request->user_id)
            ->update(['parent' => '0', 'user_type' => 'volunteer']);
        if ($request->type == 'requested') {
            $request_type_update = Approvalrequest::where('id', '=', $request->approval_request_id)->update(['is_approved' => '1']);
        }
        return response()->json($volunteer_update == true ? ['status' => 200, 'message' => 'Successfully Promoted to volunteer'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ApprovedRequests(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('approval_requests')
            ->leftJoin('request_types', 'request_types.id', '=', 'approval_requests.request_type')
            ->select('approval_requests.*', 'request_types.request_type AS request')
            ->where('approval_requests.deleted_at', '=', null)
            ->where('approval_requests.is_approved', '=', '1')
            ->get();
        return view('approval-requests.approved-requests', compact('alldatas', 'requests'));
    }

    public function RejectedRequests(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $requests = DB::table('approval_requests')
            ->leftJoin('request_types', 'request_types.id', '=', 'approval_requests.request_type')
            ->select('approval_requests.*', 'request_types.request_type AS request')
            ->where('approval_requests.deleted_at', '=', null)
            ->where('approval_requests.is_approved', '=', '2')
            ->get();
        return view('approval-requests.rejected-requests', compact('alldatas', 'requests'));
    }

}
