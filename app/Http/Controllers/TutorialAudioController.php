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
}
;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class TutorialAudioController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('tutorials.audio.index', compact('alldatas'));
    }

    public function ShowTutotialAudios(Request $request)
    {
        $audios = Course_lesson::select('wpu6_posts.*', 'tutorial_categories.category_name')
            ->leftJoin('tutorial_categories', 'wpu6_posts.audio_category_id', '=', 'tutorial_categories.id')
            ->where('wpu6_posts.post_type', 'LIKE', 'tutorial-audio')
            ->whereNull('wpu6_posts.deleted_at')
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
        $tutorial_categories = Tutorial_categories::where('category_type', '=', 'audio')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('tutorials.audio.create', compact('tutorial_categories', 'alldatas'));
    }

    public function GetTutorialAudioTrack(Request $request)
    {
        $audio = Course_lesson::where('post_type', 'LIKE', 'tutorial-audio')
            ->where('ID', '=', $request->id)
            ->get();
        return response()->json(['status' => 200, 'data' => $audio]);
    }

    public function CreateTheTutorialAudio(Request $request)
    {
        $rules = [
            'tutorial_audio_title' => 'required',
            'tutorial_audio_category' => 'required',
            'tutorial_audio_file' => 'required|mimes:mp3,wav,ogg|max:10240',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        if ($request->file('tutorial_audio_file')) {
            $image = $request->file('tutorial_audio_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $convertedSlug = Str::of($request->tutorial_audio_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s"),
            'post_content' => '"' . $request->tutorial_audio_title . '"',
            'post_title' => $request->tutorial_audio_title,
            'post_excerpt' => '',
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s"),
            'post_parent' => '316',
            'guid' => $file_path,
            'post_type' => 'tutorial-audio',
            'audio_parent' => '316',
            'audio_category_id' => $request->tutorial_audio_category,
            'post_mime_type' => 'audio/mpeg',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Course_lesson::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Tutorial audio created'] : ['status' => 400, 'message' => 'Failed to create audio']);
    }

    public function DeleteTheTutorialAudio(Request $request)
    {
        $audio_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($audio_delete == true ? ['status' => 200, 'message' => 'Audio deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $audio = Course_lesson::where('id', $request->id)
            ->orderBy('ID', 'DESC')
            ->get();
        $tutorial_categories = Tutorial_categories::where('category_type', '=', 'audio')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('tutorials.audio.edit', compact('tutorial_categories', 'audio', 'alldatas'));
    }

    public function UpdateTheTutorialAudio(Request $request)
    {
        $rules = [
            'tutorial_audio_title' => 'required',
            'tutorial_audio_category' => 'required',
            'tutorial_audio_file' => 'mimes:mp3,wav,ogg|max:10240',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $audio = Course_lesson::where('post_type', 'LIKE', 'tutorial-audio')
            ->where('ID', '=', $request->tutorial_audio_edit_id)
            ->get();
        if ($request->file('tutorial_audio_file')) {
            $image = $request->file('tutorial_audio_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $audio[0]->guid;
        }
        $convertedSlug = Str::of($request->tutorial_audio_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_content' => '"' . $request->tutorial_audio_title . '"',
            'post_title' => $request->tutorial_audio_title,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s"),
            'guid' => $file_path,
            'audio_category_id' => $request->tutorial_audio_category,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('id',$request->tutorial_audio_edit_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Tutorial audio updated'] : ['status' => 400, 'message' => 'Failed to update audio']);
    }

    public function UpdateTheSortOrderOfTutorialCategory(Request $request)
    {
        $arr = [
            'sort_order' => $request->sort_order,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('id',$request->id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Audio sort order updated'] : ['status' => 400, 'message' => 'Failed to update sort order']);
    }

}
