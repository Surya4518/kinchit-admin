<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Input;
use Session;
use Storage;
use Mail;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Common;
use App\Models\SuccessStory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ManageSuccessStoriesController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('lakshmi-kalyanam.success-stories.index', compact('alldatas'));
    }

    public function ShowSuccessStories(Request $request)
    {
        $success_story = SuccessStory::whereNull('deleted_at')
            ->get();
        return response()->json(['status' => 200, 'data' => $success_story]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('lakshmi-kalyanam.success-stories.create', compact('alldatas'));
    }

    public function CreateTheSuccessStory(Request $request)
    {
        $rules = [
            'bride_name' => 'required',
            'bride_id' => 'required',
            'groom_name' => 'required',
            'groom_id' => 'required',
            'email' => 'required|email|unique:successstory,email',  // Add email validation
            'mobile_no' => ['required', 'numeric', 'digits:10', 'regex:/^(\+91[\-\s]?)?[789]\d{9}$/'],
            'contact_address' => 'required',
            'success_comments' => 'required',
            'wedding_date' => 'required',
            'wedding_photo' => 'required|image:jpg,jpeg,png,webp|max:10240',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'numeric' => 'The :attribute must be a number.',
            'digits' => 'The :attribute must be exactly :digits digits.',
            'unique' => 'The :attribute has already been taken.',
            'date' => 'The :attribute must be a valid date.',
            'mimes' => 'The :attribute must be a file of type: :values.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        if ($request->file('wedding_photo')) {
            $image = $request->file('wedding_photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $insert = SuccessStory::create([
            'weddingphoto' => $file_path,
            'bridename' => $request->bride_name,
            'brideid' => $request->bride_id,
            'groomname' => $request->groom_name,
            'groomid' => $request->groom_id,
            'email' => $request->email,
            'mobile' => $request->mobile_no,
            'address' => $request->contact_address,
            'marriagedate' => $request->wedding_date,
            'successmessage' => $request->success_comments,
            'approve' => '1',
        ]);
        return response()->json($insert == true ? ['status' => 200, 'message' => 'Story has been added'] : ['status' => 400, 'message' => 'Failed to create story']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $success_story = SuccessStory::where('id', '=', $request->id)
            ->whereNull('deleted_at')
            ->get();
        return view('lakshmi-kalyanam.success-stories.edit', compact('success_story', 'alldatas'));
    }

    public function UpdateTheSuccessStory(Request $request)
    {
        $rules = [
            'bride_name' => 'required',
            'bride_id' => 'required',
            'groom_name' => 'required',
            'groom_id' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('successstory', 'email')->ignore($request->id),
            ],
            'mobile_no' => ['required', 'numeric', 'digits:10', 'regex:/^(\+91[\-\s]?)?[789]\d{9}$/'],
            'contact_address' => 'required',
            'success_comments' => 'required',
            'wedding_date' => 'required',
            'wedding_photo' => 'image:jpg,jpeg,png,webp|max:10240',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'numeric' => 'The :attribute must be a number.',
            'digits' => 'The :attribute must be exactly :digits digits.',
            'unique' => 'The :attribute has already been taken.',
            'date' => 'The :attribute must be a valid date.',
            'image' => 'The :attribute must be a file of type: :values.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }

        $success_story = SuccessStory::where('id', '=', $request->id)
            ->whereNull('deleted_at')
            ->get();
        if ($request->file('wedding_photo')) {
            $image = $request->file('wedding_photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $success_story[0]->weddingphoto;
        }
        $update = SuccessStory::find($request->id)->update([
            'weddingphoto' => $file_path,
            'bridename' => $request->bride_name,
            'brideid' => $request->bride_id,
            'groomname' => $request->groom_name,
            'groomid' => $request->groom_id,
            'email' => $request->email,
            'mobile' => $request->mobile_no,
            'address' => $request->contact_address,
            'marriagedate' => $request->wedding_date,
            'successmessage' => $request->success_comments,
        ]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Story has been updated'] : ['status' => 400, 'message' => 'Failed to update story']);
    }

    public function ChangeTheStatusOfSuccessStory(Request $request)
    {
        $msg = ($request->status == '1' ? 'approved' : ($request->status == '2' ? 'rejected' : 'holded'));
        $success_story = SuccessStory::find($request->id)->update([
            'approve' => $request->status
        ]);
        return response()->json($success_story == true ? ['status' => 200, 'message' => 'Story has been '.$msg] : ['status' => 400, 'message' => 'Failed']);
    }

    public function DeleteTheSuccessStory(Request $request)
    {
        $success_story = SuccessStory::find($request->id)->delete();
        return response()->json($success_story == true ? ['status' => 200, 'message' => 'Story deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function DeleteTheImage(Request $request)
    {
        $delete_image = SuccessStory::find($request->id)->update([
            'weddingphoto' => NULL
        ]);
        return response()->json($delete_image == true ? ['status' => 200, 'message' => 'Successfully deleted'] : ['status' => 400, 'message' => 'Failed to delete']);
    }
}
