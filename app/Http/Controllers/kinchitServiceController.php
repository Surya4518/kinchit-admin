<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class kinchitServiceController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('kinchit-service.index', compact('alldatas'));
    }

    public function ShowList(Request $request)
    {
        $result = DB::table('kinchit_services')->whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();
        return response()->json(['status' => 200, 'data' => $result]);
    }

    public function CreateData(Request $request)
    {
        $rules = [
            'service_title' => 'required',
            'service_content' => 'required',
            'sort_order' => 'required',
            'status_of_data' => 'required',
            // 'upload_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($request->file('upload_image')) {
            $image = $request->file('upload_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $create = DB::table('kinchit_services')->insert([
            'title' => $request->service_title,
            'content' => $request->service_content,
            'image' =>  $file_path,
            'short_order' => $request->sort_order,
            'status' => $request->status_of_data,
            'video_url' => $request->video_url,
        ]);
        return response()->json($create == true ? ['status' => 200, 'message' => 'Data has been successfully created.'] : ['status' => 400, 'message' => 'Failed to create data.']);
    }

    public function ChangeStatus(Request $request)
    {
        $model = DB::table('kinchit_services')->where('id', $request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

    public function GetEditData(Request $request)
    {
        $result = DB::table('kinchit_services')->where('id', $request->id)->get();
        return response()->json($result->count() > 0 ? ['status' => 200, 'data' => $result] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateData(Request $request)
    {
        $rules = [
            'edit_service_title' => 'required',
            'edit_service_content' => 'required',
            'edit_short_order' => 'required',
            'edit_status_of_data' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }

        // Get the current image path
        $currentImage = DB::table('kinchit_services')->where('id', $request->edit_id)->value('image');

        if ($request->file('edit_upload_image')) {
            // New image uploaded
            $image = $request->file('edit_upload_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            // No new image uploaded, keep the current image
            $file_path = $currentImage;
        }

        // Update the database
        $update = DB::table('kinchit_services')->where('id', $request->edit_id)->update([
            'title' => $request->edit_service_title,
            'content' => $request->edit_service_content,
            'short_order' => $request->edit_short_order,
            'status' => $request->edit_status_of_data,
            'image' => $file_path,
            'video_url' => $request->edit_video_url,
        ]);

        $data = DB::table('kinchit_services')->where('id', $request->edit_id)->first();

        return response()->json($update ? ['status' => 200, 'message' => 'Data has been successfully updated.', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update data.']);
    }

    public function DeleteTheData(Request $request)
    {
        $delete = DB::table('kinchit_services')->where('id', $request->id)->update(['deleted_at' => date("Y-m-d H:i:s")]);;
        return response()->json($delete == true ? ['status' => 200, 'message' => 'Data has been succesfully deleted'] : ['status' => 400, 'message' => 'Failed to delete data.']);
    }
}
