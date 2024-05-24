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
    ManageMatimonyProfiles
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ManageMatrimonyPhotoApprovalController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('lakshmi-kalyanam.photoapproval.index', compact('alldatas'));
    }

    public function ShowRequestedImages(Request $request)
    {
        if ($request->type != '') {
            $profiles = ManageMatimonyProfiles::whereNull('deleted_at')
                ->when($request->type != '', function ($query) use ($request) {
                    switch ($request->type) {
                        case 'Photo1':
                            return $query->where('Photo1Approve', '=', 'No')->where('Photo1', '!=', 'nophoto.gif');
                        case 'Photo2':
                            return $query->where('Photo2Approve', '=', 'No')->where('Photo2', '!=', 'nophoto.gif');
                        case 'Photo3':
                            return $query->where('Photo3Approve', '=', 'No')->where('Photo3', '!=', 'nophoto.gif');
                        default:
                            return $query;
                    }
                })
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $profiles = [];
        }

        return response()->json(['status' => 200, 'data' => $profiles]);
    }

    public function ApproveRequest(Request $request)
    {
        $update = ManageMatimonyProfiles::where('id', '=', $request->id)
            ->update([$request->type . 'Approve' => 'Yes']);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Successfully Approved'] : ['status' => 400, 'message' => 'Failed to approve']);
    }

    public function RejectRequest(Request $request)
    {
        $update = ManageMatimonyProfiles::where('id', '=', $request->id)
            ->update([$request->type . 'Approve' => 'Rej']);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Successfully Rejected'] : ['status' => 400, 'message' => 'Failed to reject']);
    }

}
