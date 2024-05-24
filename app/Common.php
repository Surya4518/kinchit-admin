<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Storage;
use Exception;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class Common extends Model
{
    public static function queryexec($query){
    	return DB::select($query);
    }

	public static function userinfo(){

		$adminid = Session::get('adminid');
        // session()->forget('adminid');
        if(Session::get('adminid') == null){
            return view('index');
        }

		$getmyprofiledatas 	= DB::select("select * from wpu6_users where user_login = '".$adminid."' limit 0,1");
		$firstname			= $getmyprofiledatas[0]->display_name;
		$lastname			= $getmyprofiledatas[0]->user_nicename;

			// $profile_pic_display = '..\public\theme\assets\img\faces\man.png';
            $getmyprofiledatas = DB::select("
            SELECT id, display_name, user_nicename 
            FROM wpu6_users 
            WHERE user_login = '".$adminid."' 
            LIMIT 0,1"
            );
            
            if (!empty($getmyprofiledatas)) {
                $firstname = $getmyprofiledatas[0]->display_name;
                $lastname = $getmyprofiledatas[0]->user_nicename;
            
                $profile_pic_display = '../../public/theme/assets/img/faces/man.png'; // Default image path
            
                $userProfileData = DB::table('userprofile_dt')
                    ->where('user_id', $getmyprofiledatas[0]->id)
                    ->first();
            
                if ($userProfileData && !empty($userProfileData->user_image)) {
                    $profile_pic_display = asset($userProfileData->user_image); // Set profile image path
                }
            } else {
                $profile_pic_display = '../../public/theme/assets/img/faces/man.png'; // Default image path
            }


		$str = '<div class="dropdown user-pro-body text-center">
									<div class="user-pic">
										<img src="'.$profile_pic_display.'" alt="user-img" class=" mCS_img_loaded">
									</div>
									<div class="user-info">
										<h6 class=" mb-0 text-dark">'.$firstname.'</h6>
									</div>
								</div>';

		return $str;

	}

	public static function toprightmenu(){

		$adminid = Session::get('adminid');
		$getmyprofiledatas 	= DB::select("select * from wpu6_users where user_login = '".$adminid."' limit 0,1");
		$firstname			= $getmyprofiledatas[0]->display_name;
		$lastname			= $getmyprofiledatas[0]->user_nicename;

        // in live use this
			// $profile_pic_display = url('').'/public/theme/assets/img/faces/6.jpg';

          $getmyprofiledatas = DB::select("
                SELECT id, display_name, user_nicename 
                FROM wpu6_users 
                WHERE user_login = '".$adminid."' 
                LIMIT 0,1"
            );
            
            if (!empty($getmyprofiledatas)) {
                $firstname = $getmyprofiledatas[0]->display_name;
                $lastname = $getmyprofiledatas[0]->user_nicename;
            
                $profile_pic_display = '../../public/theme/assets/img/faces/man.png'; // Default image path
            
                $userProfileData = DB::table('userprofile_dt')
                    ->where('user_id', $getmyprofiledatas[0]->id)
                    ->first();
            
                if ($userProfileData && !empty($userProfileData->user_image)) {
                    $profile_pic_display = asset($userProfileData->user_image); // Set profile image path
                }
            } else {
                $profile_pic_display = '../../public/theme/assets/img/faces/man.png'; // Default image path
            }
            
            $str = '<a class="profile-user d-flex" href=""><img src="'.$profile_pic_display.'" alt="user-img" class="rounded-circle mCS_img_loaded"><span></span></a><div class="dropdown-menu">
                                                    <div class="main-header-profile header-img">
                                                        <div class="main-img-user"><img alt="" src="'.$profile_pic_display.'"></div>
                                                        <h6>'.$firstname.' </h6>
                                                    </div>
                                                    <a class="dropdown-item" href="'.url('').'/myprofile/'.$getmyprofiledatas[0]->id.'"><i class="far fa-user"></i> My Profile</a>
                                                    <a class="dropdown-item" href="'.url('').'/logout'.'"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                                                </div>';
            
            return $str;



	}

	public static function mainmenu(){

		$fullurl = URL::current();

        // $array = explode('-',$fullurl);
        // $url=end($array);

		$str = '<ul class="side-menu" style="max-height: 100%; overflow-y: auto;">';

							$dasboard_is_expanded 	= '';
							$dasboard_is_active 	= '';

							if (str_contains($fullurl, 'dashboard')) {

								$dasboard_is_expanded 	= 'is-expanded';
								$dasboard_is_active 	= 'active';

							}

							$str .='<li class="slide '.$dasboard_is_expanded.'">
								<a class="side-menu__item '.$dasboard_is_active.'" href="'.url('').'/dashboard'.'"><i class="side-menu__icon fas fa-tachometer-alt me-1"></i></i><span class="side-menu__label ms-2">Dashboard</span></a>
							</li>';

							$home_expanded 	= '';
							$home_active 	= '';

							if (str_contains($fullurl, 'requests')) {

								$home_expanded 	= 'is-expanded';
								$home_active 	= 'active';

							}

							$str .='<li class="slide '.$home_expanded.'">
                                <a class="side-menu__item '.$home_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-check-circle"></i><span class="side-menu__label">Home</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/home-banner'.'">Banner</a></li>
									<li><a class="slide-item" href="'.url('').'/about-us'.'">About Us</a></li>
									<li><a class="slide-item" href="'.url('').'/our-service'.'">Our Service</a></li>
									<li><a class="slide-item" href="'.url('').'/home-image'.'">Home Image</a></li>
								</ul>
							</li>';


                            $users_is_expanded 	= '';
							$users_is_active 	= '';

							if (str_contains($fullurl, 'volunteers') || str_contains($fullurl, 'members') || str_contains($fullurl, 'donors') || str_contains($fullurl, 'general-users')) {

								$users_is_expanded 	= 'is-expanded';
								$users_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$users_is_expanded.'">
								<a class="side-menu__item '.$users_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Users</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/general-users'.'">General Users</a></li>
									<li><a class="slide-item" href="'.url('').'/volunteers'.'">Volunteers</a></li>
									<li><a class="slide-item" href="'.url('').'/members'.'">Members</a></li>
                                    <li><a class="slide-item" href="'.url('').'/donors'.'">Donors</a></li>
                                    <li><a class="slide-item" href="'.url('').'/kalakshepem'.'">Kalakshepam</a></li>
								</ul>
							</li>';

                            $requests_expanded 	= '';
							$requests_active 	= '';

							if (str_contains($fullurl, 'requests')) {

								$requests_expanded 	= 'is-expanded';
								$requests_active 	= 'active';

							}

							$str .='<li class="slide '.$requests_expanded.'">
                                <a class="side-menu__item '.$requests_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-check-circle"></i><span class="side-menu__label">Approval Requests</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/approval-requests'.'">Pending Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/approved-requests'.'">Approved Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/rejected-requests'.'">Rejected Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/challan-requests'.'">Challan Requests</a></li>
								</ul>
							</li>';

                            $requests_expanded 	= '';
							$requests_active 	= '';
							
								if (str_contains($fullurl, 'requests')) {

								$requests__expanded 	= 'is-expanded';
								$requests_active 	= 'active';

							}

							$str .='<li class="slide '.$requests_expanded.'">
                                <a class="side-menu__item '.$requests_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-check-circle"></i><span class="side-menu__label">Delivery Requests</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/delivery-pending-requests'.'">Pending Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/delivery-approved-requests'.'">Approved Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/delivery-rejected-requests'.'">Rejected Requests</a></li>
								</ul>
							</li>';

                            $requests_expanded 	= '';
							$requests_active 	= '';
							
							 $requests_expanded 	= '';
							$requests_active 	= '';

							if (str_contains($fullurl, 'deposit')) {

								$requests__expanded 	= 'is-expanded';
								$requests_active 	= 'active';

							}

							$str .='<li class="slide '.$requests_expanded.'">
                                <a class="side-menu__item '.$requests_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-check-circle"></i><span class="side-menu__label">Deposit Requests</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/deposit-pending-requests'.'">Pending Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/deposit-approved-requests'.'">Approved Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/deposit-rejected-requests'.'">Rejected Requests</a></li>
								</ul>
							</li>';


							if (str_contains($fullurl, 'gnanakaitha')) {

								$requests_expanded 	= 'is-expanded';
								$requests_active 	= 'active';

							}

							$str .='<li class="slide '.$requests_expanded.'">
                                <a class="side-menu__item '.$requests_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-book"></i><span class="side-menu__label">Gnanakaitha Requests</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/gnanakaitha'.'">Pending Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/approved-gnanakaitha'.'">Approved Requests</a></li>
									<li><a class="slide-item" href="'.url('').'/rejected-gnanakaitha'.'">Rejected Requests</a></li>
								</ul>
							</li>';
							$donation_is_expanded 	= '';
							$donation_is_active 	= '';

							if (str_contains($fullurl, 'donation')) {

								$donation_is_expanded 	= 'is-expanded';
								$donation_is_active 	= 'active';

							}

							$str .='<li class="slide '.$donation_is_expanded.'">
								<a class="side-menu__item '.$donation_is_active.'" href="'.url('').'/donation'.'"><i class="side-menu__icon fa fa-donate"></i><span class="side-menu__label">Donation</span></a>
							</li>';
							
							$gallery_expanded 	= '';
							$gallery_active 	= '';
							
							$donation_category_expanded 	= '';
							$donation_category_active 	= '';

							if (str_contains($fullurl, 'donationcategory')) {

								$donation_category_expanded 	= 'is-expanded';
								$donation_category_active 	= 'active';

							}

							$str .='<li class="slide '.$donation_category_expanded.'">
								<a class="side-menu__item '.$donation_category_active.'" href="'.url('').'/donation-category'.'"><i class="side-menu__icon fa fa-donate"></i><span class="side-menu__label">Donation Category</span></a>
							</li>';



							if (str_contains($fullurl, 'gallery')) {

								$requests_expanded 	= 'is-expanded';
								$requests_active 	= 'active';

							}

							$str .='<li class="slide '.$gallery_expanded.'">
                                <a class="side-menu__item '.$gallery_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fa fa-image"></i><span class="side-menu__label">Gallery</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/gallery-category'.'">Gallery Category</a></li>
									<li><a class="slide-item" href="'.url('').'/gallery-image'.'">Gallery image</a></li>
								</ul>
							</li>';

							


                            $services_is_expanded 	= '';
							$services_is_active 	= '';

							if (str_contains($fullurl, 'services')) {

								$services_is_expanded 	= 'is-expanded';
								$services_is_active 	= 'active';

							}

							$str .='<li class="slide '.$services_is_expanded.'">
								<a class="side-menu__item '.$services_is_active.'" href="'.url('').'/services'.'"><i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">Services</span></a>
							</li>';

							$kinchit_service_expanded 	= '';
							$kinchit_service_active 	= '';

							if (str_contains($fullurl, 'Kinchit Services')) {

								$kinchit_service_expanded 	= 'is-expanded';
								$kinchit_service_active 	= 'active';

							}

							$str .='<li class="slide '.$kinchit_service_expanded.'">
								<a class="side-menu__item '.$kinchit_service_active.'" href="'.url('').'/kinchit-service'.'"><i class="side-menu__icon fas fa-question-circle"></i><span class="side-menu__label">Kinchit Services</span></a>
							</li>';
							
							$services_test_is_expanded 	= '';
							$services_test_is_active 	= '';

							if (str_contains($fullurl, 'services-test')) {

								$services_test_is_expanded 	= 'is-expanded';
								$services_test_is_active 	= 'active';

							}

							$str .='<li class="slide '.$services_test_is_expanded.'">
								
							</li>';

                            $rebooking_is_expanded 	= '';
							$rebooking_is_active 	= '';

							if (str_contains($fullurl, 'booking')) {

								$rebooking_is_expanded 	= 'is-expanded';
								$rebooking_is_active 	= 'active';

							}

							$str .='<li class="slide '.$rebooking_is_expanded.'">
								<a class="side-menu__item '.$rebooking_is_active.'" href="'.url('').'/rd-booking'.'"><i class="side-menu__icon fas fa-male"></i><span class="side-menu__label">Ramanujarya Divyanjna</span></a>
							</li>';

                            $namaste_lms_is_expanded 	= '';
							$namaste_lms_is_active 	= '';

							if (str_contains($fullurl, 'courses') || str_contains($fullurl, 'lessons')) {

								$namaste_lms_is_expanded 	= 'is-expanded';
								$namaste_lms_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$namaste_lms_is_expanded.'">
								<a class="side-menu__item '.$namaste_lms_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-praying-hands"></i><span class="side-menu__label">Namaste LMS</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
									<li><a class="slide-item" href="'.url('').'/courses'.'">Courses</a></li>
                                    <li><a class="slide-item" href="'.url('').'/lessons'.'">Lessons</a></li>
                                    <li><a class="slide-item" href="'.url('').'/students'.'">Students</a></li>
								</ul>
							</li>';

                            $tutorials_is_expanded 	= '';
							$tutorials_is_active 	= '';

							if (str_contains($fullurl, 'tutorial-categories') || str_contains($fullurl, 'tutorial-audio') || str_contains($fullurl, 'tutorial-videos')) {

								$tutorials_is_expanded 	= 'is-expanded';
								$tutorials_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$tutorials_is_expanded.'">
								<a class="side-menu__item '.$tutorials_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fa fa-graduation-cap"></i><span class="side-menu__label">Tutorials</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/tutorial-albums'.'">Albums</a></li>
									<li><a class="slide-item" href="'.url('').'/tutorial-audios'.'">Audio</a></li>
                                    <li><a class="slide-item" href="'.url('').'/tutorial-videos'.'">Video</a></li>
								</ul>
							</li>';

                            $rmupanyasam_is_expanded 	= '';
							$rmupanyasam_is_active 	= '';

							if (str_contains($fullurl, 'rm-audios') || str_contains($fullurl, 'rm-videos') || str_contains($fullurl, 'rm-categories') || str_contains($fullurl, 'rm-online')) {

								$rmupanyasam_is_expanded 	= 'is-expanded';
								$rmupanyasam_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$rmupanyasam_is_expanded.'">
								<a class="side-menu__item '.$rmupanyasam_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-microphone"></i><span class="side-menu__label">RM Online Upanyasam</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/rm-albums'.'">Albums</a></li>
									<li><a class="slide-item" href="'.url('').'/rm-audios'.'">Audio</a></li>
                                    <li><a class="slide-item" href="'.url('').'/rm-videos'.'">Video</a></li>
								</ul>
							</li>';

                            $enpani_expanded 	= '';
							$enpani_active 	= '';

							if (str_contains($fullurl, 'enpani')) {

								$enpani_expanded 	= 'is-expanded';
								$enpani_active 	= 'active';

							}
                            $str .='<li class="slide '.$enpani_expanded.'">
								<a class="side-menu__item '.$enpani_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-briefcase"></i><span class="side-menu__label">Kinchit Enapani</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/enpani-categories'.'">Categories</a></li>
                                    <li><a class="slide-item" href="'.url('').'/enpani-audios'.'">Audio</a></li>
								</ul>
							</li>';

                            $dharmasandheha_is_expanded 	= '';
							$dharmasandheha_is_active 	= '';

							if (str_contains($fullurl, 'thread') || str_contains($fullurl, 'reply') || str_contains($fullurl, 'replies')) {

								$dharmasandheha_is_expanded 	= 'is-expanded';
								$dharmasandheha_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$dharmasandheha_is_expanded.'">
								<a class="side-menu__item '.$dharmasandheha_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-users"></i><span class="side-menu__label">Dharma Sandheha</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="slide-item" href="'.url('').'/threads'.'">Threads</a></li>
									<li><a class="slide-item" href="'.url('').'/replies'.'">Replies</a></li>
								</ul>
							</li>';

                            $lakshmi_kalyanam_is_expanded 	= '';
							$lakshmi_kalyanam_is_active 	= '';

							if (str_contains($fullurl, 'lakshmi-kalyanam')) {

								$lakshmi_kalyanam_is_expanded 	= 'is-expanded';
								$lakshmi_kalyanam_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$lakshmi_kalyanam_is_expanded.'">
								<a class="side-menu__item '.$lakshmi_kalyanam_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-handshake"></i><span class="side-menu__label">Lakshmi Kalyanam</span><i class="angle fe fe-chevron-down"></i></a>
                                <ul class="slide-menu">
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-community'.'">Manage Community</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-subsection'.'">Manage Subsection</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-country'.'">Manage Country</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-state'.'">Manage State</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-city'.'">Manage City</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-education'.'">Manage Education</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/manage-occupation'.'">Manage Occupation</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/express-interest'.'">Express Interests</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/success-stories'.'">Success Stories</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/profiles'.'">Manage Matrimony Profiles</a></li>
                                <li><a class="slide-item" href="'.url('').'/lakshmi-kalyanam/photo-approval'.'">Photo Approvals</a></li>
                                </ul>
                                </li>';
                                
                            $special_is_expanded 	= '';
							$special_is_active 	= '';

							if (str_contains($fullurl, 'special')) {

								$special_is_expanded 	= 'is-expanded';
								$special_is_active 	= 'active';

							}

							$str .='<li class="slide '.$special_is_expanded.'">
								<a class="side-menu__item '.$special_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-cog"></i><span class="side-menu__label">Special Programme</span><i class="angle fe fe-chevron-down"></i></a>
                                <ul class="slide-menu">
                                <li><a class="slide-item" href="'.url('').'/special-programme/categories'.'">Categories</a></li>
                                <li><a class="slide-item" href="'.url('').'/special-programme/contents'.'">Contents</a></li>
                                </ul>
                                </li>';
                                
                            $sanchika_is_expanded 	= '';
							$sanchika_is_active 	= '';

							if (str_contains($fullurl, 'sanchika')) {

								$sanchika_is_expanded 	= 'is-expanded';
								$sanchika_is_active 	= 'active';

							}

							$str .='<li class="slide '.$sanchika_is_expanded.'">
								<a class="side-menu__item '.$sanchika_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-cog"></i><span class="side-menu__label">Sanchika</span><i class="angle fe fe-chevron-down"></i></a>
                                <ul class="slide-menu">
                                <li><a class="slide-item" href="'.url('').'/sanchika/categories'.'">Categories</a></li>
                                <li><a class="slide-item" href="'.url('').'/sanchika/pdfs'.'">PDFs</a></li>
                                </ul>
                                </li>';

                            $settings_is_expanded 	= '';
							$settings_is_active 	= '';

							if (str_contains($fullurl, 'setting')) {

								$settings_is_expanded 	= 'is-expanded';
								$settings_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$settings_is_expanded.'">
								<a class="side-menu__item '.$settings_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-cog"></i><span class="side-menu__label">Settings</span><i class="angle fe fe-chevron-down"></i></a>
                                <ul class="slide-menu">
                                <li><a class="slide-item" href="'.url('').'/setting/site-configuration'.'">Site Configuration</a></li>
                                <li><a class="slide-item" href="'.url('').'/setting/seo-metas'.'">Seo Configurations</a></li>
                                <li><a class="slide-item" href="'.url('').'/setting/change-password'.'">Change Password</a></li>
                                </ul>
                                </li>';
                            $report_is_expanded 	= '';
							$report_is_active 	= '';

							if (str_contains($fullurl, 'report')) {

								$report_is_expanded 	= 'is-expanded';
								$report_is_active 	= 'active';

							}
                            $str .='<li class="slide '.$report_is_expanded.'">
								<a class="side-menu__item '.$report_is_active.'" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fas fa-chart-bar"></i><span class="side-menu__label">Reports</span><i class="angle fe fe-chevron-down"></i></a>
                                <ul class="slide-menu">
                                <li><a class="slide-item" href="'.url('').'/reports/user-report'.'">User Reports</a></li>
                                </ul>
                                </li>';

                            $faq_is_expanded 	= '';
							$faq_is_active 	= '';

							if (str_contains($fullurl, 'faq')) {

								$faq_is_expanded 	= 'is-expanded';
								$faq_is_active 	= 'active';

							}

							$str .='<li class="slide '.$faq_is_expanded.'">
								<a class="side-menu__item '.$faq_is_active.'" href="'.url('').'/faq'.'"><i class="side-menu__icon fas fa-question-circle"></i><span class="side-menu__label">Faq</span></a>
							</li>';

						$str .= '</ul>';

		return $str;

	}

	public static function footer(){
        $footer = DB::table('site_configs')->limit(1)->get();
		$str = '<div class="main-footer ht-45">
			<div class="container-fluid pd-t-0-f ht-100p">
				<span> &copy; '.date('Y').' '.$footer[0]->web_footer.' </span>
			</div>
		</div>';

		return $str;

	}

public static function sidenavbar(){

		$str = '<div class="sidebar-navs" style="padding: 0 10px 10px 90px;">
							<ul class="nav  nav-pills-circle">
							
						</div>';

		return $str;

	}





	public static function rightsidenavbar(){

		$str = '<div class="d-flex my-auto">
							<div class=" d-flex right-page">
								<div class="d-flex justify-content-center me-5">
								</div>
							</div>
						</div>';

			return $str;


	}
}
