<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\FiscalYear;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Ledger;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;

class ProjectExpenseController extends Controller
{
    public function index()
    {
        $data['expenses'] = Expense::with(['expcategory', 'project'])->where('expense_type',1)->orderBy('expense_id', 'desc')->get();
        return view('admin.pages.projectexpense.index',  $data);
    }

    public function create()
    {
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        return view('admin.pages.projectexpense.create', $data);
    }

    function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'expense_date'      => 'required',
                'expense_amount'    => 'required',
                'account_id'        => 'required',
                'pay_method_id'     => 'required',
                'bank_name'         => 'nullable|Max:100',
                'bank_account_no'   => 'nullable|Max:50',
                'mobile_account_no' => 'nullable|Max:15',
                'expense_remarks'   => 'nullable|Max:200',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            $expenseDate = Carbon::createFromFormat('d/m/Y', $request->expense_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($expenseDate);
           
            $expense = new Expense();
            $prefix = 'OVPEXP';
            $yearMonth = date('ym'); 

            $lastExpense = Expense::where('expense_no', 'LIKE', "$prefix-$yearMonth%")
                        ->where('expense_type',1)
                        ->orderBy('expense_id', 'desc')
                        ->first();

            if ($lastExpense) {
                $lastNumber = intval(substr($lastExpense->expense_no, -3));
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            $expNo = "$prefix-$yearMonth$newNumber";

            while (Expense::where('expense_no', $expNo)->exists()) {
                $newNumber = str_pad(intval($newNumber) + 1, 3, '0', STR_PAD_LEFT);
                $expNo = "$prefix-$yearMonth$newNumber";
            }
           
            $expense->expense_no        = $expNo;
            $expense->expense_type      = 1;
            $expense->project_id        = $request->project_id;
            $expense->fiscal_year       = $fiscalYear;
            $expense->expense_date      = $expenseDate;
            $expense->account_id        = $request->account_id;
            $expense->expense_amount    = $request->expense_amount;
            $expense->receiver_name     = $request->receiver_name;
            $expense->pay_method_id     = $request->pay_method_id;
            $expense->bank_account_no   = $request->bank_account_no;
            $expense->mobile_account_no = $request->mobile_account_no;
            $expense->bank_name         = $request->bank_name;
            $expense->expense_remarks   = $request->expense_remarks;
            $expense->expense_added_by  = Auth::id();
            $expense->status            = $request->status ? $request->status : 0;

            if ($expense->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successful!";
                $data['expense'] = $expense;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['expense'] = $expense;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Something went wrong! Please try again...";
                $data['errors'] = $th;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
    }

    function edit($id)
    {
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['expense'] = Expense::findOrFail($id);
        return view('admin.pages.projectexpense.edit', $data);
    }

    function update(Request $request, $id)
    {
    try {
        $validate = Validator::make($request->all(), [
            'project_id'        => 'required',
            'expense_date'      => 'required',
            'expense_amount'    => 'required',
            'account_id'        => 'required',
            'pay_method_id'     => 'required',
            'bank_name'         => 'nullable|Max:100',
            'bank_account_no'   => 'nullable|Max:50',
            'mobile_account_no' => 'nullable|Max:15',
            'expense_remarks'   => 'nullable|Max:200',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Validation failed! Please check your inputs...";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)
                        ->header('Content-Type', 'application/json');
        }

        $expense = Expense::findOrFail($id);

        $expenseDate = Carbon::createFromFormat('d/m/Y', $request->expense_date)->format('Y-m-d');
        $fiscalYear = getFiscalYearFromDate($expenseDate);

        $expense->expense_type      = 1;
        $expense->project_id        = $request->project_id;
        $expense->fiscal_year       = $fiscalYear;
        $expense->expense_date      = $expenseDate;
        $expense->expense_amount    = $request->expense_amount;
        $expense->account_id        = $request->account_id;
        $expense->pay_method_id     = $request->pay_method_id;
        $expense->bank_account_no   = $request->bank_account_no;
        $expense->mobile_account_no = $request->mobile_account_no;
        $expense->bank_name         = $request->bank_name;
        $expense->expense_remarks   = $request->expense_remarks;
        $expense->status            = $request->status ? $request->status : 0;

        if ($expense->save()) {
            $data['status'] = true;
            $data['message'] = "Updated successfully.";
            $data['expense'] = $expense;
            return response(json_encode($data, JSON_PRETTY_PRINT), 200)
                        ->header('Content-Type', 'application/json');
        } else {
            $data['status'] = false;
            $data['message'] = "Update failed! Please try again...";
            $data['expense'] = $expense;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)
                        ->header('Content-Type', 'application/json');
         }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)
                        ->header('Content-Type', 'application/json');
        }
    }

    function expensePendinglist(){
        $data['expenses'] = Expense::with(['project','expcategory'])->where('expense_type', '1')->where('status', '0')->get();
        return view('admin.pages.projectexpense.expensependinglist',$data);
    }

    function projectexpenseApprove(Request $request)
    {
      DB::beginTransaction();

    try {
        $expense = Expense::findOrFail($request->id);
        $projectId = $expense->project_id;
        $expenseAmount = $expense->expense_amount;
        $accountID = $expense->account_id;

        // If project_id exists, check ledger balance
        if ($projectId) {
            $ledger = DB::table('debit_credit_ledger')
                ->where('project_id', $projectId)
                ->where('account_id', $accountID)
                ->first();

            if (!$ledger) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ledger not found for this project account!'
                ], 200); 
            }

            if ($ledger->ledger_amount < $expenseAmount) {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient ledger balance for this project account!',
                    'balance' => number_format($ledger->ledger_amount, 2)
                ], 200);
            }
        }
        
        // Insert into transactions table
        DB::table('transactions')->insert([
            'transaction_date'     => $expense->expense_date,
            'fiscal_year'          => $expense->fiscal_year,
            'project_id'           => $expense->project_id,
            'account_id'           => $expense->account_id,
            'transaction_type'     => -1, 
            'transaction_amount'   => $expense->expense_amount,
            'reference_type'       => 'project-expenses',
            'reference_id'         => $expense->expense_id, 
            'pay_method_id'        => $expense->pay_method_id,
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
        ]);

        if ($expense->project_id) {
            DB::table('projects')
                ->where('project_id', $expense->project_id)
                ->increment('total_expense', $expense->expense_amount);
        }

        // Update expenses status
        $expense->update([
            'status' => 1
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

function projectexpenseDecline(Request $request)
{
    try {
        $expense = Expense::findOrFail($request->id);

        $expense->update([
            'status' => -1,
            'decline_remarks' => $request->remarks,
        ]);

        return response()->json([
            'success' => 'Declined Successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage()
        ], 500);
    }
}
 
function show($id)
{
    $expense = Expense::with(['project','expcategory'])->find($id);

    if ($expense) {
     return response()->json($expense);
    }
    return response()->json(['error' => 'Expense not found'], 404);
}

function expensePreview($id)
{
    $expense = Expense::with(['project','expcategory'])->findOrFail($id);
    return view('admin.pages.projectexpense.expensepreview', compact('expense'));
}

public function getProjectLedger(Request $request)
{
    if (!$request->project_id) {
        return response()->json([
            'status' => 'no_project',
            'message' => 'Select project first!'
        ]);
    }

    $balance = Ledger::where('project_id', $request->project_id)
                ->where('account_id', $request->account_id)
                ->sum('ledger_amount');  

    return response()->json([
        'status'  => 'ok',
        'balance' => number_format($balance, 2)
    ]);
}

public function destroy($id)
{
    try {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found.',
            ], 404);
        }

        $expense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully.',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}



}
