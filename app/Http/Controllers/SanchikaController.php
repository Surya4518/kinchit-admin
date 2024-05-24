<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SanchikaController extends Controller
{
    public function Index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
       $sanchikacategory =   DB::table('sanchika_category')->where('status','Active')->whereNull('deleted_at')->get();
       $language =   DB::table('language')->where('status','Active')->whereNull('deleted_at')->get();
        return view('sanchika.index', compact('alldatas','sanchikacategory','language'));
    }  

    public function GetSanchikaList(Request $request)
    {
        $data = DB::table('kinchit_sanchika')->whereNull('deleted_at')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function ChangeStatus(Request $request)
    {
        $model = DB::table('kinchit_sanchika')->where('id',$request->id);
        $update = $model->update([
            'status' => $request->status,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully changed.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

    public function CreateSanchika(Request $request){

        if ($request->hasFile('pdf_url')) {
            $pdf = $request->file('pdf_url');
            $filename = time() . '.' . $pdf->getClientOriginalExtension();
            $path = $pdf->storeAs('uploads/' . date("Y") . '/' . date("m"), $filename); // Store the file in the specified directory with the specified filename
        } else {
            $path = null;
        }
    
        $arr = [
            'title' => $request->category_name,
            'pdf_url' => $path,
            'language' => ucwords($request->language), // Assuming 'language' is the correct field name
            'sort_order' => $request->short_order,
            'status' => ucwords($request->status),
        ];
    
      $ins = DB::table('kinchit_sanchika')->insert($arr);

    return response()->json($ins == true ? ['status' => 200, 'message' => 'Sanchika Created'] : ['status' => 200, 'message' => 'Failed to create Sanchika']);
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
        $donation_delete = DB::table('kinchit_sanchika')->where('id', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($donation_delete == true ? ['status' => 200, 'message' => 'Sanchik Deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
