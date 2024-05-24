<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('general-donation.index', compact('alldatas'));
    }

    public function GetDonationList(Request $request)
    {
        $data = DB::table('general_donation')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function CreateDonation(Request $request)
    {
        $arr = [
            'category_name' => ucwords($request->category_name),
            'amount' => $request->amount,
            'status' => ucwords($request->status),
            'short_order' => $request->short_order,
        ];
        $ins = DB::table('general_donation')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Donation Created'] : ['status' => 200, 'message' => 'Failed to create Donation']);
    }

    public function GetDatasOf_A_Donation(Request $request)
    {
        $donation = DB::table('general_donation')->where('id', '=', $request->id)
            ->get();
        return response()->json($donation->count() > 0 ? ['status' => 200, 'data' => $donation] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfDonation(Request $request)
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
            'amount' => $request->edit_amount,
            'status' => ucwords($request->edit_status),
            'short_order' => $request->edit_short_order,
        ];
        $ins = DB::table('general_donation')->where('id', $request->edit_donation_id)->update($arr);
        $data = DB::table('general_donation')->where('id', $request->edit_donation_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'Donation successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update Donation']);
    }

    public function DeleteTheDonation(Request $request)
    {
        $donation_delete = DB::table('general_donation')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($donation_delete == true ? ['status' => 200, 'message' => 'Donation Deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
