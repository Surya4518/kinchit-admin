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

class KalakshepamController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('kalakshepam.index', compact('alldatas'));
    }

    public function ShowData(Request $request)
    {
        $data = User::where('parent', 'LIKE', '3')->whereNotNull('verified_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }
}
