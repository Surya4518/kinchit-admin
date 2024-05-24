<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Session;
use Storage;
use Mail;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Common;
use App\Models\{
    RdBooking
}
;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class RdBookingController extends Controller
{

    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('ramanujarya-divyanjna.index', compact('alldatas'));
    }

    public function ShowData(Request $request)
    {
        $data = RdBooking::whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function BookingCreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('ramanujarya-divyanjna.create-book', compact('alldatas'));
    }

    public function ShowBookingDetails(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $data = RdBooking::where('id', '=', $request->id)
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return view('ramanujarya-divyanjna.book-details', compact('alldatas', 'data'));
    }

    public function StoreTheBookingFromRD(Request $request)
    {
        try {
            $rules = [
                'booker_name' => 'required',
                'booker_lastname' => 'required',
                'no_of_ppl' => 'required',
                'ppl_names.*' => 'required',
                'divyadesam' => 'required',
                'date_from' => 'required',
                'date_to' => 'required',
                'phone_no' => 'required',
                'email' => 'required|unique:rd_booking,email',
                'address1' => 'required',
                'address2' => 'required',
                'city_name' => 'required',
                'state_name' => 'required',
                'pincode' => 'required',
                'country_name' => 'required',
                'kkt_or_not' => 'required',
            ];

            if ($request->kkt_or_not == "yes") {
                $rules['membership_id'] = 'required';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
            }
            $entry_arr = [
                'booker_name' => $request->booker_name,
                'booker_lastname' => $request->booker_lastname,
                'no_of_people' => $request->no_of_ppl,
                'people_names' => json_encode($request->ppl_names, true),
                'divyadesam' => $request->divyadesam,
                'date_from' => date("Y-m-d", strtotime($request->date_from)),
                'date_to' => date("Y-m-d", strtotime($request->date_to)),
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'address_1' => $request->address1,
                'address_2' => $request->address2,
                'city' => $request->city_name,
                'state' => $request->state_name,
                'pincode' => $request->pincode,
                'country' => $request->country_name,
                'kkt_or_not' => $request->kkt_or_not,
                'membership_id' => $request->membership_id,
            ];
            $insert = RdBooking::create($entry_arr);
            return response()->json($insert == true ? ["status" => 200, "message" => "Successfully booked"] : ["status" => 400, "message" => "Failed to book"]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function UpdateTheBookingFromRD(Request $request)
    {
        try {
            $rules = [
                'booker_name' => 'required',
                'booker_lastname' => 'required',
                'no_of_ppl' => 'required',
                'ppl_names.*' => 'required',
                'divyadesam' => 'required',
                'date_from' => 'required',
                'date_to' => 'required',
                'phone_no' => 'required',
                'email' => 'required|unique:rd_booking,email,'.$request->book_edit_id,
                'address1' => 'required',
                'address2' => 'required',
                'city_name' => 'required',
                'state_name' => 'required',
                'pincode' => 'required',
                'country_name' => 'required',
                'kkt_or_not' => 'required',
            ];

            if ($request->kkt_or_not == "yes") {
                $rules['membership_id'] = 'required';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
            }
            $entry_arr = [
                'booker_name' => $request->booker_name,
                'booker_lastname' => $request->booker_lastname,
                'no_of_people' => $request->no_of_ppl,
                'people_names' => json_encode($request->ppl_names, true),
                'divyadesam' => $request->divyadesam,
                'date_from' => date("Y-m-d", strtotime($request->date_from)),
                'date_to' => date("Y-m-d", strtotime($request->date_to)),
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'address_1' => $request->address1,
                'address_2' => $request->address2,
                'city' => $request->city_name,
                'state' => $request->state_name,
                'pincode' => $request->pincode,
                'country' => $request->country_name,
                'kkt_or_not' => $request->kkt_or_not,
                'membership_id' => $request->membership_id,
            ];
            $updated = RdBooking::where('id','=',$request->book_edit_id)->update($entry_arr);
            return response()->json($updated == true ? ["status" => 200, "message" => "Successfully updated"] : ["status" => 400, "message" => "Failed to update the booking"]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function DeleteData(Request $request)
    {
        $data = RdBooking::where('id',$request->id)
            ->delete();
        return response()->json($data ? ['status' => 200, 'message' => 'Successfully deleted'] : ['status' => 400, 'message' => 'Failed to delete..!']);
    }

}
