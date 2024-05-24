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
use Illuminate\Support\Facades\Http;
use App\Common;
use App\Models\User;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

		$adminid = Session::get('adminid');

		if(!(isset($adminid))){
			return Redirect::to("/");
		}




		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
        
        
          $repliesCount = DB::table('wphy_posts')->where('post_type', 'reply')->count();
          $threadsCount = DB::table('wphy_posts')->where('post_type', 'thread')->count();

        $active_users = User::where('user_status','=','0')->count();
        $inactive_users = User::where('user_status','=','1')->count();

		//$alldatas['dashboardinfo'] 		= Common::dashboardinfo();
		//$alldatas['licenceverifcationdashboardinfo'] 		= Common::licenceverifcationdashboardinfo();

		return view('dashboard', compact('alldatas','active_users','inactive_users','repliesCount', 'threadsCount'));

    }

}

