<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('our-service.index', compact('alldatas'));
    }

    public function GetServiceContentList(Request $request)
    {
        $data = DB::table('home_banner')->where('type','our-service')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateServiceArticle(Request $request)
    {
        $arr = [
            'title' => $request->service_title,
            'content' => $request->content,
            'type' => 'our-service',
            'status' => $request->status,
            'shord_order' => $request->shord_order
        ];
        $ins = DB::table('home_banner')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Service Created'] : ['status' => 200, 'message' => 'Failed to create service']);
    }

    public function ChangeServicesStatus(Request $request)
    {
        $service_status = DB::table('home_banner')->where('id', '=', $request->id)
            ->update(['status' => $request->status]);
        return response()->json($service_status == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function GetDatasOf_A_Service(Request $request)
    {
        $service = DB::table('home_banner')->where('id', '=', $request->id)->get();
        return response()->json($service->count() > 0 ? ['status' => 200, 'data' => $service] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfService(Request $request)
    {

        // $rules = [
        //     'edit_meta_url' => 'required|unique:services_articles,page_slug'
        //     //'page_slug' => 'required|unique:services_articles,page_slug'
        // ];

        // $messages = [
        //     'required' => 'The :attribute field is required.',
        //     'unique' => 'The :attribute field must be unique.'
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);


        // if ($validator->fails()) {
        //     return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        // }
        $arr = [
            'title' => $request->edit_service_title,
            'content' => $request->edit_content,
            'type' =>'our-service' ,
            'shord_order' => $request->edit_shord_order,
            'status' => $request->edit_status,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $ins = DB::table('home_banner')->where('id', $request->edit_service_id)->update($arr);
        $data = DB::table('home_banner')->where('id', $request->edit_service_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'Service successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update service']);
    }

    public function DeleteTheService(Request $request)
    {
        $service_delete = DB::table('home_banner')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($service_delete == true ? ['status' => 200, 'message' => 'Service deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

 

    public function HomeImage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $service = DB::table('services_articles')->where('status','0')->whereNull('deleted_at')->get();
        return view('home-image.index', compact('alldatas','service'));
    }

    public function GetHomeImageList(Request $request)
    {
        $data = DB::table('home_banner_image')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateHomeImage(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $arr = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'shord_order' => $request->shord_order,
            'service_url' => $request->service_url,
            'image' =>  $file_path
        ];
        $ins = DB::table('home_banner_image')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Created Successfully'] : ['status' => 200, 'message' => 'Failed to create service']);
    }

    public function ChangeHomeImageStatus(Request $request)
    {
        $service_status = DB::table('home_banner_image')->where('id', '=', $request->id)
            ->update(['status' => $request->status]);
        return response()->json($service_status == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function GetDatasOf_A_home_image(Request $request)
    {
        $service = DB::table('home_banner_image')->where('id', '=', $request->id)->get();
        return response()->json($service->count() > 0 ? ['status' => 200, 'data' => $service] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfHomeImage(Request $request)
    {
        $existing_image = DB::table('home_banner_image')->where('id', $request->edit_service_id)->value('image');
        
        if ($request->hasFile('edit_image')) {
            $image = $request->file('edit_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $existing_image; // Use the existing image path if no new image is uploaded
        }
    
        $arr = [
            'title' => $request->edit_title,
            'content' => $request->edit_content,
            'status' => $request->edit_status,
            'shord_order' => $request->edit_shord_order,
            'service_url' => $request->edit_service_url,
            'image' => $file_path
        ];
    
        $ins = DB::table('home_banner_image')->where('id', $request->edit_service_id)->update($arr);
    
        $data = DB::table('home_banner_image')->where('id', $request->edit_service_id)->first();
    
        return response()->json($ins ? ['status' => 200, 'message' => 'Successfully Updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update service']);
    }
    

    public function DeleteTheHomeImage(Request $request)
    {
        $service_delete = DB::table('home_banner_image')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($service_delete == true ? ['status' => 200, 'message' => 'Deleted Successfully'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function AboutUs(){
      
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('about-us.index', compact('alldatas'));  
    }

    public function GetAboutUsList(Request $request)
    {
        $data = DB::table('home_banner')->where('type','about-us')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateAboutUs(Request $request)
    {
        $arr = [
            'title' => $request->title,
            'content' => $request->content,
            'type' => 'about-us',
            'status' => $request->status,
            'iframe_url' => $request->video_content,
            'shord_order' => $request->shord_order
        ];
        $ins = DB::table('home_banner')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'About Us Created'] : ['status' => 200, 'message' => 'Failed to create service']);
    }


    public function ChangeAboutUsStatus(Request $request)
    {
        $service_status = DB::table('home_banner')->where('id', '=', $request->id)
            ->update(['status' => $request->status]);
        return response()->json($service_status == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed']);
    }


    public function GetDatasOf_A_AboutUs(Request $request)
    {
        $service = DB::table('home_banner')->where('id', '=', $request->id)->get();
        return response()->json($service->count() > 0 ? ['status' => 200, 'data' => $service] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfAboutUs(Request $request)
    {
        $arr = [
            'title' => $request->edit_title,
            'content' => $request->edit_content,
            'type' =>'about-us' ,
            'shord_order' => $request->edit_shord_order,
            'status' => $request->edit_status,
            'iframe_url' => $request->edit_video_content,
            'shord_order' => $request->edit_shord_order,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $ins = DB::table('home_banner')->where('id', $request->edit_service_id)->update($arr);
        $data = DB::table('home_banner')->where('id', $request->edit_service_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'About Us successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update service']);
    }

    public function DeleteTheAboutUs(Request $request)
    {
        $service_delete = DB::table('home_banner')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($service_delete == true ? ['status' => 200, 'message' => 'About Us deleted'] : ['status' => 400, 'message' => 'Failed']);
    }


    public function HomeBanner(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        // $service = DB::table('services_articles')->where('status','0')->whereNull('deleted_at')->get();
        return view('home-banner.index', compact('alldatas',));
    }

    public function GetHomeBannerList(Request $request)
    {
        $data = DB::table('home_page_banner')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateHomeBanner(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('banner/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'banner/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $arr = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'shord_order' => $request->shord_order,
            'bannerimage' =>  $file_path
        ];
        $ins = DB::table('home_page_banner')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Created Successfully'] : ['status' => 200, 'message' => 'Failed to create service']);
    }

    public function ChangeHomeBannerStatus(Request $request)
    {
        $service_status = DB::table('home_page_banner')->where('id', '=', $request->id)
            ->update(['status' => $request->status]);
        return response()->json($service_status == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function GetDatasOf_A_home_banner(Request $request)
    {
        $service = DB::table('home_page_banner')->where('id', '=', $request->id)->get();
        return response()->json($service->count() > 0 ? ['status' => 200, 'data' => $service] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfHomeBanner(Request $request)
    {
        $existing_image = DB::table('home_page_banner')->where('id', $request->edit_service_id)->value('bannerimage');
        
        if ($request->hasFile('edit_image')) {
            $image = $request->file('edit_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('banner/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'banner/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $existing_image; // Use the existing image path if no new image is uploaded
        }
    
        $arr = [
            'title' => $request->edit_title,
            'content' => $request->edit_content,
            'status' => $request->edit_status,
            'shord_order' => $request->edit_shord_order,
            'bannerimage' => $file_path
        ];
    
        $ins = DB::table('home_page_banner')->where('id', $request->edit_service_id)->update($arr);
    
        $data = DB::table('home_page_banner')->where('id', $request->edit_service_id)->first();
    
        return response()->json($ins ? ['status' => 200, 'message' => 'Successfully Updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update service']);
    }
    

    public function DeleteTheHomeBanner(Request $request)
    {
        $service_delete = DB::table('home_page_banner')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($service_delete == true ? ['status' => 200, 'message' => 'Deleted Successfully'] : ['status' => 400, 'message' => 'Failed']);
    }

}
