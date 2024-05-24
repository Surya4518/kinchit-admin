<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('services-articles.index', compact('alldatas'));
    }
    
    public function index123(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('services-articles.services-articles-test', compact('alldatas'));
    }

    public function ShowServiceContentsPage(Request $request)
    {
    $serviceArticleId = $request->id;
    $serviceArticle = DB::table('services_articles')->where('id', $serviceArticleId)->first();

    $alldatas = [
        'userinfo' => Common::userinfo(),
        'toprightmenu' => Common::toprightmenu(),
        'mainmenu' => Common::mainmenu(),
        'footer' => Common::footer(),
        'sidenavbar' => Common::sidenavbar(),
        'rightsidenavbar' => Common::rightsidenavbar(),
        'serviceTitle' => $serviceArticle ? $serviceArticle->service_title : 'Service Not Found'
    ];

    return view('services-articles.service-content', compact('alldatas'));
    }

    public function CreateServiceArticle(Request $request)
    {
        $convertedSlug = Str::of($request->service_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'service_title' => $request->service_title,
            'meta_title' => $request->meta_title,
            'meta_descp' => $request->meta_description,
            'meta_key' => $request->meta_key,
            'page_slug' => $convertedSlug,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = DB::table('services_articles')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Service Created'] : ['status' => 200, 'message' => 'Failed to create service']);
    }

    public function GetServicesList(Request $request)
    {
        $data = DB::table('services_articles')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function ChangeServicesStatus(Request $request)
    {
        $service_status = DB::table('services_articles')->where('id', '=', $request->id)
            ->update(['status' => $request->status]);
        return response()->json($service_status == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function GetDatasOf_A_Service(Request $request)
    {
        $service = DB::table('services_articles')->where('id', '=', $request->id)
            ->get();
        return response()->json($service->count() > 0 ? ['status' => 200, 'data' => $service] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfService(Request $request)
    {
        
       $rules = [
         'edit_meta_url' => 'required|unique:services_articles,page_slug'
          //'page_slug' => 'required|unique:services_articles,page_slug'
    ];
        
        $messages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute field must be unique.'
        ];

    $validator = Validator::make($request->all(), $rules, $messages);
    
    
    if ($validator->fails()) {
        return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
    }

        
        $convertedSlug = Str::of($request->edit_service_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'service_title' => $request->edit_service_title,
            'meta_title' => $request->edit_meta_title,
            'page_slug' => $request->edit_meta_url,
            'meta_descp' => $request->edit_meta_description,
            'meta_key' => $request->edit_meta_key,
            'updated_at' => date("Y-m-d H:i:s")
        ];
          $ins = DB::table('services_articles')->where('id', $request->edit_service_id)->update($arr);
          $data = DB::table('services_articles')->where('id', $request->edit_service_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'Service successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update service']);
    }

    public function DeleteTheService(Request $request)
    {
        $service_delete = DB::table('services_articles')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($service_delete == true ? ['status' => 200, 'message' => 'Service deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function CreateServiceContent(Request $request)
    {
        $arr = [
            'service_id' => $request->service_article_id,
            'title' => $request->service_content_title,
            'description' => $request->service_content_description,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = DB::table('services_article_contents')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Service Content Created'] : ['status' => 400, 'message' => 'Failed to create service']);
    }

    public function GetServiceContentList(Request $request)
    {
        $data = DB::table('services_article_contents')->where('service_id', '=', $request->id)->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function ChangeServiceContentStatus(Request $request)
    {
        $service_content_status = DB::table('services_article_contents')->where('id', '=', $request->id)
            ->update(['status' => $request->status]);
        return response()->json($service_content_status == true ? ['status' => 200, 'message' => 'Status has been updated'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function GetDatasOf_A_Service_Content(Request $request)
    {
        $service_content = DB::table('services_article_contents')->where('id', '=', $request->id)
            ->get();
        return response()->json($service_content->count() > 0 ? ['status' => 200, 'data' => $service_content] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfServiceContent(Request $request)
    {
        $arr = [
            'title' => $request->edit_service_content_title,
            'description' => $request->edit_service_content_description,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $service_content_update = DB::table('services_article_contents')->where('id', $request->edit_service_content_id)->update($arr);
        $data=DB::table('services_article_contents')->where('id', $request->edit_service_content_id)->first();
        return response()->json($service_content_update == true ? ['status' => 200, 'message' => 'Service Content successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update service']);
    }

    public function DeleteTheServiceContent(Request $request)
    {
        $service_content_delete = DB::table('services_article_contents')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($service_content_delete == true ? ['status' => 200, 'message' => 'Service Content deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ServiceContentImageUpload(Request $request)
    {
        $directory = 'images';
        $imageDetails = [];
        foreach ($request->file('service_content_image') as $image) {
            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path($directory), $filename);
            $imageDetails[] = [
                'service_id' => $request->imageupload_service_article_id,
                'service_content_id' => $request->imageupload_service_content_id,
                'image' => $filename,
                'created_at' => date("Y-m-d H:i:s")
            ];
        }
        $ins = DB::table('services_article_content_images')->insert($imageDetails);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Successfully Uploaded'] : ['status' => 400, 'message' => 'Failed to upload']);
    }

    public function GetServiceContentImages(Request $request)
    {
        $service_content_images = DB::table('services_article_content_images')->where('service_id', '=', $request->service_id)
            ->where('service_content_id', '=', $request->content_id)
            ->get();
        return response()->json($service_content_images->count() > 0 ? ['status' => 200, 'data' => $service_content_images] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function DeleteTheServiceContentImage(Request $request)
    {
        $service_content_image = DB::table('services_article_content_images')->where('id', '=', $request->id)
            ->get();
        $service_content_image_delete = DB::table('services_article_content_images')->where('id', '=', $request->id)
            ->delete();
        return response()->json($service_content_image_delete == true ? ['status' => 200, 'message' => 'Service Content image deleted', 'service_id' => $service_content_image[0]->service_id, 'content_id' => $service_content_image[0]->service_content_id ] : ['status' => 400, 'message' => 'Failed', 'service_id' => $service_content_image[0]->service_id, 'content_id' => $service_content_image[0]->service_content_id ]);
    }

}
