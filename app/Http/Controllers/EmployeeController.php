<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    function index(){
        $data['employees'] = Employee::all();
        return view('admin.pages.employee.index',$data);
    }

    function create(){
        return view('admin.pages.employee.create');
    }

    function store(Request $request)
    {
    $request->validate([
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|email|unique:users,email',
        'phone_no'              => ['required', 'regex:/^(01)[3-9]\d{8}$/'],
        'designation'           => 'required|string|max:255',
        'department'            => 'required|string|max:255',
        'salary'                => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
    ]);

    DB::beginTransaction();

    try {

        $lastEmp = Employee::orderBy('id', 'desc')->first();
        if ($lastEmp && !empty($lastEmp->emp_no)) {
            $lastNumber = (int) filter_var($lastEmp->emp_no, FILTER_SANITIZE_NUMBER_INT);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 101; 
        }
        $emp_no = 'OV' . $nextNumber;

        while (Employee::where('emp_no', $emp_no)->exists()) {
            $nextNumber++;
            $emp_no = 'OV' . $nextNumber;
        }

        $employee = new Employee();
        $employee->emp_no       = $emp_no;
        $employee->name         = $request->name;
        $employee->phone_no     = $request->phone_no;
        $employee->email        = $request->email;
        $employee->designation  = $request->designation;
        $employee->department   = $request->department;
        $employee->join_date    = $request->join_date;
        $employee->salary       = $request->salary;
        $employee->address      = $request->address;
        $employee->created_by   = Auth::id();
        $employee->status       = $request->status ?? 1;
        $employee->save();

        $user = new User();
        $user->name       = $request->name;
        $user->phone_no   = $request->phone_no;
        $user->email      = $request->email;
        $user->password   = bcrypt($request->password);
        $user->emp_id     = $employee->id; 
        $user->role       = 2; 
        $user->status     = 1;
        $user->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Employee and user created successfully!',
            'data'    => [
                'employee' => $employee,
                'user'     => $user,
            ],
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to save data. ' . $e->getMessage(),
        ], 500);
    }
}

 function toggleStatus(Request $request)
{
    $employee = Employee::find($request->id);
    if (!$employee) {
        return response()->json(['success' => false, 'message' => 'Employee not found.']);
    }

    $employee->status = $request->status;
    $employee->save();

    $user = User::where('emp_id', $employee->id)->first();
    if ($user) {
        $user->status = $request->status;
        $user->save();
    }

    return response()->json([
        'success' => true,
        'message' => $employee->status == 1 
            ? 'Employee Enabled successfully!' 
            : 'Employee Disabled successfully!'
    ]);
}

function edit($id){
    $data['employee'] = Employee::findOrFail($id);
    return view('admin.pages.employee.edit',$data);
}

public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);
    $user = User::where('emp_id', $id)->first();

    $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:users,email,' . $user->id,
        'phone_no'    => ['required', 'regex:/^(01)[3-9]\d{8}$/'],
        'designation' => 'required|string|max:255',
        'department'  => 'required|string|max:255',
        'salary'      => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'join_date'   => 'required|date',
        'password'    => 'nullable|string|min:6|confirmed', 
    ]);

    DB::beginTransaction();

    try {
        // 🧩 Update employee info
        $employee->name        = $request->name;
        $employee->phone_no    = $request->phone_no;
        $employee->email       = $request->email;
        $employee->designation = $request->designation;
        $employee->department  = $request->department;
        $employee->join_date   = $request->join_date;
        $employee->salary      = $request->salary;
        $employee->address     = $request->address;
        $employee->updated_by  = Auth::id();
        $employee->save();

        // 🧩 Update existing user info
        if ($user) {
            $user->name     = $request->name;
            $user->phone_no = $request->phone_no;
            $user->email    = $request->email;

            // যদি password দেওয়া হয়, তখনই update হবে
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }

            $user->save();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Employee and user updated successfully!',
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to update data. ' . $e->getMessage(),
        ], 500);
    }
}




}
