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
use App\Models\{
    Course_lesson
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class KinchitEnpaniCategoryController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('en-pani.categories.index', compact('alldatas'));
    }

    public function ShowCategoryList(Request $request)
    {
        $category = Course_lesson::where('post_type', 'LIKE', 'kinchit-en-pani')
            ->whereNull('deleted_at')
            ->get();
        return response()->json(['status' => 200, 'data' => $category]);
    }

    public function CreateEnpaniCategory(Request $request)
    {
        $convertedSlug = Str::of($request->enpani_category_name)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s"),
            'post_title' => $request->enpani_category_name,
            'post_status' => $request->enpani_category_publish_status,
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s"),
            'post_type' => 'kinchit-en-pani',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Course_lesson::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Category Created'] : ['status' => 400, 'message' => 'Failed to create category']);
    }

    public function GetDataOf_A_EnpaniCategory(Request $request)
    {
        $category = Course_lesson::where('ID', '=', $request->id)
            ->get();
        return response()->json($category->count() > 0 ? ['status' => 200, 'data' => $category] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfEnpaniCategory(Request $request)
    {
        $convertedSlug = Str::of($request->edit_enpani_category_name)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_title' => $request->edit_enpani_category_name,
            'post_status' => $request->edit_enpani_category_publish_status,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('ID', $request->edit_enpani_category_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Category Updated'] : ['status' => 400, 'message' => 'Failed to update category']);
    }

    public function DeleteTheEnpaniCategory(Request $request)
    {
        $enpani_category_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($enpani_category_delete == true ? ['status' => 200, 'message' => 'Category deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
