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
use App\Models\Tutorial_categories;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class RmUpanyasamCategoryController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('rm-online-upanyasam.index', compact('alldatas'));
    }

    public function ShowCategoryList(Request $request)
    {
        $categories = Tutorial_categories::whereNull('deleted_at')
            ->where('category_type', 'like', '%rm-online-upanyasam%')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $categories]);
    }

    public function CreateTutorialCategory(Request $request)
    {
        $convertedSlug = Str::of($request->tut_category_name)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_name' => $request->tut_category_name,
            'category_type' => $request->tut_category_type,
            'category_slug' => $convertedSlug,
            'description' => $request->tut_category_description,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Tutorial_categories::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Tutorial Category Created'] : ['status' => 200, 'message' => 'Failed to create category']);
    }

    public function GetDatasOf_A_TutorialCategory(Request $request)
    {
        $category = Tutorial_categories::where('id', '=', $request->id)
            ->get();
        return response()->json($category->count() > 0 ? ['status' => 200, 'data' => $category] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfTutorialCategory(Request $request)
    {
        $convertedSlug = Str::of($request->edit_tut_category_name)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_name' => $request->edit_tut_category_name,
            'category_type' => $request->edit_tut_category_type,
            'category_slug' => $convertedSlug,
            'description' => $request->edit_tut_category_description,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Tutorial_categories::where('id', $request->edit_tut_category_id)->update($arr);
        $data = Tutorial_categories::where('id', $request->edit_tut_category_id)->first();
        
        return response()->json($update == true ? ['status' => 200, 'message' => 'Category successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update category']);
    }

    public function DeleteTheTutorialCategory(Request $request)
    {
        $Category_delete = Tutorial_categories::where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($Category_delete == true ? ['status' => 200, 'message' => 'Category deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
