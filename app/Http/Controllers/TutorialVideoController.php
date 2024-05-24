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
    Course_lesson,
    Tutorial_categories
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class TutorialVideoController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('tutorials.video.index', compact('alldatas'));
    }

    public function ShowTutotialVideo(Request $request)
    {
        $audios = Course_lesson::select('wpu6_posts.*', 'tutorial_categories.category_name')
            ->leftJoin('tutorial_categories', 'wpu6_posts.audio_category_id', '=', 'tutorial_categories.id')
            ->where('wpu6_posts.post_type', 'LIKE', 'tutorial-video')
            ->whereNull('wpu6_posts.deleted_at')
            ->whereNull('tutorial_categories.deleted_at')
            ->orderBy('wpu6_posts.ID', 'DESC')
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
        $tutorial_categories = Tutorial_categories::where('category_type', '=', 'video')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('tutorials.video.create', compact('tutorial_categories', 'alldatas'));
    }

    public function CreateTheTutorialVideo(Request $request)
    {
        $rules = [
            'tutorial_video_title' => 'required',
            'tutorial_video_category' => 'required',
            'tutorial_video_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->tutorial_video_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s"),
            'post_content' => $request->tutorial_video_content,
            'post_title' => $request->tutorial_video_title,
            'post_excerpt' => '',
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s"),
            'post_parent' => '327',
            'post_type' => 'tutorial-video',
            'audio_parent' => '327',
            'audio_category_id' => $request->tutorial_video_category,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Course_lesson::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Tutorial video created'] : ['status' => 400, 'message' => 'Failed to create video']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $video = Course_lesson::where('id', $request->id)
            ->orderBy('ID', 'DESC')
            ->get();
        $tutorial_categories = Tutorial_categories::where('category_type', '=', 'video')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('tutorials.video.edit', compact('tutorial_categories', 'video', 'alldatas'));
    }

    public function UpdateTheTutorialVideo(Request $request)
    {
        $rules = [
            'tutorial_video_title' => 'required',
            'tutorial_video_category' => 'required',
            'tutorial_video_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->tutorial_video_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_content' => $request->tutorial_video_content,
            'post_title' => $request->tutorial_video_title,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s"),
            'audio_category_id' => $request->tutorial_video_category,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('id', $request->tutorial_video_edit_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Tutorial video updated'] : ['status' => 400, 'message' => 'Failed to update video']);
    }

    public function DeleteTheTutorialVideo(Request $request)
    {
        $video_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($video_delete == true ? ['status' => 200, 'message' => 'Video deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
