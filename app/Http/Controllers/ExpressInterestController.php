<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Input;
use Session;
use Storage;
use Mail;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Common;
use App\Models\ExpressInterest;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ExpressInterestController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('lakshmi-kalyanam.express-interest.index', compact('alldatas'));
    }

    public function ShowList(Request $request)
    {
        $result = ExpressInterest::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();
        return response()->json(['status' => 200, 'data' => $result]);
    }
}
