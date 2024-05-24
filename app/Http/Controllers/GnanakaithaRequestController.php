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
    Gnanakaithaa
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class GnanakaithaRequestController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('gnanakaithaa.index', compact('alldatas'));
    }

    public function ShowGnanakaithaRequestlist(Request $request)
    {
        $results = Gnanakaithaa::whereNull('deleted_at')->whereIn('is_approved', ['3', '0'])->orderBy('ID', 'ASC')->get();
        return response()->json(['status' => 200, 'data' => $results]);
    }

    public function ShowOneData(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $results = Gnanakaithaa::whereNull('deleted_at')->where('id', $request->id)->get();
        return view('gnanakaithaa.show', compact('alldatas', 'results'));
    }

    public function VerifyTheRequest(Request $request)
    {
        $update = Gnanakaithaa::where('id', $request->id)->update(['is_approved' => '3']);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Successfully Verified'] : ['status' => 400, 'message' => 'Failed to verify']);
    }

    public function ApproveTheRequest(Request $request)
    {
        $check = Gnanakaithaa::whereNull('deleted_at')->where('id', $request->id)->get();
        if ($check[0]->is_approved == '3') {
            $update = Gnanakaithaa::where('id', $request->id)->update(['is_approved' => '1']);
            return response()->json($update == true ? ['status' => 200, 'message' => 'Successfully Approved', 'is_approved' => '1'] : ['status' => 400, 'message' => 'Failed to verify']);
        } else {
            return response()->json(['status' => 200, 'message' => 'Kindly verify the request..!', 'is_approved' => '0']);
        }
    }

    public function RejectTheRequest(Request $request)
    {
        $update = Gnanakaithaa::where('id', $request->id)->update(['is_approved' => '2', 'rejected_reason' => $request->reason]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Successfully Rejected'] : ['status' => 400, 'message' => 'Failed to reject']);
    }

    public function ApprovedListPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('gnanakaithaa.approved', compact('alldatas'));
    }

    public function RejectedListPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('gnanakaithaa.rejected', compact('alldatas'));
    }

    public function ApprovedList(Request $request)
    {
        $results = Gnanakaithaa::whereNull('deleted_at')->where('is_approved', '=', '1')->orderBy('ID', 'DESC')->get();
        return response()->json(['status' => 200, 'data' => $results]);
    }

    public function RejectedList(Request $request)
    {
        $results = Gnanakaithaa::whereNull('deleted_at')->where('is_approved', '=', '2')->orderBy('ID', 'DESC')->get();
        return response()->json(['status' => 200, 'data' => $results]);
    }

    public function DeleteTheRequest(Request $request)
    {
        $delete = Gnanakaithaa::whereIn('id', $request->ids)->delete();
        return response()->json($delete == true ? ['status' => 200, 'message' => 'Successfully deleted'] : ['status' => 400, 'message' => 'Failed to delete']);
    }
}
