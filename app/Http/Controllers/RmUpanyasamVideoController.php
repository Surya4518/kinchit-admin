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
use App\Models\{
    Rm_online_upanyasam,
    Tutorial_categories
}
;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class RmUpanyasamVideoController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('rm-online-upanyasam.video.index', compact('alldatas'));
    }

    public function ShowRMOnlineVideo(Request $request)
    {
        $audios = Rm_online_upanyasam::select('rm_online_upanyasam.*', 'tutorial_categories.category_name')
            ->leftJoin('tutorial_categories', 'rm_online_upanyasam.category_id', '=', 'tutorial_categories.id')
            ->where('rm_online_upanyasam.post_type', 'LIKE', 'content')
            ->where('rm_online_upanyasam.structure_type', 'LIKE', 'video')
            ->where('rm_online_upanyasam.parent_id', 'LIKE', '0')
            ->whereNull('rm_online_upanyasam.deleted_at')
            ->orderBy('rm_online_upanyasam.id', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $audios]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $rmonline_categories = Tutorial_categories::where('category_type', 'like', 'rm-online-upanyasam-video')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('rm-online-upanyasam.video.create', compact('rmonline_categories', 'alldatas'));
    }

    public function CreateTheRMOnlineUpanyasamVideo(Request $request)
    {
        $rules = [
            'rmonline_video_title' => 'required',
            'rmonline_video_category' => 'required',
            'rmonline_video_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->rmonline_video_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'category_id' => $request->rmonline_video_category,
            'post_content' => $request->rmonline_video_content,
            'post_title' => $request->rmonline_video_title,
            'post_slug' => $convertedSlug,
            'parent_id' => '0',
            'post_type' => 'content',
            'structure_type' => 'video',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Rm_online_upanyasam::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'RM Online Upanyasam video created'] : ['status' => 400, 'message' => 'Failed to create video']);
    }

    public function DeleteTheRMOnlineVideo(Request $request)
    {
        $rmvideo_delete = Rm_online_upanyasam::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($rmvideo_delete == true ? ['status' => 200, 'message' => 'Video deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $video = Rm_online_upanyasam::where('id', $request->id)
            ->orderBy('ID', 'DESC')
            ->get();
        $rmonline_categories = Tutorial_categories::where('category_type', 'like', 'rm-online-upanyasam-video')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('rm-online-upanyasam.video.edit', compact('rmonline_categories', 'video', 'alldatas'));
    }

    public function UpdateTheRMOnlineVideo(Request $request)
    {
        $rules = [
            'rmonline_video_title' => 'required',
            'rmonline_video_category' => 'required',
            'rmonline_video_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->rmonline_video_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'category_id' => $request->rmonline_video_category,
            'post_content' => $request->rmonline_video_content,
            'post_title' => $request->rmonline_video_title,
            'post_slug' => $convertedSlug,
            'parent_id' => '0',
            'post_type' => 'content',
            'structure_type' => 'video',
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Rm_online_upanyasam::where('id',$request->rmonline_video_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'RM Online Upanyasam video updated'] : ['status' => 400, 'message' => 'Failed to update video']);
    }

}
