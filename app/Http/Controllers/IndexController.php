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
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


class IndexController extends Controller
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

		if (isset($adminid)) {
			return Redirect::to("dashboard");
		}

		if ($request->isMethod('post')) {
			$txtusername	= $request->input('txtusername');
			$getmyprofiledatas 	= DB::select("select * from wpu6_users where user_login = '" . $txtusername . "' limit 0,1");
			Session::put('adminid', $txtusername);
			Session::put('admin_user_id', $getmyprofiledatas[0]->ID);

			return Redirect::to("dashboard");
		}

		return view('index');
	}

	public function logout()
	{


		Session::flush();

		return Redirect::to("/");
	}

	public function forgetpassword(Request $request)
	{
		return view('forgetpassword');
	}

	public function loginverify(Request $request)
	{

		// dd($request->all());

		if ($request->isMethod('post')) {

			$txtusername	= $request->input('txtusername');
			$txtpassword	= $request->input('txtpassword');
			// dd("select * from wpu6_users where user_status = 0 and user_login = '".$txtusername."' and user_login = '".md5($txtpassword)."' and parent = '11111' limit 0,1 ");
			$userdatas = DB::select("select * from wpu6_users where user_status = 0 and user_login = '" . $txtusername . "' and user_pass = '" . md5($txtpassword) . "' and parent = '11111' limit 0,1 ");

			if (sizeof($userdatas) == "0") {
				return Response::json(array('status_code' => '0'));
			} else {
				return Response::json(array('status_code' => '1'));
			}
		} else {
			return Response::json(array('status_code' => '0'));
		}
	}

	public function verifyemailid(Request $request)
	{

		if ($request->isMethod('post')) {

			$type 			= $request->type;
			$txtemailid		= $request->txtemailid;

			$userdatas 		= DB::select("select * from wpu6_users where user_email = '" . $txtemailid . "' and parent = '11111' and user_status = 0 limit 0,1 ");

			if (sizeof($userdatas) == "0") {
				return Response::json(array('status_code' => '0'));
			} else {

				$to_name 	= $userdatas[0]->display_name;
				$to_email 	= $userdatas[0]->user_email;

				$six_digit_random_number = mt_rand(100000, 999999);

				$data = array('userdisplayname' => $to_name, "newpwd" => $six_digit_random_number);

				Mail::send('forgotpasswordemailsbody', $data, function ($message) use ($to_name, $to_email) {
					$message->to($to_email, $to_name)->subject('Password reset :: Kinchitkaram');
					$message->from('info@kinchitkaram.com', 'Kinchitkaram Trust');
				});

				$insert_arr	= array('user_pass' 	=> md5($six_digit_random_number));

				$update = DB::table("wpu6_users")->where("ID", $userdatas[0]->ID)->update($insert_arr);


				return Response::json(array('status_code' => '1'));
			}
		} else {
			return Response::json(array('status_code' => '0'));
		}
	}

	public function verifysuperadminemail(Request $request)
	{

		if ($request->isMethod('post')) {

			$type 			= $request->type;
			$txtemail		= $request->txtemail;
			$editid			= $request->editid;

			$subquery		= '';


			if ($editid != "") {
				$subquery		.= ' and id!= ' . $editid;
			}


			$userdatas 		= DB::select("select * from wpu6_users where email = '" . $txtemail . "' " . $subquery . "  limit 0,1 ");

			if (sizeof($userdatas) == "0") {
				return Response::json(array('status_code' => '0'));
			} else {
				return Response::json(array('status_code' => '1'));
			}
		} else {
			return Response::json(array('status_code' => '0'));
		}
	}



	public function showgallery(Request $request)
	{

		$gallery = DB::table('gallery')->get();

		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();


		return view('gallery', compact('alldatas', 'gallery'));
	}


	public function uploadgallery(Request $request)
	{

		// dd($request->all());
		$sel = DB::table('gallery')->where('id', $request->gal_id)->get();
		//dd($sel);
		if ($request->gal_id != '') {
			//dd($request->all());
			if ($request->hasFile('gal_file')) {

				$files = $request->file('gal_file');

				$img_arr = [];
				if (!is_null($files)) {
					foreach ($files as $key => $file) {

						$imageName = md5(time() . uniqid()) . '.' . $file->extension();
						$file->move("../cmsadmin-chettinadhospital/public/medias", $imageName);

						$img_arr[] = $imageName;
					}
					if ($sel[0]->image != '') {
						$img_arr1 = json_decode($sel[0]->image);
						$img_arr2 = array_merge($img_arr, $img_arr1);
					} else {
						$img_arr2 = $img_arr;
					}
					$img_arr3 = json_encode($img_arr2, true);
				} else {
					dd('fail');
				}
			} else {
				$img_arr3 = $sel[0]->image;
			}


			$arr = [
				'title' => $request->img_tile,
				'status' => $request->gal_status,
				'image' => $img_arr3
			];


			$update = DB::table('gallery')->where('id', $request->gal_id)->update($arr);

			if ($update) {
				$res['status'] = 200;
				$res['mgs'] = 'Successfully Updated';
			} else {
				$res['status'] = 200;
				$res['mgs'] = 'Process Failed';
			}
		} else {

			//dd($request->all());

			if ($request->hasFile('gal_file')) {
				$files = $request->file('gal_file');

				$img_arr = [];
				if (!is_null($files)) {
					foreach ($files as $key => $file) {

						$imageName = md5(time() . uniqid()) . '.' . $file->extension();
						$file->move("../cmsadmin-chettinadhospital/public/medias", $imageName);

						$img_arr[] = $imageName;
					}
				} else {
					dd('fail');
				}
			}

			$enc = json_encode($img_arr);

			// dd($enc);

			// 	       if ($request->hasFile('gal_file')) {
			// 			$imageName = time() . '.' . $request->gal_file->extension();
			// 			$request->gal_file->move("../cmsadmin-chettinadhospital/public/medias", $imageName);
			// 		}

			$lower = strtolower($request->img_tile);
			$slug = str_replace(" ", '-', $lower);
			// 		dd($slug);
			$arr = [
				'title' => $request->img_tile,
				'status' => $request->gal_status,
				'image' => $enc,
				'page_slug' => $slug
			];

			$ins = DB::table('gallery')->insert($arr);

			if ($ins) {
				$res['status'] = 200;
				$res['mgs'] = 'Successfully Created';
			} else {
				$res['status'] = 200;
				$res['mgs'] = 'Process Failed';
			}
		}

		return Response::json($res);
	}


	public function editgallery(Request $request)
	{

		$select = DB::table('gallery')->where('id', $request->id)->get();

		return Response::json($select);
	}

	public function deletegallery(Request $request)
	{

		$delete = DB::table('gallery')->where('id', $request->id)->delete();

		if ($delete) {
			$res['status'] = 200;
			$res['mgs'] = 'Successfully Deleted';
		} else {
			$res['status'] = 200;
			$res['mgs'] = 'Process Failed';
		}

		return Response::json($res);
	}

	public function deleteimggallery(Request $request)
	{
		// dd($request->img);
		$select = DB::table('gallery')->where('id', $request->id)->get();
		$img_arr = json_decode($select[0]->image);

		$index = array_search($request->img, $img_arr);
		if ($index !== false) {
			unset($img_arr[$index]);
		}

		if (count($img_arr) > 0) {
			$img123 = json_encode(array_values($img_arr), true);
		} else {
			$img123 = '';
		}

		$update = DB::table('gallery')->where('id', $request->id)->update(['image' => $img123]);
		if ($update) {
			$res['status'] = 200;
			$res['mgs'] = 'Successfully Updated';
		} else {
			$res['status'] = 200;
			$res['mgs'] = 'Process Failed';
		}

		return Response::json($res);
	}
}
