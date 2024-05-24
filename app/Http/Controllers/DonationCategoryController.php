<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use Illuminate\Support\Facades\DB;

class DonationCategoryController extends Controller
{
    public function Index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('donation-category.index', compact('alldatas'));
    }

    public function GetDonationList(Request $request)
    {
        $data = DB::table('donation_categories')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function ChangeStatus(Request $request)
    {
        $model = DB::table('donation_categories')->where('id', $request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

    public function CreateDonationCategory(Request $request)
    {
        $arr = [
            'category_name' => $request->category_name,
            'amount' => ucwords($request->amount),
            'sort_order' => $request->short_order,
            'status' => ucwords($request->status),
        ];
        $ins = DB::table('donation_categories')->insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Donation Category Created'] : ['status' => 200, 'message' => 'Failed to create Donation Category']);
    }

    public function GetDatasOf_A_DonationCategory(Request $request)
    {
        $donationcategory = DB::table('donation_categories')
            ->where('id', $request->id)
            ->whereNull('deleted_at')
            ->get();
        return response()->json($donationcategory->count() > 0 ? ['status' => 200, 'data' => $donationcategory] : ['status' => 400, 'message' => 'Data Not Found']);
    }

    public function UpdateTheDataOfDonationCategory(Request $request)
    {

        $arr = [
            'category_name' => $request->edit_category_name,
            'amount' => ucwords($request->edit_amount),
            'sort_order' => $request->edit_short_order,
            // 'status' => ucwords($request->edit_status),
        ];
        $ins = DB::table('donation_categories')->where('id', $request->edit_donation_category_id)->update($arr);
        $data = DB::table('donation_categories')->where('id', $request->edit_donation_category_id)->first();

        return response()->json($ins == true ? ['status' => 200, 'message' => 'Donation Category successfully updated', 'updatedRowData' => $data] : ['status' => 400, 'message' => 'Failed to update Donation Category ']);
    }

    public function DeleteTheDonationCategory(Request $request)
    {
        $donation_delete = DB::table('donation_categories')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($donation_delete == true ? ['status' => 200, 'message' => 'Donation Category Deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
