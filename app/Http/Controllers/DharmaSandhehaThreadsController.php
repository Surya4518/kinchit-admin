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
use App\Models\DharmaSandheha;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class DharmaSandhehaThreadsController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $threads = DharmaSandheha::where('post_type', 'LIKE', 'thread')
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return view('dharma-sandheha.threads.index', compact('threads', 'alldatas'));
    }

    public function ShowThreads(Request $request)
    {
        $threads = DharmaSandheha::where('post_type', 'LIKE', 'thread')
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $threads]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('dharma-sandheha.threads.create', compact('alldatas'));
    }

    public function CreateTheThread(Request $request)
    {
        $rules = [
            'thread_title' => 'required',
            'thread_post_status' => 'required',
            'thread_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->thread_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s", strtotime($request->thread_publish_date)),
            'post_content' => $request->thread_content,
            'post_title' => $request->thread_title,
            'post_excerpt' => '',
            'post_status' => $request->thread_post_status,
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->thread_publish_date)),
            'post_type' => 'thread',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = DharmaSandheha::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Thread Created'] : ['status' => 400, 'message' => 'Failed to create thread']);
    }

    public function DeleteTheThread(Request $request)
    {
        $thread_delete = DharmaSandheha::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        $reply_delete = DharmaSandheha::where('post_parent', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($thread_delete == true && $reply_delete == true ? ['status' => 200, 'message' => 'Thread deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $thread = DharmaSandheha::where('id', $request->id)
            ->orderBy('ID', 'DESC')
            ->get();
        return view('dharma-sandheha.threads.edit', compact('thread', 'alldatas'));
    }

    public function UpdateTheThread(Request $request)
    {
        $rules = [
            'thread_title' => 'required',
            'thread_post_status' => 'required',
            'thread_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->thread_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_content' => $request->thread_content,
            'post_title' => $request->thread_title,
            'post_status' => $request->thread_post_status,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->thread_publish_date)),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DharmaSandheha::where('id', $request->edit_thread_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Thread updated'] : ['status' => 400, 'message' => 'Failed to update thread']);
    }

    public function ChangeThePostStatusOfThread(Request $request)
    {
        $status = $request->status == '0' ? 'publish' : 'pending';

        $thread_status = DharmaSandheha::where('ID', '=', $request->id)
            ->update(['post_status' => $status]);

        $reply_status = DharmaSandheha::where('post_parent', '=', $request->id)
            ->update(['post_status' => $status]);

        return response()->json(
            $thread_status == true
                ? ["status" => 200, "message" => "Successfully status changed to $status"]
                : ["status" => 400, "message" => "Failed"]
        );
    }
}
