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

class SanchikaCategoryController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('sanchika.category.index', compact('alldatas'));
    }

    public function GetSanchikaCategories(Request $request)
    {
        $categories = DB::table('sanchika_category')->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $categories]);
    }
    
    public function CreateCategory(Request $request)
    {
        $convertedSlug = Str::of($request->sanchik_category_name)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_name' => $request->sanchik_category_name,
            'status' => $request->sanchik_category_status,
            'sort_order' => $request->sanchik_category_sort,
            'category_slug' => $convertedSlug,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = DB::table('sanchika_category')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Sanchika Category Created'] : ['status' => 200, 'message' => 'Failed to create category']);
    }
    
    public function GetDatasOf_A_Category(Request $request)
    {
        $category = DB::table('sanchika_category')->where('id', '=', $request->id)
            ->get();
        return response()->json($category->count() > 0 ? ['status' => 200, 'data' => $category] : ['status' => 400, 'message' => 'Data Not Found']);
    }
    
    public function UpdateTheDataOfCategory(Request $request)
    {
        $data = DB::table('sanchika_category')->where('id', $request->edit_sanchik_cat_id)->first();
        $convertedSlug = Str::of($request->edit_sanchik_category_name)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_name' => $request->edit_sanchik_category_name,
            'status' => $request->edit_sanchik_category_status,
            'sort_order' => $request->edit_sanchik_category_sort,
            'category_slug' => $convertedSlug,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('sanchika_category')->where('id', $request->edit_sanchik_cat_id)->update($arr);
        $data = DB::table('sanchika_category')->where('id', $request->edit_sanchik_cat_id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Category successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update category']);
    }
    
    public function UpdateTheSortOrderOfCategory(Request $request)
    {
        $arr = [
            'sort_order' => $request->sort_order,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('sanchika_category')->where('id', $request->id)->update($arr);
        $data = DB::table('sanchika_category')->where('id', $request->id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Sort Order successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update sort order']);
    }
    
    public function UpdateTheStatusOfCategory(Request $request)
    {
        $arr = [
            'status' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('sanchika_category')->where('id', $request->id)->update($arr);
        $data = DB::table('sanchika_category')->where('id', $request->id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update status']);
    }
    
    public function DeleteTheCategory(Request $request)
    {
        $Category_delete = DB::table('sanchika_category')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($Category_delete == true ? ['status' => 200, 'message' => 'Category deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
    
}
