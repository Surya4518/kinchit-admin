<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use DB;
use Input;
use Session;
use Storage;
use Mail;
use View;
use Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Common;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
		$alldatas['userinfo'] 			= Common::userinfo();
		$alldatas['toprightmenu'] 		= Common::toprightmenu();
		$alldatas['mainmenu'] 			= Common::mainmenu();
		$alldatas['footer'] 			= Common::footer();
		$alldatas['sidenavbar'] 		= Common::sidenavbar();
		$alldatas['rightsidenavbar'] 	= Common::rightsidenavbar();
        $department=Department::all();


        return view('department',compact('alldatas','department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {





        // return view('productAjax');



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $department_icon = $request->input('current_department_icon', '');
    $department_drop_icon = $request->input('current_department_drop_icon', '');
    
    if($request->hasFile('department_icon')) {
        $name = $request->file('department_icon')->getClientOriginalName();
        $request->file('department_icon')->move(public_path().'/department_icons/', $name);
        $department_icon = $name;
    }

    if($request->hasFile('department_drop_icon')) {
        $name = $request->file('department_drop_icon')->getClientOriginalName();
        $request->file('department_drop_icon')->move(public_path().'/department_icons/', $name);
        $department_drop_icon = $name;
    }

    // Validate input fields
    $request->validate([
        'department_name' => 'required',
        'status' => 'required|in:0,1',
    ]);

    $id = $request->input('product_id');
    $department_name = $request->input('department_name');
    $status = $request->input('status');

    // Check if the 'id' field exists in the request object
    if ($id) {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['error'=>'Department not found.']);
        }

        // Update only the fields that have been changed
        $department->department_name = $department_name;
        $department->status = $status;
        
        if (!empty($department_icon)) {
            $department->department_icon = $department_icon;
        }
        
        if (!empty($department_drop_icon)) {
            $department->department_drop_icon = $department_drop_icon;
        }

        $department->save();
    } else {
        Department::create([
            'department_name' => $department_name,
            'department_icon' => $department_icon,
            'department_drop_icon' => $department_drop_icon,
            'status' => $status,
        ]);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Department saved successfully'
    ]);
        // return response()->json(['message'=>'Department saved successfully.','status'=>'200']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department=Department::find($id);
        response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'department_name' => 'required',
        'department_icon' => 'nullable|image',
        'department_drop_icon' => 'nullable|image',
         'status' => 'required|in:0,1',
    ]);

    $department = Department::find($id);
    $department->department_name = $request->input('department_name');
    $department->status = $request->input('status');

    if ($request->hasFile('department_icon')) {
        $department_icon = $request->file('department_icon');
        $department_icon_name = time() . '.' . $department_icon->getClientOriginalExtension();
        $department_icon->move(public_path().'/medias/department_icons/', $department_icon_name);
        $department->department_icon = $department_icon_name;
    }

    if ($request->hasFile('department_drop_icon')) {
        $department_drop_icon = $request->file('department_drop_icon');
        $department_drop_icon_name = time() . '_drop.' . $department_drop_icon->getClientOriginalExtension();
        $department_drop_icon->move(public_path().'/medias/department_icons/', $department_drop_icon_name);
        $department->department_drop_icon = $department_drop_icon_name;
    }

    $department->save();

    return response()->json([
        'status' => 200,
         'message' => 'Department updated successfully'
         
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);
        $department->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Department deleted successfully'
        ]);
    }


    public function edit1($id)
    {
        $department=Department::where('id', '=', $id)->get();
        return response()->json($department);
    }

}
