<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
// use App\Models\EmployeeImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::get();
        $designations = Designation::with('department')->get();
        $departments = Department::with('designations')->get();
          
        return view('employees.index',compact('employees','designations','departments'));
    }
    
    public function create(){
        $departments = Department::all();
        $designations = Designation::all();
        return view('employees.create',compact('departments','designations'));
    }

    public function store(Request $request){
      
        //validate data
         $request->validate([
           'name' => 'required',
           'gender' => 'required',
           'dob' => 'required|date',
           'address' => 'required',
           'email' => 'required|email',
           'phone' => 'required|numeric|digits:10',
           'doj' => 'required|date|after_or_equal:dob|before_or_equal:today',
           //'image' => 'required|mimes:jpeg,png,jpg,gif|max:10000',
           //'images' => 'required|array',
        //    'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        //upload image
        // $imageName = time().'.'.$request->image->extension();
        // $request->image->move(public_path('employees'),$imageName);
        
        $employee = new Employee;
        
        $employee->name = $request->name;
        $employee->gender = $request->gender;
        $employee->dob = $request->dob;
        $employee->address = $request->address;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->department_id = $request->department_id;
        $employee->designation_id = $request->designation_id;
        $employee->doj = $request->doj;
        //$employee->image = $request->$imageName;


        $employee->save();
        return back()->withSuccess('Employee added successfully');
    }
    
    public function edit($id){
       //dd($id);
        $employee = Employee::find($id);
        if($employee)
        {
            return response()->json([
                'status'=>200,
                'employee'=>$employee,
                'empid'=>$employee->id,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'employee not found',
            ]); 
        }
    }


    public function show($id)
    {
        
        $employee = Employee::findOrFail($id);
        // dd($employee);
        return response()->json($employee);
       
        $employee = Employee::with('images')->find($id);
        return view('employees.show', compact('employee'));
    }

    public function destroy($id){
        $employee = Employee::where('id',$id)->first();
        $employee->delete();
        return back()->withSuccess('Employee deleted successfully');

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
           'gender' => 'required',
           'dob' => 'required',
           'address' => 'required',
           'email' => 'required',
           'phone' => 'required|max:10',
           'doj' => 'required',
           //'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $employee = Employee::find($id);
            if($employee)
            {
            $employee->name = $request->input('name');
            $employee->gender = $request->input('gender');
            $employee->dob = $request->input('dob');
            $employee->address = $request->input('address');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->department_id = $request->input('department_id');
            $employee->designation_id = $request->input('designation_id');
            $employee->doj = $request->input('doj');

            
            
            // if($request->hasFile('image'))
            //   {
            // //  //   $path = 'public_path/employees/'.$employee->image;
            //      $path = 'public/employees/'.$employee->image;
            //      if(File::exists($path))
            //         {
            //            File::delete($path);
            //         }

            //    $file = $request->file('image');
            //    $extension = $file->getClientOriginalExtension();
            //    $fileName = time().'.'.$request->image->extension();
            //    $request->image->move(public_path('employees'),$fileName);
            //    $employee->image = $fileName;
            // }
            $employee->save();
            // return back()->withSuccess('Employee added successfully');


            return response()->json([
                'status'=>200,
                'message'=>'Employee data updated successfully'
            ]);
        }
        
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Employee not found'
            ]);
        }

    }
}
            

    public function getDesignations($id)
    {
    $departmentId = $id;
    $designations = Designation::where('department_id', $departmentId)->get();
    return response()->json($designations);
}

}