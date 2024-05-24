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
		
		
		//$alldatas['dashboardinfo'] 		= Common::dashboardinfo();
		//$alldatas['licenceverifcationdashboardinfo'] 		= Common::licenceverifcationdashboardinfo();
		
		return view('dashboard')->with("alldatas", $alldatas);
		
    }	
			 
}

