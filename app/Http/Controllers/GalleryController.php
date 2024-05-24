<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('gallery-category.index', compact('alldatas'));
    }

    public function GetGallerCategoryList(Request $request)
    {
        $data = DB::table('gallery_category')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateGallerCategory(Request $request)
    {
        $arr = [
            'category_name' => ucwords($request->category_name),
            'sort_order' => $request->short_order,
            'status' => ucwords($request->status),
        ];
        $ins = DB::table('gallery_category')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Gallery Category Created'] : ['status' => 200, 'message' => 'Failed to create Gallery Category']);
    }

    public function GetDatasOf_A_GalleryCategory(Request $request)
    {
        $gallerycategory = DB::table('gallery_category')->where('id', '=', $request->id)
            ->get();
        return response()->json($gallerycategory->count() > 0 ? ['status' => 200, 'data' => $gallerycategory] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfGalleryCategory(Request $request)
    {

        //    $rules = [
        //      'edit_meta_url' => 'required|unique:services_articles,page_slug'
        //       //'page_slug' => 'required|unique:services_articles,page_slug'
        // ];

        //     $messages = [
        //         'required' => 'The :attribute field is required.',
        //         'unique' => 'The :attribute field must be unique.'
        //     ];

        // $validator = Validator::make($request->all(), $rules, $messages);


        // if ($validator->fails()) {
        //     return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        // }

        $arr = [
            'category_name' => ucwords($request->edit_category_name),
            'sort_order' => $request->edit_short_order,
            'status' => ucwords($request->edit_status),
        ];
        $ins = DB::table('gallery_category')->where('id', $request->edit_gallery_category_id)->update($arr);
        $data = DB::table('gallery_category')->where('id', $request->edit_gallery_category_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'Gallery Category successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update Gallery Category']);
    }

    public function DeleteTheGalleryCategory(Request $request)
    {
        $gallery_delete = DB::table('gallery_category')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($gallery_delete == true ? ['status' => 200, 'message' => 'Gallery Category Deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ImageIndex(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();

        $gallery_category = DB::table('gallery_category')->whereNull('deleted_at')->get();
        return view('gallery-image.index', compact('alldatas', 'gallery_category'));
    }

    public function GetGallerImageList(Request $request)
    {
        $data = DB::table('gallery_images')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateGallerImage(Request $request)
    {
        if ($request->file('upload_image')) {
            $image = $request->file('upload_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $arr = [
            'category_id' => $request->category_name,
            'title' => ucwords($request->tittle),
            'sort_order' => $request->short_order,
            'status' => ucwords($request->status),
            'image' =>  $file_path,
            'description' => ucwords($request->description),
        ];
        // dd($file_path);
        $ins = DB::table('gallery_images')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Gallery Image Created'] : ['status' => 200, 'message' => 'Failed to create Gallery Image']);
    }

    public function GetDatasOf_A_GalleryImage(Request $request)
    {
        $gallerycategory = DB::table('gallery_images')
            ->select('gallery_images.*', 'gallery_category.category_name')
            ->leftJoin('gallery_category', 'gallery_images.category_id', '=', 'gallery_category.id')
            ->where('gallery_images.id', $request->id)
            ->whereNull('gallery_category.deleted_at')
            ->get();
        // dd( $gallerycategory);
        return response()->json($gallerycategory->count() > 0 ? ['status' => 200, 'data' => $gallerycategory] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfGalleryImage(Request $request)
    {
        $existing_image = DB::table('gallery_images')->where('id', $request->edit_gallery_category_id)->value('image');

        if ($request->file('upload_image')) {
            $image = $request->file('upload_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $existing_image; // Use the existing image path if no new image is uploaded
        }

        $arr = [
            'category_id' => $request->edit_category_name,
            'title' => ucwords($request->edit_tittle),
            'sort_order' => $request->edit_short_order,
            'status' => ucwords($request->edit_status),
            'image' =>  $file_path,
            'description' => ucwords($request->edit_description),
        ];

        $ins = DB::table('gallery_images')->where('id', $request->edit_gallery_category_id)->update($arr);
        $data = DB::table('gallery_images')->where('id', $request->edit_gallery_category_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'Gallery Image successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update Gallery Image']);
    }
    public function DeleteTheGalleryImage(Request $request)
    {
        $gallery_delete = DB::table('gallery_images')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($gallery_delete == true ? ['status' => 200, 'message' => 'Gallery Image Deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ChangeStatus(Request $request)
    {
        $model = DB::table('gallery_images')->where('id', $request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

    public function ChangeStatusCategory(Request $request)
    {
        $model = DB::table('gallery_category')->where('id', $request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }
}
