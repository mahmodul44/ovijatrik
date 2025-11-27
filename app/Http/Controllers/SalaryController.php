<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\SalaryDetail;
use App\Models\MoneyReceipt;
use App\Models\Account;
use DB;
class SalaryController extends Controller
{

    public function index(){
        $data['salary'] = Salary::where('status',1)->orderby('salary_id','desc')->get();
        return view('admin.pages.salary.index', $data);
    }

    public function create(){
        $data['employees'] = Employee::where('status',1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        return view('admin.pages.salary.create', $data);
    }

    public function store(Request $request)
    {
    $validate = Validator::make($request->all(), [
        'salary_year'  => 'required',
        'salary_month' => 'required',
        'salary_date'  => 'required|date_format:d/m/Y',
        'employees'    => 'required|array',
        'employees.*.salary' => 'required|numeric|min:0',
    ]);

    if ($validate->fails()) {
        $data['status'] = false;
        $data['message'] = "Validation failed! Please check your inputs...";
        $data['errors'] = $validate->errors();
        return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
    }

    $salaryDate = Carbon::createFromFormat('d/m/Y', $request->salary_date)->format('Y-m-d');
     $fiscalYear = getFiscalYearFromDate($salaryDate);
     $existingSalary = Salary::where('salary_year', $request->salary_year)
        ->where('salary_month', $request->salary_month)
        ->first();

    if ($existingSalary) {
        return response()->json([
            'status' => false,
            'message' => 'Salary for the selected year and month is already generated.',
        ], 400);
    }
    DB::beginTransaction();
    try {
       
        $salaryNo = "SALARY" . '-' . rand(1000, 9999);

        $salary = new Salary();
        $salary->salary_no    = $salaryNo;
        $salary->salary_year  = $request->salary_year;
        $salary->salary_month = $request->salary_month;
        $salary->salary_date  = $salaryDate;
        $salary->account_id   = $request->account_id;
        $salary->posting_type = $request->posting_type;
        $salary->status       = '1';
        $salary->created_by   = Auth::id();
        $salary->operation_ip = $request->ip();
        $salary->save();

        $salaryId = $salary->salary_id;
        $employeeData = $request->employees;
        $grandTotal = 0;

        foreach ($employeeData as $employeeId => $employeeData) {
              $existingCustomerSalary = SalaryDetail::where('employee_id', $employeeId)
                ->whereHas('salary', function ($query) use ($request) {
                    $query->where('salary_year', $request->salary_year)
                        ->where('salary_month', $request->salary_month);
                })
                ->exists();

            if ($existingCustomerSalary) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "Salary for Employee ID $employeeId has already been generated for this month and year.",
                ], 400);
            }

            $salaryDetail = new SalaryDetail();
            $salaryDetail->salary_id = $salaryId;
            $salaryDetail->employee_id = $employeeId;
            $salaryDetail->salary_amount = $employeeData['salary'];
            $grandTotal += $employeeData['salary'];
            $salaryDetail->save();
        }

        $salary->total_salary = $grandTotal;
        $salary->save();

        DB::commit();

        return response()->json(['message' => 'Salary added successfully!']);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Salary Store Error: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to save salary data.', 'error' => $e->getMessage()], 500);
    }
   }

   function edit($id){
        $data['employees'] = Employee::where('status',1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
         $data['salaries'] = Salary::findOrFail($id);
        return view('admin.pages.salary.edit', $data);
   }


   public function update(Request $request, $id)
{
    $validate = Validator::make($request->all(), [
        'salary_year'  => 'required',
        'salary_month' => 'required',
        'salary_date'  => 'required|date_format:d/m/Y',
        'employees'    => 'required|array',
        'employees.*.salary' => 'required|numeric|min:0',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'status' => false,
            'message' => "Validation failed! Please check your inputs.",
            'errors' => $validate->errors()
        ], 400);
    }

    $salaryDate = Carbon::createFromFormat('d/m/Y', $request->salary_date)->format('Y-m-d');

    DB::beginTransaction();
    try {
        $salary = Salary::findOrFail($id);
        $salary->salary_year  = $request->salary_year;
        $salary->salary_month = $request->salary_month;
        $salary->salary_date  = $salaryDate;
        $salary->account_id   = $request->account_id;
        $salary->posting_type = $request->posting_type;
        $salary->save();

        $grandTotal = 0;

        foreach ($request->employees as $empId => $empData) {
            $salaryDetail = SalaryDetail::where('salary_id', $salary->salary_id)
                ->where('employee_id', $empId)
                ->first();

            if ($salaryDetail) {
                $salaryDetail->salary_amount = $empData['salary'];
                $salaryDetail->save();
            } else {
                SalaryDetail::create([
                    'salary_id' => $salary->salary_id,
                    'employee_id' => $empId,
                    'salary_amount' => $empData['salary'],
                ]);
            }

            $grandTotal += $empData['salary'];
        }


        $salary->total_salary = $grandTotal;
        $salary->save();

        DB::commit();
        return response()->json(['message' => 'Salary updated successfully!']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Failed to update salary.', 'error' => $e->getMessage()], 500);
    }
}

    function salarypendingList (){
       $data['pendingList'] = Salary::where('status', '0')->get();
       return view('admin.pages.salary.salarypendinglist',$data);
    }

   public function show($id)
{
    $data['employees'] = Employee::where('status', 1)->get();
    $data['accounts'] = Account::where('status', 1)->get();

    $data['salary'] = Salary::with('salaryDetails', 'salaryDetails.employee')->findOrFail($id);

    // Bengali Month Names
    $data['months'] = [
        1 => 'January',
        2 => 'February',
        3 => 'MArch',
        4 => 'April',
        5 => 'মে',
        6 => 'জুন',
        7 => 'জুলাই',
        8 => 'আগস্ট',
        9 => 'সেপ্টেম্বর',
        10 => 'অক্টোবর',
        11 => 'নভেম্বর',
        12 => 'ডিসেম্বর',
    ];

    return view('admin.pages.salary.show', $data);
}


   function salaryApprove($id){
          $salary = Salary::findOrFail($id);
    $salary->status = 'approved';
    $salary->approved_by = auth()->id();
    $salary->save();

        $mrsalary = new MoneyReceipt();
        $mrsalary->mr_no = $salaryNo;
        $mrsalary->fiscal_year = $fiscalYear;
        $mrsalary->receipt_type = '-4';
        $mrsalary->reference_id = $salaryId;
        $mrsalary->pay_method_id = '101';
        $mrsalary->payment_date = $salaryDate;
        $mrsalary->payment_amount = $grandTotal;
        $mrsalary->transaction_added_by = Auth::id();
        $mrsalary->operation_ip = $request->ip();
        $mrsalary->save();
   }

   public function decline(Request $request, $id)
{
    $request->validate([
        'remark' => 'required|string'
    ]);

    $salary = Salary::findOrFail($id);
    $salary->status = 'declined';
    $salary->decline_remark = $request->remark;
    $salary->declined_by = auth()->id();
    $salary->save();

    return redirect()->route('salary.index')->with('error','Salary Declined!');
}


}
