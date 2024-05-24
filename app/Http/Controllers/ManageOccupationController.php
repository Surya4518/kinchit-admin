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
use App\Models\ManageOccupation;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ManageOccupationController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('lakshmi-kalyanam.manage-occupation.index', compact('alldatas'));
    }

    public function ShowList(Request $request)
    {
        $result = ManageOccupation::whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get();
        return response()->json(['status' => 200, 'data' => $result]);
    }

    public function ChangeStatus(Request $request)
    {
        $model = ManageOccupation::find($request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

    public function DeleteTheData(Request $request)
    {
        $delete = ManageOccupation::find($request->id)->delete();
        return response()->json($delete == true ? ['status' => 200, 'message' => 'Data has been succesfully deleted'] : ['status' => 400, 'message' => 'Failed to delete data.']);
    }

    public function CreateData(Request $request)
    {
        $rules = [
            'occupation_title' => 'required',
            'sort_order' => 'required',
            'status_of_data' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $create = ManageOccupation::create([
            'name' => $request->occupation_title,
            'sortorder' => $request->sort_order,
            'status' => $request->status_of_data,
        ]);
        return response()->json($create == true ? ['status' => 200, 'message' => 'Data has been successfully created.'] : ['status' => 400, 'message' => 'Failed to create data.']);
    }

    public function GetEditData(Request $request)
    {
        $result = ManageOccupation::find($request->id);
        return response()->json($result->count() > 0 ? ['status' => 200, 'data' => $result] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateData(Request $request)
    {
        $rules = [
            'edit_occupation_title' => 'required',
            'edit_sort_order' => 'required',
            'edit_status_of_data' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $update = ManageOccupation::find($request->edit_id)->update([
            'name' => $request->edit_occupation_title,
            'sortorder' => $request->edit_sort_order,
            'status' => $request->edit_status_of_data,
        ]);
        $data=ManageOccupation::find($request->edit_id)->first();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Data has been successfully updated.', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update data.']);
    }
}
