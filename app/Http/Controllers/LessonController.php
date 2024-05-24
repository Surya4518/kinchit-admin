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
use App\Models\Course_lesson;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $lessons = Course_lesson::where('post_type', 'LIKE', 'namaste_lesson')
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return view('namaste-lms.lessons.index', compact('lessons', 'alldatas'));
    }

    public function ShowLessons(Request $request)
    {
        $lessons = Course_lesson::from('wpu6_posts as a')
            ->select('a.*', 'b.post_title as course_title')
            ->leftJoin('wpu6_posts as b', 'a.course_id', '=', 'b.ID')
            ->where('a.post_type', 'namaste_lesson')
            ->whereNull('a.deleted_at')
            ->orderBy('a.ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $lessons]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $courses = Course_lesson::where('post_type', 'LIKE', 'namaste_course')
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return view('namaste-lms.lessons.create', compact('courses', 'alldatas'));
    }

    public function CreateThelesson(Request $request)
    {
        $rules = [
            'lesson_title' => 'required',
            'lesson_post_status' => 'required',
            'lesson_publish_date' => 'required|date',
            'lesson_course_id' => 'required',
            'lesson_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute must be a valid date.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $startDate = date('Y-m-d H:i:s', strtotime($request->lesson_publish_date));
        $nowDate = date('Y-m-d H:i:s');
        if ($nowDate > $startDate) {
            $post_status = $request->lesson_post_status;
        } else {
            $post_status = 'future';
        }
        $convertedSlug = Str::of($request->lesson_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s", strtotime($request->lesson_publish_date)),
            'post_content' => $request->lesson_content,
            'post_title' => $request->lesson_title,
            'post_excerpt' => '',
            'post_status' => $post_status,
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->lesson_publish_date)),
            'post_type' => 'namaste_lesson',
            'course_id' => $request->lesson_course_id,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Course_lesson::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Lesson Created'] : ['status' => 400, 'message' => 'Failed to create lesson']);
    }

    public function DeleteTheLesson(Request $request)
    {
        $lesson_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($lesson_delete == true ? ['status' => 200, 'message' => 'Lesson deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $lessons = Course_lesson::where('id', $request->id)
            ->get();
        $courses = Course_lesson::where('post_type', 'LIKE', 'namaste_course')
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return view('namaste-lms.lessons.edit', compact('courses', 'lessons', 'alldatas'));
    }



    public function UpdateThelesson(Request $request)
    {
        $rules = [
            'lesson_title' => 'required',
            'lesson_post_status' => 'required',
            'lesson_publish_date' => 'required|date',
            'lesson_course_id' => 'required',
            'lesson_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute must be a valid date.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $startDate = date('Y-m-d H:i:s', strtotime($request->lesson_publish_date));
        $nowDate = date('Y-m-d H:i:s');
        if ($nowDate > $startDate) {
            $post_status = $request->lesson_post_status;
        } else {
            $post_status = 'future';
        }
        $convertedSlug = Str::of($request->lesson_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date_gmt' => date("Y-m-d H:i:s", strtotime($request->lesson_publish_date)),
            'post_content' => $request->lesson_content,
            'post_title' => $request->lesson_title,
            'post_status' => $request->lesson_post_status,
            'post_name' => $convertedSlug,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->lesson_publish_date)),
            'course_id' => $request->lesson_course_id,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('id', $request->lesson_edit_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Lesson Updated'] : ['status' => 400, 'message' => 'Failed to update lesson']);
    }
}
