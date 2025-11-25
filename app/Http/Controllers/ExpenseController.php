<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FiscalYear;
use App\Models\Account;
use App\Models\Project;
use App\Models\MoneyReceipt;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $data['expenses'] = Expense::with(['expcategory', 'project'])->where('expense_type',2)->orderBy('expense_id', 'desc')->get();
        return view('admin.pages.expense.index',  $data);
    }

    public function create()
    {
        $data = array();
        $data['categoris'] = Category::where('status',1)->get();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['expenseCat'] = ExpenseCategory::where('status',1)->get();
        return view('admin.pages.expense.create', $data);
    }

    function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'expense_cat_id'    => 'required',
                'expense_date'      => 'required',
                'expense_amount'    => 'required',
                'account_id'        => 'required',
                'pay_method_id'     => 'required',
                'bank_name'         => 'nullable|Max:100',
                'bank_account_no'   => 'nullable|Max:50',
                'mobile_account_no' => 'nullable|Max:15',
                'transaction_no'    => 'nullable|Max:100',
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
            $prefix = 'OVGEXP';
            $yearMonth = date('ym'); 

            $lastExpense = Expense::where('expense_no', 'LIKE', "$prefix-$yearMonth%")
                        ->where('expense_type',2)
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
            $expense->expense_type      = 2;
            $expense->expense_cat_id    = $request->expense_cat_id;
            $expense->fiscal_year       = $fiscalYear;
            $expense->expense_date      = $expenseDate;
            $expense->account_id        = $request->account_id;
            $expense->expense_amount    = $request->expense_amount;
            $expense->expense_remarks   = $request->expense_remarks;
            $expense->pay_method_id     = $request->pay_method_id;
            $expense->bank_account_no   = $request->bank_account_no;
            $expense->mobile_account_no = $request->mobile_account_no;
            $expense->bank_name         = $request->bank_name;
            $expense->transaction_no    = $request->transaction_no;
            $expense->expense_added_by  = Auth::id();
            $expense->status            = $request->status ? $request->status : 0;

            if ($expense->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
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
        $data['categoris'] = Category::where('status',1)->get();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['expenseCat'] = ExpenseCategory::where('status',1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['expense'] = Expense::findOrFail($id);
        return view('admin.pages.expense.edit', $data);
    }

    function update(Request $request, $id)
    {
    try {
        // Validation
        $validate = Validator::make($request->all(), [
            'expense_cat_id'    => 'required',
            'expense_date'      => 'required',
            'expense_amount'    => 'required',
            'account_id'        => 'required',
            'pay_method_id'     => 'required',
            'bank_name'         => 'nullable|Max:100',
            'bank_account_no'   => 'nullable|Max:50',
            'mobile_account_no' => 'nullable|Max:15',
            'transaction_no'    => 'nullable|Max:100',
            'expense_remarks'   => 'nullable|Max:200',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Validation failed! Please check your inputs...";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)
                        ->header('Content-Type', 'application/json');
        }

        // Fetch existing expense
        $expense = Expense::findOrFail($id);

        // Format date and fiscal year
        $expenseDate = Carbon::createFromFormat('d/m/Y', $request->expense_date)->format('Y-m-d');
        $fiscalYear = getFiscalYearFromDate($expenseDate);

        $expense->expense_cat_id    = $request->expense_cat_id;
        $expense->fiscal_year       = $fiscalYear;
        $expense->expense_date      = $expenseDate;
        $expense->account_id        = $request->account_id;
        $expense->expense_amount    = $request->expense_amount;
        $expense->expense_remarks   = $request->expense_remarks;
        $expense->pay_method_id     = $request->pay_method_id;
        $expense->bank_account_no   = $request->bank_account_no;
        $expense->mobile_account_no = $request->mobile_account_no;
        $expense->transaction_no    = $request->transaction_no;
        $expense->bank_name         = $request->bank_name;
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

    function expenseSearch(Request $request) {
         $search = $request->q;

    $results = ExpenseCategory::select('expense_cat_id','expense_cat_name', 'expense_cat_name_bn')
        ->where('expense_cat_name', 'like', "%{$search}%")
        ->orWhere('expense_cat_name_bn', 'like', "%{$search}%")
        ->orWhere('expense_cat_id', 'like', "%{$search}%")
        ->limit(10)
        ->get();

        $formatted = [];

        foreach ($results as $expCat) {
            $formatted[] = [
                'id' => $expCat->expense_cat_id,
                'text' => "{$expCat->expense_cat_id} - {$expCat->expense_cat_name}"
            ];
        }

    return response()->json($formatted);
    }

    function expensePendinglist(){
        $data['expenses'] = Expense::with(['project','expcategory'])->where('expense_type', '2')->where('status', '0')->get();
        return view('admin.pages.expense.expensependinglist',$data);
    }

    function expenseApprove(Request $request)
    {
    DB::beginTransaction();

    try {
        $expense = Expense::findOrFail($request->id);
        $catId = $expense->expense_cat_id;
        $expenseAmount = $expense->expense_amount;
        $accountID = $expense->account_id;

        if ($catId) {
            $ledger = DB::table('debit_credit_ledger')
                ->where('project_id', '10000001')
                ->where('account_id',$accountID)
                ->first();

            if (!$ledger) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ledger not found for this account!'
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
            'project_id'           => '10000001',
            'transaction_type'     => -1,  
            'account_id'           => $expense->account_id,
            'transaction_amount'   => $expense->expense_amount,
            'reference_type'       => 'expenses',
            'reference_id'         => $expense->expense_id, 
            'pay_method_id'        => $expense->pay_method_id,
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
        ]);

        if ($catId) {
            DB::table('projects')
                ->where('project_id', '10000001')
                ->increment('total_expense', $expense->expense_amount);
        }

        // Update expenses status
        $expense->update([
            'status' => 1
        ]);

        DB::commit();

        return response()->json([
            'success' => 'Approved Successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function expenseDecline(Request $request)
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

public function expensePreview($id)
{
    $expense = Expense::with(['project','expcategory'])->findOrFail($id);
    return view('admin.pages.expense.expensepreview', compact('expense'));
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
