<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
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
    ManageState,
    ManageCity
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ManageCityController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $state = ManageState::whereNull('deleted_at')
            ->where('status', '=', 'Active')
            ->orderBy('id', 'ASC')
            ->get();
        return view('lakshmi-kalyanam.manage-city.index', compact('state', 'alldatas'));
    }

    public function ShowList(Request $request)
    {
        $result = DB::table('city')
            ->select('city.*', 'state.name as state_name', 'country.name as country_name')
            ->leftJoin('state', 'city.state', '=', 'state.id')
            ->leftJoin('country', 'state.country', '=', 'country.id')
            ->whereNull('city.deleted_at')
            ->get();
        return response()->json(['status' => 200, 'data' => $result]);
    }

    public function ChangeStatus(Request $request)
    {
        $model = ManageCity::find($request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

    public function DeleteTheData(Request $request)
    {
        $delete = ManageCity::find($request->id)->delete();
        return response()->json($delete == true ? ['status' => 200, 'message' => 'Data has been succesfully deleted'] : ['status' => 400, 'message' => 'Failed to delete data.']);
    }

    public function CreateData(Request $request)
    {
        $rules = [
            'city_title' => 'required',
            'state' => 'required',
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
        $create = ManageCity::create([
            'name' => $request->city_title,
            'state' => $request->state,
            'sortorder' => $request->sort_order,
            'status' => $request->status_of_data,
        ]);
        return response()->json($create == true ? ['status' => 200, 'message' => 'Data has been successfully created.'] : ['status' => 400, 'message' => 'Failed to create data.']);
    }

    public function GetEditData(Request $request)
    {
        $result = ManageCity::find($request->id);
        return response()->json($result->count() > 0 ? ['status' => 200, 'data' => $result] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateData(Request $request)
    {
        $rules = [
            'edit_city_title' => 'required',
            'edit_state' => 'required',
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
        $update = ManageCity::find($request->edit_id)->update([
            'name' => $request->edit_city_title,
            'state' => $request->edit_state,
            'sortorder' => $request->edit_sort_order,
            'status' => $request->edit_status_of_data,
        ]);
        $data = DB::table('city')
            ->select('city.*', 'state.name as state_name', 'country.name as country_name')
            ->leftJoin('state', 'city.state', '=', 'state.id')
            ->leftJoin('country', 'state.country', '=', 'country.id')
            ->whereNull('city.deleted_at')
            ->where('city.id', $request->edit_id)->get();
        return response()->json($update == true ? ['status' => 200, 'message' => 'Data has been successfully updated.', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update data.']);
    }
}
