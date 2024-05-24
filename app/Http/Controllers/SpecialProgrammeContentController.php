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

class SpecialProgrammeContentController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $category = DB::table('special_pro_category')->whereNull('deleted_at')
            ->where('status', '=', 'Active')
            ->orderBy('ID', 'DESC')
            ->get();
        return view('special-programme.contents.index', compact('alldatas','category'));
    }

    public function GetData(Request $request)
    {
        $data = DB::table('special_pro_contents')
            ->select('special_pro_contents.*', 'special_pro_category.category_name')
            ->leftJoin('special_pro_category', 'special_pro_contents.category_id', '=', 'special_pro_category.id')
            ->when($request->category_id, function ($query) use ($request) {
                return $query->where('special_pro_contents.category_id', $request->category_id);
            })
            ->whereNull('special_pro_contents.deleted_at')
            ->orderBy('special_pro_contents.id','desc')
            ->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }
    
    public function CreateContent(Request $request)
    {
        $convertedSlug = Str::of($request->spec_content_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_id' => $request->spe_category,
            'title' => $request->spec_content_title,
            'type' => $request->category_type,
            'status' => $request->spec_content_status,
            'sort_order' => $request->spec_content_sort,
            'page_slug' => $convertedSlug,
            'created_at' => date("Y-m-d H:i:s")
        ];
        
        if ($request->category_type == 'audio') {
            if ($request->file('spec_content_audio')) {
                $audioFile = $request->file('spec_content_audio');
                $filename = time() . '.' . $audioFile->getClientOriginalExtension();
                $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
                $audioFile->move($destinationPath, $filename);
                $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
            } else {
                $file_path = null;
            }
            $arr['content'] = $file_path;
        }
        
        if ($request->category_type == 'video') {
            $arr['content'] = $request->spec_content_video;
        }
        
        if ($request->category_type == 'content') {
            $arr['content'] = $request->spec_content_content;
        }
        // dd($arr);
        $ins = DB::table('special_pro_contents')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Special programme content Created'] : ['status' => 200, 'message' => 'Failed to create content']);
    }
    
    public function GetDatasOf_A_Content(Request $request)
    {
        $content = DB::table('special_pro_contents')->where('id', '=', $request->id)
            ->get();
        return response()->json($content->count() > 0 ? ['status' => 200, 'data' => $content] : ['status' => 400, 'message' => 'Data Not Found']);
    }
    
    public function UpdateTheDataOfContent(Request $request)
    {
        $data = DB::table('special_pro_contents')->where('id', $request->edit_content_id)->first();
        $convertedSlug = Str::of($request->edit_spec_content_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_id' => $request->edit_spe_category,
            'title' => $request->edit_spec_content_title,
            'type' => $request->edit_category_type,
            'status' => $request->edit_spec_content_status,
            'sort_order' => $request->edit_spec_content_sort,
            'page_slug' => $convertedSlug,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        
        if ($request->edit_category_type == 'audio') {
            if ($request->file('edit_spec_content_audio')) {
                $audioFile = $request->file('edit_spec_content_audio');
                $filename = time() . '.' . $audioFile->getClientOriginalExtension();
                $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
                $audioFile->move($destinationPath, $filename);
                $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
                if (file_exists(public_path($data->content))) {
                    unlink(public_path($data->content));
                }
            } else {
                $file_path = $data->content;
            }
            $arr['content'] = $file_path;
        }
        
        if ($request->edit_category_type == 'video') {
            $arr['content'] = $request->edit_spec_content_video;
        }
        
        if ($request->edit_category_type == 'content') {
            $arr['content'] = $request->edit_spec_content_content;
        }
        $update = DB::table('special_pro_contents')->where('id', $request->edit_content_id)->update($arr);
        $data = DB::table('special_pro_contents')
            ->select('special_pro_contents.*', 'special_pro_category.category_name')
            ->leftJoin('special_pro_category', 'special_pro_contents.category_id', '=', 'special_pro_category.id')
            ->where('special_pro_contents.id', $request->edit_content_id)
            ->whereNull('special_pro_contents.deleted_at')
            ->orderBy('special_pro_contents.id','desc')
            ->get();
            DB::table('special_pro_contents')->where('id', $request->edit_content_id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Content successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update content']);
    }
    
    public function UpdateTheSortOrderOfContent(Request $request)
    {
        $arr = [
            'sort_order' => $request->sort_order,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('special_pro_contents')->where('id', $request->id)->update($arr);
        $data = DB::table('special_pro_contents')->where('id', $request->id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Sort Order successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update sort order']);
    }
    
    public function UpdateTheStatusOfContent(Request $request)
    {
        $arr = [
            'status' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('special_pro_contents')->where('id', $request->id)->update($arr);
        $data = DB::table('special_pro_contents')->where('id', $request->id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update status']);
    }
    
    public function DeleteTheContent(Request $request)
    {
        $Category_delete = DB::table('special_pro_contents')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($Category_delete == true ? ['status' => 200, 'message' => 'Content deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
    
}
