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
    Course_lesson
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class KinchitEnpaniAudioController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('en-pani.audio.index', compact('alldatas'));
    }

    public function ShowEnpaniAudios(Request $request)
    {
        $audios = Course_lesson::where('post_type', 'LIKE', 'kinchit-en-pani-audio')
            ->whereNull('deleted_at')
            ->get();
        $audio_array = [];
        for ($i = 0; $i < $audios->count(); $i++) {
            $json_decode = json_decode($audios[$i]->audio_parent);
            $category = Course_lesson::where('post_type', 'LIKE', 'kinchit-en-pani')
                ->whereIN('ID', $json_decode)
                ->whereNull('deleted_at')
                ->get();
            $cat_array = [];
            for ($j = 0; $j < $category->count(); $j++) {
                $cat_array[] = $category[$j]->post_title;
            }
            $categories = implode(", ", $cat_array);
            $audio_array[] = [
                'audio_name' => $audios[$i]->post_title,
                'audio_category' => $categories,
                'id' => $audios[$i]->ID,
                'audio_url' => $audios[$i]->guid
            ];
        }
        return response()->json(['status' => 200, 'data' => $audio_array]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $enpani_categories = Course_lesson::where('post_type', 'LIKE', 'kinchit-en-pani')
            ->whereNull('deleted_at')
            ->get();
        return view('en-pani.audio.create', compact('enpani_categories', 'alldatas'));
    }

    public function CreateTheEnpaniAudio(Request $request)
    {
        $rules = [
            'enpani_audio_title' => 'required',
            'enpani_audio_category' => 'required',
            'enpani_audio_file' => 'required|mimes:mp3,wav,ogg|max:10240',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        if ($request->file('enpani_audio_file')) {
            $image = $request->file('enpani_audio_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = null;
        }
        $convertedSlug = Str::of($request->enpani_audio_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s"),
            'post_content' => '"' . $request->enpani_audio_title . '"',
            'post_title' => $request->enpani_audio_title,
            'post_excerpt' => '',
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s"),
            'post_parent' => '316',
            'guid' => $file_path,
            'post_type' => 'kinchit-en-pani-audio',
            'audio_parent' => json_encode($request->enpani_audio_category),
            'post_mime_type' => 'audio/mpeg',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Course_lesson::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Enpani audio created'] : ['status' => 400, 'message' => 'Failed to create audio']);
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
        $enpani_categories = Course_lesson::where('post_type', 'LIKE', 'kinchit-en-pani')
            ->whereNull('deleted_at')
            ->get();
        return view('en-pani.audio.edit', compact('enpani_categories', 'audio', 'alldatas'));
    }

    public function UpdateTheEnpaniAudio(Request $request)
    {
        $rules = [
            'enpani_audio_title' => 'required',
            'enpani_audio_category' => 'required',
            'enpani_audio_file' => 'mimes:mp3,wav,ogg|max:10240',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be a file of type: :values.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $audio = Course_lesson::where('post_type', 'LIKE', 'kinchit-en-pani-audio')
            ->where('ID', '=', $request->enpani_audio_edit_id)
            ->get();
        if ($request->file('enpani_audio_file')) {
            $image = $request->file('enpani_audio_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $audio[0]->guid;
        }
        $convertedSlug = Str::of($request->enpani_audio_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_title' => $request->enpani_audio_title,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'guid' => $file_path,
            'audio_parent' => json_encode($request->enpani_audio_category),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('id', $request->enpani_audio_edit_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Enpani audio updated'] : ['status' => 400, 'message' => 'Failed to update audio']);
    }

    public function DeleteTheEnpaniAudio(Request $request)
    {
        $audio_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($audio_delete == true ? ['status' => 200, 'message' => 'Audio deleted'] : ['status' => 400, 'message' => 'Failed']);
    }
}
