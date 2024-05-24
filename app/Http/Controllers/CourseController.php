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

class CourseController extends Controller
{
    public function index(Request $request)
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
        return view('namaste-lms.course.index', compact('courses', 'alldatas'));
    }

    public function ShowCourses(Request $request)
    {
        $courses = Course_lesson::where('post_type', 'LIKE', 'namaste_course')
            ->whereNull('deleted_at')
            ->orderBy('ID', 'DESC')
            ->get();
        return response()->json(['status' => 200, 'data' => $courses]);
    }

    public function CreatePage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        return view('namaste-lms.course.create', compact('alldatas'));
    }

    public function CreateTheCourse(Request $request)
    {
        $rules = [
            'course_title' => 'required',
            'course_post_status' => 'required',
            'upanyasam_name' => 'required',
            'tutor_name' => 'required',
            'course_publish_date' => 'required|date',
            'course_content' => 'required',
            'course_image' => 'required|image|mimes:jpg,png,jpeg,webp|max:10240',
            'course_local_form' => 'required|file|mimes:pdf|max:10240',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute must be a valid date.',
            'image' => 'The :attribute must be an image file.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $startDate = date('Y-m-d H:i:s', strtotime($request->course_publish_date));
        $nowDate = date('Y-m-d H:i:s');
        if ($nowDate > $startDate) {
            $post_status = $request->course_post_status;
        } else {
            $post_status = 'future';
        }
        if ($request->file('course_image')) {
            $image = $request->file('course_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = NULL;
        }
        if ($request->file('course_local_form')) {
            $image = $request->file('course_local_form');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path1 = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path1 = NULL;
        }
        $convertedSlug = Str::of($request->course_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s", strtotime($request->course_publish_date)),
            'post_content' => $request->course_content,
            'post_title' => $request->course_title,
            'post_excerpt' => '',
            'post_status' => $request->course_post_status,
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => $convertedSlug,
            'guid' => $file_path,
            'down_frm_pdf' => $file_path1,
            'tutor_name' => $request->tutor_name,
            'upanyasam_name' => $request->upanyasam_name,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->course_publish_date)),
            'post_type' => 'namaste_course',
            'course_status' => 'pending',
            'created_at' => date("Y-m-d H:i:s")
        ];
        $ins = Course_lesson::insert($arr);
        return response()->json($ins == true ? ['status' => 200, 'message' => 'Course Created'] : ['status' => 400, 'message' => 'Failed to create course']);
    }

    public function DeleteTheCourse(Request $request)
    {
        $course_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($course_delete == true ? ['status' => 200, 'message' => 'Course deleted'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function UpdateTheStatusOfCourse(Request $request)
    {
        $course_delete = Course_lesson::where('ID', '=', $request->id)
            ->update(['course_status' => $request->status]);
        // $courses = Course_lesson::where('post_type', 'LIKE', 'namaste_course')
        //     ->where('ID', '=', $request->id)
        //     ->whereNull('deleted_at')
        //     ->orderBy('ID', 'DESC')
        //     ->get();
        return response()->json($course_delete == true ? ['status' => 200, 'message' => 'Successfully status has been changed..!', 'updatedRowData' => []] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ShowEditPage(Request $request)
    {
        $alldatas['userinfo'] = Common::userinfo();
        $alldatas['toprightmenu'] = Common::toprightmenu();
        $alldatas['mainmenu'] = Common::mainmenu();
        $alldatas['footer'] = Common::footer();
        $alldatas['sidenavbar'] = Common::sidenavbar();
        $alldatas['rightsidenavbar'] = Common::rightsidenavbar();
        $courses = Course_lesson::where('id', $request->id)
            ->orderBy('ID', 'DESC')
            ->get();
        return view('namaste-lms.course.edit', compact('courses', 'alldatas'));
    }

    public function UpdateTheCourse(Request $request)
    {
        $rules = [
            'course_title' => 'required',
            'course_post_status' => 'required',
            'upanyasam_name' => 'required',
            'tutor_name' => 'required',
            'course_publish_date' => 'required|date',
            'course_content' => 'required',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute must be a valid date.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $startDate = date('Y-m-d H:i:s', strtotime($request->course_publish_date));
        $nowDate = date('Y-m-d H:i:s');
        if ($nowDate > $startDate) {
            $post_status = $request->course_post_status;
        } else {
            $post_status = 'future';
        }
        $course = Course_lesson::where('post_type', 'LIKE', 'namaste_course')
            ->where('ID', '=', $request->course_edit_id)
            ->get();
        if ($request->file('course_image')) {
            $image = $request->file('course_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path = $course[0]->guid;
        }
        if ($request->file('course_local_form')) {
            $image = $request->file('course_local_form');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/' . date("Y") . '/' . date("m"));
            $image->move($destinationPath, $filename);
            $file_path1 = 'uploads/' . date("Y") . '/' . date("m") . '/' . $filename;
        } else {
            $file_path1 = $course[0]->down_frm_pdf;
        }
        $convertedSlug = Str::of($request->course_title)->lower()->replace(' ', '-')->slug('-');
        $arr = [
            'post_author' => Session::get('admin_user_id'),
            'post_date' => date("Y-m-d H:i:s"),
            'post_date_gmt' => date("Y-m-d H:i:s", strtotime($request->course_publish_date)),
            'post_content' => $request->course_content,
            'post_title' => $request->course_title,
            'post_status' => $request->course_post_status,
            'post_name' => $convertedSlug,
            'guid' => $file_path,
            'down_frm_pdf' => $file_path1,
            'tutor_name' => $request->tutor_name,
            'upanyasam_name' => $request->upanyasam_name,
            'post_modified' => date("Y-m-d H:i:s"),
            'post_modified_gmt' => date("Y-m-d H:i:s", strtotime($request->course_publish_date)),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $update = Course_lesson::where('ID', $request->course_edit_id)->update($arr);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Course Updated'] : ['status' => 400, 'message' => 'Failed to update course']);
    }

    public function DeleteTheCourseImage(Request $request)
    {
        $delete_user_image = Course_lesson::where('id', $request->id)->update(['guid' => NULL, 'updated_at' => date("Y-m-d H:i:s")]);
        return response()->json($delete_user_image == true ? ['status' => 200, 'message' => 'Successfully deleted'] : ['status' => 400, 'message' => 'Failed to delete']);
    }

    public function DeleteTheCoursePDF(Request $request)
    {
        $delete_user_image = Course_lesson::where('id', $request->id)->update(['down_frm_pdf' => NULL, 'updated_at' => date("Y-m-d H:i:s")]);
        return response()->json($delete_user_image == true ? ['status' => 200, 'message' => 'Successfully deleted'] : ['status' => 400, 'message' => 'Failed to delete']);
    }
}
