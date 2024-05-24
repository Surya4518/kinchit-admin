<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use DB;
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
    User,
    Course_lesson
};
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class StudentsController extends Controller
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
            ->orderBy('ID', 'ASC')
            ->get();
        return view('namaste-lms.students.index', compact('alldatas', 'courses'));
    }

    public function GetTheStudentsForCourse(Request $request)
    {
        // $course_student = DB::table('wpu6_namaste_student_courses')->select('user_id')->where('course_id', '=', $request->id)->whereNull('deleted_at')->get();
        // $modifiedArray = collect($course_student)->pluck('user_id')->all();
        // $modifiedArrayWithKeys = collect($course_student)->pluck('user_id')->values()->all();
        // dd(implode(", ",$modifiedArray));
        $students = DB::table('wpu6_users')
            ->select('wpu6_users.ID', 'wpu6_users.user_login', 'wpu6_users.user_email', 'wpu6_users.display_name', 'wpu6_namaste_student_courses.status as course_status')
            ->leftJoin('wpu6_namaste_student_courses', function ($join) {
                $join->on('wpu6_namaste_student_courses.user_id', '=', 'wpu6_users.ID')
                    ->whereNull('wpu6_namaste_student_courses.deleted_at');
            })
            ->whereNull('wpu6_users.deleted_at')
            ->where('wpu6_namaste_student_courses.course_id', '=', $request->id)
            ->get();
        return response()->json(['status' => 200, 'data' => $students]);
    }

    public function GetStudentsWithFilter(Request $request)
    {
        $array = $request->all();
        if (array_key_exists('search', $array)) {
            $search = $array['search'];

            if ($search == null) {
                $data = User::whereNull('deleted_at')->whereNotNull('verified_at')->orderby('display_name', 'asc')->get();
            } else {
                $data = User::orderby('display_name', 'asc')->whereNotNull('verified_at')->select('*')->where('display_name', 'like', '%' . $search . '%')->whereNull('deleted_at')->limit(6)->get();
            }
            return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
        } else {
            $data = User::select('*')->whereNull('deleted_at')->whereNotNull('verified_at')->get();
            return response()->json($data->count() > 0 ? ['status' => 200, 'data' => $data] : ['status' => 400, 'data' => []]);
        }
    }

    public function AssignCourseForStudent(Request $request)
    {
        $rules = [
            'course_id' => 'required',
            'student_id' => 'required'
        ];
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
        }
        $student_array = $request->student_id;
        // dd($student_array);
        $ins_array = [];
        for ($i = 0; $i < count($student_array); $i++) {
            $ins_array[] = [
                'course_id' => $request->course_id,
                'user_id' => $student_array[$i],
                'status' => 'pending',
                'created_at' => date("Y-m-d H:i:s")
            ];
        }
        // dd($ins_array);
        $insert = DB::table('wpu6_namaste_student_courses')->insert($ins_array);
        return response()->json($insert == true ? ['status' => 200, 'message' => 'Course assigned'] : ['status' => 400, 'message' => 'Failed to assign']);
    }

    public function RemoveCourseForStudent(Request $request)
    {
        $lesson_delete = DB::table('wpu6_namaste_student_courses')
            ->where('user_id', '=', $request->user_id)
            ->where('course_id', '=', $request->course_id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        return response()->json($lesson_delete == true ? ['status' => 200, 'message' => 'Course removed'] : ['status' => 400, 'message' => 'Failed']);
    }

    public function ChangeStatus(Request $request)
    {
        $update = DB::table('wpu6_namaste_student_courses')
            ->where('user_id', '=', $request->user_id)
            ->where('course_id', '=', $request->course_id)
            ->update(['status' => $request->status, 'updated_at' => date("Y-m-d H:i:s")]);
        return response()->json($update == true ? ['status' => 200, 'message' => 'Status has been successfully updated.'] : ['status' => 400, 'message' => 'Failed to change status.']);
    }

}
