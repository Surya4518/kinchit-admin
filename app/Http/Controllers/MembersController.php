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
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class MembersController extends Controller
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
        return view('member.index', compact('alldatas', 'volunteer'));
    }

    public function ShowMember(Request $request)
    {
        $member = User::where('parent', 'LIKE', $request->id)->whereNotNull('verified_at')
            ->where(DB::raw('LENGTH(parent)'), '>=', 6)
            ->when($request->status != '', function ($query) use ($request) {
                return $query->where('user_status', '=', $request->status);
            })
            ->orderBy('ID', 'ASC')
            ->get();
        return response()->json(['status' => 200, 'data' => $member]);
    }

    public function ChangeMemberStatus(Request $request)
    {
        $memberstatus = User::where('ID', '=', $request->id)->whereNotNull('verified_at')
            ->update(['user_status' => $request->status]);
        return response()->json( $memberstatus == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed'] );
    }

}
