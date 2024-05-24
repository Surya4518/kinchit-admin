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

class DharmaSandhehaRepliesController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $threads = DharmaSandheha::where('post_type', '=', 'thread')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('dharma-sandheha.replies.index', compact('alldatas', 'threads'));
    }

    public function ShowReplies(Request $request)
    {
        $replies = DharmaSandheha::where('post_type', 'LIKE', 'reply')
            ->when($request->id != '', function ($query) use ($request) {
                return $query->where('post_parent', '=', $request->id);
            })
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $replies]);
    }

    public function GetThreadsListForFilter(Request $request)
    {
        $array = $request->all();
        if (array_key_exists('search', $array)) {
            $search = $array['search'];

            if ($search == null) {
                $data = DharmaSandheha::where('post_type', '=', 'thread')->whereNull('deleted_at')->get();
            } else {
                $data = DharmaSandheha::where('post_type', '=', 'thread')->select('*')->where('post_title', 'like', '%' . $search . '%')->whereNull('deleted_at')->limit(6)->get();
            }
            return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
        } else {
            $data = DharmaSandheha::where('post_type', '=', 'thread')->whereNull('deleted_at')->get();
            return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
        }
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $threads = DharmaSandheha::where('post_type', '=', 'thread')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('dharma-sandheha.replies.create', compact('alldatas', 'threads'));
    }

    public function CreateTheReplies(Request $request)
    {
        $rules = [
            'reply_parent_thread_id' => 'required',
            'reply_title' => 'required',
            'reply_post_status' => 'required',
            'reply_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->reply_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s", strtotime($request->reply_publish_date)),
            'post_content' => $request->reply_content,
            'post_title' => $request->reply_title,
            'post_excerpt' => '',
            'post_status' => $request->reply_post_status,
            'comment_status' => 'open',
            'ping_status' => 'open',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->reply_publish_date)),
            'post_parent' => $request->reply_parent_thread_id,
            'post_type' => 'reply',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = DharmaSandheha::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Reply Created'] : ['status' => 400, 'message' => 'Failed to create reply']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $threads = DharmaSandheha::where('post_type', '=', 'thread')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        $replies = DharmaSandheha::where('id', $request->id)
            ->orderBy('ID', 'DESC')
            ->get();
        return view('dharma-sandheha.replies.edit', compact('replies', 'threads', 'alldatas'));
    }

    public function UpdateTheReply(Request $request)
    {
        $rules = [
            'reply_parent_thread_id' => 'required',
            'reply_title' => 'required',
            'reply_post_status' => 'required',
            'reply_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $convertedSlug = Str::of($request->reply_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_content' => $request->reply_content,
            'post_title' => $request->reply_title,
            'post_status' => $request->reply_post_status,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->reply_publish_date)),
            'post_parent' => $request->reply_parent_thread_id,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = DharmaSandheha::where('id', $request->edit_reply_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Reply Updated'] : ['status' => 400, 'message' => 'Failed to update reply']);
    }

    public function DeleteTheReply(Request $request)
    {
        $reply_delete = DharmaSandheha::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($reply_delete == true ? ['status' => 200, 'message' => 'Reply deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ChangeThePostStatusOfReply(Request $request)
    {
        $status = $request->status == '0' ? 'publish' : 'pending';

        $reply_status = DharmaSandheha::where('ID', '=', $request->id)
            ->update(['post_status' => $status]);

        return response()->json(
            $reply_status == true
                ? ["status" => 200, "message" => "Successfully status changed to $status"]
                : ["status" => 400, "message" => "Failed"]
        );
    }
}
