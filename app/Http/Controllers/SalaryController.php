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
use App\Models\PaymentMethod;
use App\Models\Account;
use DB;

class SalaryController extends Controller
{

    public function index(){
       $data['salary'] = Salary::orderBy('salary_id', 'desc')
        ->get();
        return view('admin.pages.salary.index', $data);
    }

    public function create(){
        $data['employees'] = Employee::where('status',1)->get();
        $data['accounts'] = Account::where('status', 1)->where('account_type', 1)->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
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
        'account_id'        => 'required',
        'pay_method_id'     => 'required',
        'bank_name'         => 'nullable|Max:100',
        'bank_account_no'   => 'nullable|Max:50',
        'mobile_account_no' => 'nullable|Max:15',
        'transaction_no'    => 'nullable|Max:100',
        'posting_type'      => 'required'
    ]);

    if ($validate->fails()) {
        $data['status'] = false;
        $data['message'] = "Validation failed! Please check your inputs...";
        $data['errors'] = $validate->errors();
        return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
    }

    $salaryDate = Carbon::createFromFormat('d/m/Y', $request->salary_date)->format('Y-m-d');
    $fiscalYear = $this->fiscalYearCal($request->salary_year, $request->salary_month);
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
       $salary = new Salary();
            $prefix = 'OVJSL';
            $yearMonth = date('ym'); 

            $lastExpense = Salary::where('salary_no', 'LIKE', "$prefix-$yearMonth%")
                        ->orderBy('salary_id', 'desc')
                        ->first();

            if ($lastExpense) {
                $lastNumber = intval(substr($lastExpense->salary_no, -3));
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            $salaryNo = "$prefix-$yearMonth$newNumber";

            while (Salary::where('salary_no', $salaryNo)->exists()) {
                $newNumber = str_pad(intval($newNumber) + 1, 3, '0', STR_PAD_LEFT);
                $salaryNo = "$prefix-$yearMonth$newNumber";
            }

        $salaryNo = "OVJSL" . '-' . rand(1000, 9999);

        $salary = new Salary();
        $salary->salary_no    = $salaryNo;
        $salary->fiscal_year  = $fiscalYear;
        $salary->salary_year  = $request->salary_year;
        $salary->salary_month = $request->salary_month;
        $salary->salary_date  = $salaryDate;
        $salary->project_id   = $request->project_id;
        $salary->account_id   = $request->account_id;
        $salary->pay_method_id     = $request->pay_method_id;
        $salary->bank_account_no   = $request->bank_account_no;
        $salary->mobile_account_no = $request->mobile_account_no;
        $salary->bank_name         = $request->bank_name;
        $salary->transaction_no    = $request->transaction_no;
        $salary->posting_type = $request->posting_type;
        $salary->status       = '0';
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

  public function edit($id)
{
    $data['employees'] = Employee::where('status', 1)->get();
    $data['accounts'] = Account::where('status', 1)->where('account_type', 1)->get();
    $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
    
    $data['salaries'] = Salary::with('salaryDetails', 'salaryDetails.employee')
                            ->findOrFail($id);

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
        'account_id'        => 'required',
        'pay_method_id'     => 'required',
        'bank_name'         => 'nullable|Max:100',
        'bank_account_no'   => 'nullable|Max:50',
        'mobile_account_no' => 'nullable|Max:15',
        'transaction_no'    => 'nullable|Max:100',
        'posting_type'      => 'required'
    ]);

    if ($validate->fails()) {
        return response()->json([
            'status' => false,
            'message' => "Validation failed! Please check your inputs.",
            'errors' => $validate->errors()
        ], 400);
    }

   
    $salaryDate = Carbon::createFromFormat('d/m/Y', $request->salary_date)->format('Y-m-d');
    $fiscalYear = $this->fiscalYearCal($request->salary_year, $request->salary_month);
    DB::beginTransaction();
    try {
        $salary = Salary::findOrFail($id);
        $salary->salary_year  = $request->salary_year;
        $salary->fiscal_year  = $fiscalYear;
        $salary->salary_month = $request->salary_month;
        $salary->salary_date  = $salaryDate;
        $salary->project_id   = $request->project_id;
        $salary->account_id   = $request->account_id;
        $salary->pay_method_id     = $request->pay_method_id;
        $salary->bank_account_no   = $request->bank_account_no;
        $salary->mobile_account_no = $request->mobile_account_no;
        $salary->bank_name         = $request->bank_name;
        $salary->transaction_no    = $request->transaction_no;
        $salary->posting_type = $request->posting_type;
        $salary->status       = '0';
        $salary->updated_by   = Auth::id();
        $salary->updated_at   = now();
        $salary->operation_ip = $request->ip();
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
       $data['pendingList'] = Salary::where('status', '0')->where('posting_type',1)->get();
       return view('admin.pages.salary.salarypendinglist',$data);
    }

   public function show($id)
{
    $data['employees'] = Employee::where('status', 1)->get();
    $data['accounts'] = Account::where('status', 1)->where('account_type', 1)->get();
    $data['salary'] = Salary::with('account','salaryDetails', 'salaryDetails.employee')->findOrFail($id);

    // Bengali Month Names
    $data['months'] = [
        1 => 'January',
        2 => 'February',
        3 => 'MArch',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'Augest',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    return view('admin.pages.salary.show', $data);
}


   function salaryApprove(Request $request){
         DB::beginTransaction();

    try {
        $salary = Salary::findOrFail($request->id);
        $projectId = $salary->project_id;
        $totalAmount = $salary->total_salary;
        $accountID = $salary->account_id;

        if ($projectId) {
            $ledger = DB::table('debit_credit_ledger')
                ->where('project_id', $projectId)
                ->first();

            if (!$ledger) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ledger not found for this project!'
                ], 200); 
            }

            if ($ledger->ledger_amount < $totalAmount) {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient balance for this salary account!',
                    'balance' => number_format($ledger->ledger_amount, 2)
                ], 200);
            }
        }

        $account = DB::table('accounts')
            ->where('account_id', $accountID)
            ->where('account_type', 1)
            ->lockForUpdate()
            ->first();

        if (!$account) {
            return response()->json([
                'status'  => false,
                'message' => 'Account not found!'
            ], 200);
        }

        if ($account->current_balance < $totalAmount) {
            return response()->json([
                'status'  => false,
                'message' => 'Insufficient Account Balance!',
                'balance' => number_format($account->current_balance, 2)
            ], 200);
        }
        
        DB::table('transactions')->insert([
            'transaction_date'     => $salary->salary_date,
            'fiscal_year'          => $salary->fiscal_year,
            'project_id'           => $salary->project_id,
            'account_id'           => $salary->account_id,
            'transaction_type'     => -1, 
            'transaction_amount'   => $salary->total_salary,
            'reference_type'       => 'salary-expenses',
            'reference_id'         => $salary->salary_id, 
            'pay_method_id'        => $salary->pay_method_id,
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
        ]);

         DB::table('projects')
            ->where('project_id', $projectId)
            ->increment('total_expense', $totalAmount);

        DB::table('accounts')
            ->where('account_id', $accountID)
            ->decrement('current_balance', $totalAmount);

        $salary->update([
            'status' => 1,
            'approval_by' => Auth::id(),
            'approval_at' => now()
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Approved Successfully!'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong!',
            'error_detail' => $e->getMessage()
        ], 500);
      }
   }

   public function salaryDecline(Request $request, $id)
{
    $request->validate([
        'remark' => 'required|string'
    ]);

    $salary = Salary::findOrFail($id);

    $salary->status = '-1';
    $salary->decline_remark = $request->remark;
    $salary->posting_type = '0';
    $salary->declined_by = auth()->id();
    $salary->declined_at = now();  

    $salary->save();

    return redirect()->route('salary.index')->with('error', 'Salary Declined!');
}

public function destroy($id)
{
    DB::beginTransaction();

    try {
    
        $salary = Salary::with('salaryDetails')->findOrFail($id);

        SalaryDetail::where('salary_id', $salary->salary_id)->delete();

        $salary->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Salary and related details deleted successfully'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error deleting salary: ' . $e->getMessage()
        ], 500);
    }
}


function fiscalYearCal($year, $month)
{
    if ($month < 7) {
        return ($year - 1) . '-' . $year;
    }
    return $year . '-' . ($year + 1);
}


}
