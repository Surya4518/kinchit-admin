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

class SanchikaContentController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $category = DB::table('sanchika_category')->whereNull('deleted_at')
            ->where('status', '=', 'Active')
            ->orderBy('ID', 'DESC')
            ->get();
        $language = DB::table('language')->whereNull('deleted_at')
            ->where('status', '=', 'Active')
            ->orderBy('sort_order', 'DESC')
            ->get();
        return view('sanchika.contents.index', compact('alldatas','category','language'));
    }

    public function GetData(Request $request)
    {
        $data = DB::table('kinchit_sanchika')
            ->select('kinchit_sanchika.*', 'sanchika_category.category_name', 'language.name as language_name')
            ->leftJoin('sanchika_category', 'kinchit_sanchika.category_id', '=', 'sanchika_category.id')
            ->leftJoin('language', 'kinchit_sanchika.language', '=', 'language.id')
            ->when($request->category_id, function ($query) use ($request) {
                return $query->where('kinchit_sanchika.category_id', $request->category_id);
            })
            ->when($request->language_id, function ($query) use ($request) {
                return $query->where('kinchit_sanchika.language', $request->language_id);
            })
            ->whereNull('kinchit_sanchika.deleted_at')
            ->orderBy('kinchit_sanchika.id','desc')
            ->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }
    
    public function CreateContent(Request $request)
    {
        $convertedSlug = Str::of($request->pdf_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_id' => $request->sanchik_category,
            'title' => $request->pdf_title,
            'status' => $request->sanchik_pdf_status,
            'sort_order' => $request->sanchik_pdf_sort,
            'page_slug' => $convertedSlug,
            'language' => $request->sanchik_language,
            'created_at' => date("Y-m-d H:i:s")
        ];
        if ($request->file('sanchik_pdf')) {
            $audioFile = $request->file('sanchik_pdf');
            $filename = time() . '.' . $audioFile->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $audioFile->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $arr['pdf_url'] = $file_path;
        $ins = DB::table('kinchit_sanchika')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Sanhika PDF successfully added'] : ['status' => 200, 'message' => 'Failed to add PDF..!']);
    }
    
    public function GetDatasOf_A_Content(Request $request)
    {
        $content = DB::table('kinchit_sanchika')->where('id', '=', $request->id)
            ->get();
        return response()->json($content->count() > 0 ? ['status' => 200, 'data' => $content] : ['status' => 400, 'message' => 'Data Not Found']);
    }
    
    public function UpdateTheDataOfContent(Request $request)
    {
        $data = DB::table('kinchit_sanchika')->where('id', $request->edit_sanchik_content_id)->first();
        $convertedSlug = Str::of($request->edit_pdf_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'category_id' => $request->edit_sanchik_category,
            'title' => $request->edit_pdf_title,
            'status' => $request->edit_sanchik_pdf_status,
            'sort_order' => $request->edit_sanchik_pdf_sort,
            'page_slug' => $convertedSlug,
            'language' => $request->edit_sanchik_language,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        if ($request->file('edit_sanchik_pdf')) {
            $audioFile = $request->file('edit_sanchik_pdf');
            $filename = time() . '.' . $audioFile->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $audioFile->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
            if (file_exists(public_path($data->pdf_url))) {
                unlink(public_path($data->pdf_url));
            }
        } else {
            $file_path = $data->pdf_url;
        }
        $arr['pdf_url'] = $file_path;
        $update = DB::table('kinchit_sanchika')->where('id', $request->edit_sanchik_content_id)->update($arr);
        $data = DB::table('kinchit_sanchika')
            ->select('kinchit_sanchika.*', 'sanchika_category.category_name', 'language.name as language_name')
            ->leftJoin('sanchika_category', 'kinchit_sanchika.category_id', '=', 'sanchika_category.id')
            ->leftJoin('language', 'kinchit_sanchika.language', '=', 'language.id')
            ->where('kinchit_sanchika.id', $request->edit_sanchik_content_id)
            ->whereNull('kinchit_sanchika.deleted_at')
            ->orderBy('kinchit_sanchika.id','desc')
            ->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'PDF data successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update data']);
    }
    
    public function UpdateTheSortOrderOfContent(Request $request)
    {
        $arr = [
            'sort_order' => $request->sort_order,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('kinchit_sanchika')->where('id', $request->id)->update($arr);
        $data = DB::table('kinchit_sanchika')
            ->select('kinchit_sanchika.*', 'sanchika_category.category_name', 'language.name as language_name')
            ->leftJoin('sanchika_category', 'kinchit_sanchika.category_id', '=', 'sanchika_category.id')
            ->leftJoin('language', 'kinchit_sanchika.language', '=', 'language.id')
            ->where('kinchit_sanchika.id', $request->id)
            ->whereNull('kinchit_sanchika.deleted_at')
            ->orderBy('kinchit_sanchika.id','desc')
            ->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Sort Order successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update sort order']);
    }
    
    public function UpdateTheStatusOfContent(Request $request)
    {
        $arr = [
            'status' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DB::table('kinchit_sanchika')->where('id', $request->id)->update($arr);
        $data = DB::table('kinchit_sanchika')
            ->select('kinchit_sanchika.*', 'sanchika_category.category_name', 'language.name as language_name')
            ->leftJoin('sanchika_category', 'kinchit_sanchika.category_id', '=', 'sanchika_category.id')
            ->leftJoin('language', 'kinchit_sanchika.language', '=', 'language.id')
            ->where('kinchit_sanchika.id', $request->id)
            ->whereNull('kinchit_sanchika.deleted_at')
            ->orderBy('kinchit_sanchika.id','desc')
            ->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update status']);
    }
    
    public function DeleteTheContent(Request $request)
    {
        $Category_delete = DB::table('kinchit_sanchika')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($Category_delete == true ? ['status' => 200, 'message' => 'Content deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
    
}
