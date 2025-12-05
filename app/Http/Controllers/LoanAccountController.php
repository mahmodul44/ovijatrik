<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\LoanAccount;
use App\Models\Project;
use App\Models\LoanTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class LoanAccountController extends Controller
{
   function index(){
         $data['accounts'] = LoanAccount::orderBy('loan_account_id', 'desc')->get();
         return view('admin.pages.loanaccount.index',$data);
    }

    function create()
    {
        return view('admin.pages.loanaccount.create');
    }

    function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'account_name'  => 'required|max:50',
                'account_no'    => 'required|max:50',
                'account_type'  => 'required'
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
          
            $account = new LoanAccount();
            $account->account_name     = $request->account_name;
            $account->account_no       = $request->account_no;
            $account->account_type     = $request->account_type;
            $account->project_id       = '10000007';
            $account->opening_balance  = $request->opening_balance ? $request->opening_balance : '0.00';
            $account->current_balance  = $request->opening_balance ? $request->opening_balance : '0.00';
            $account->status           = $request->status ? $request->status : 1;
            $account->bank_name        = $request->bank_name;
            $account->created_by       = Auth::id();

            if ($account->save()) {
                $data['status'] = true;
                $data['message'] = "Saved Successful.";
                $data['account'] = $account;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save Failed! Please try again...";
                $data['account'] = $account;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    public function loanApply(){
        $data['loantransaction'] = LoanTransaction::orderBy('loan_transactions_id', 'asc')->get();
        return view('admin.pages.projectloan.index',$data);
    }

    public function loanCreate(){
        $data['loanaccounts'] = LoanAccount::get();
        return view('admin.pages.projectloan.create',$data);
    }

    
public function getloanaccountLedger(Request $request)
{
    if (!$request->account_id) {
        return response()->json([
            'status' => 'no_account',
            'message' => 'Account Found!'
        ]);
    }

    $balance = LoanAccount::where('loan_account_id', $request->account_id)
                ->sum('current_balance');  

    return response()->json([
        'status'  => 'ok',
        'balance' => number_format($balance, 2)
    ]);
}

public function projectTotal($project_id)
{
    $projectTotal = Ledger::where('project_id', $project_id)
        ->sum('ledger_amount');

    $accountWise = Ledger::select(
            'accounts.account_name',
            DB::raw('SUM(debit_credit_ledger.ledger_amount) as account_total')
        )
        ->leftJoin('accounts', 'accounts.account_id', '=', 'debit_credit_ledger.account_id')
        ->where('debit_credit_ledger.project_id', $project_id)
        ->groupBy('accounts.account_name')
        ->get();

    return response()->json([
        'project_total' => $projectTotal,
        'account_wise'  => $accountWise
    ]);
}

public function loanStore(Request $request){
    try {
            $validate = Validator::make($request->all(), [
                'project_id'    => 'required|max:50',
                'loan_account'  => 'required|max:50',
                'loan_date'     => 'required',
                'loan_amount'   => 'required'
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }

            $loanDate = Carbon::createFromFormat('d/m/Y', $request->loan_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($loanDate);
          
            $loantransaction = new LoanTransaction();

            $prefix = 'LOAN';
            $yearMonth = date('ym'); 

            $lastLoan = LoanTransaction::where('loan_transaction_no', 'LIKE', "$prefix-$yearMonth%")
                            ->orderBy('loan_transaction_no', 'desc')
                            ->first();

            if ($lastLoan) {
                $lastNumber = intval(substr($lastLoan->loan_transaction_no, -3));
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            $loanNo = "$prefix-$yearMonth$newNumber";

            while (LoanTransaction::where('loan_transaction_no', $loanNo)->exists()) {
                $newNumber = str_pad(intval($newNumber) + 1, 3, '0', STR_PAD_LEFT);
                $loanNo = "$prefix-$yearMonth$newNumber";
            }

            $loantransaction->fiscal_year      = $fiscalYear;
            $loantransaction->loan_transaction_no   = $loanNo;
            $loantransaction->loan_account_id  = $request->loan_account;
            $loantransaction->loan_date        = $loanDate;
            $loantransaction->loan_project     = $request->project_id;
            $loantransaction->loan_amount      = $request->loan_amount;
            $loantransaction->loan_remarks     = $request->loan_remarks;
            $loantransaction->loan_status      = $request->loan_status ? $request->loan_status : 0;
            $loantransaction->created_by       = Auth::id();

            if ($loantransaction->save()) {
                $data['status'] = true;
                $data['message'] = "Saved Successful.";
                $data['loantransaction'] = $loantransaction;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save Failed! Please try again...";
                $data['loantransaction'] = $loantransaction;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
}

function loanEdit($id){
    $data['projects'] = Project::where('status', 1)->get();
    $data['loanaccounts'] = LoanAccount::orderBy('loan_account_id', 'asc')->get();
    $data['loandataInfo'] = LoanTransaction::findOrFail($id);
    return view('admin.pages.projectloan.loanedit',$data);
}

public function loanUpdate(Request $request,$id){
    try {
            $validate = Validator::make($request->all(), [
                'project_id'    => 'required|max:50',
                'loan_account'  => 'required|max:50',
                'loan_date'     => 'required',
                'loan_amount'   => 'required'
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }

            $loanDate = Carbon::createFromFormat('d/m/Y', $request->loan_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($loanDate);
          
            $loantransaction = LoanTransaction::findOrFail($id);

            $loantransaction->fiscal_year      = $fiscalYear;
            $loantransaction->loan_account_id  = $request->loan_account;
            $loantransaction->loan_date        = $loanDate;
            $loantransaction->loan_project     = $request->project_id;
            $loantransaction->loan_amount      = $request->loan_amount;
            $loantransaction->loan_remarks     = $request->loan_remarks;
            $loantransaction->loan_status      = $request->loan_status ? $request->loan_status : 0;
            $loantransaction->updated_by       = Auth::id();

            if ($loantransaction->save()) {
                $data['status'] = true;
                $data['message'] = "Saved Successful.";
                $data['loantransaction'] = $loantransaction;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save Failed! Please try again...";
                $data['loantransaction'] = $loantransaction;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
}

function loanPending(){
     $data['loanproject'] = LoanTransaction::with('loanProject','loanAccount')
                        ->where('loan_status', '0')->get();
    return view('admin.pages.projectloan.loanpendinglist',$data);
}

public function loanPreview($id)
{
    $loan = LoanTransaction::with(['loanProject','loanAccount'])->findOrFail($id);
    $projectAccountBalances = \DB::table('debit_credit_ledger')
        ->join('accounts', 'accounts.account_id', '=', 'debit_credit_ledger.account_id')
        ->where('debit_credit_ledger.project_id', $loan->loanProject->project_id)
        ->select(
            'accounts.account_name','accounts.account_no',
            \DB::raw("ledger_amount as balance")
        )
        ->get();

    // ✅ Loan Account Current Balance
    $accountBalance = \DB::table('loan_accounts')
        ->where('loan_account_id', $loan->loanAccount->loan_account_id)
        ->value('current_balance');

    return view('admin.pages.projectloan.projectloanpreview', compact('loan','projectAccountBalances','accountBalance'));
}
public function approve($id)
{
    $loan = LoanTransaction::findOrFail($id);

    if ($loan->loan_status != '0') {
        return response()->json([
            'success' => false,
            'message' => 'This loan is already processed.'
        ]);
    }

    \DB::transaction(function() use ($loan) {

        // 1️⃣ Update loan_transactions status
        \DB::table('loan_transactions')
            ->where('loan_transactions_id', $loan->loan_transactions_id)
            ->update([
                'loan_status' => '1',
                'decline_remarks' => null
            ]);

        // 2️⃣ Update loan_accounts current_balance
        \DB::table('loan_accounts')
            ->where('loan_account_id', $loan->loan_account_id)
            ->update([
                'current_balance' => \DB::raw("current_balance - {$loan->loan_amount}")
            ]);

        // 3️⃣ Update project loan_amount
        \DB::table('projects')
            ->where('project_id', $loan->loan_project)
            ->update([
                'loan_amount' => \DB::raw("loan_amount + {$loan->loan_amount}")
            ]);
    });

    return response()->json([
        'success' => true,
        'message' => 'Loan Approved Successfully'
    ]);
}



public function declineLoan(Request $request, $id)
{
    try {
        $request->validate([
            'remarks' => 'required'
        ]);

        $loan = LoanTransaction::findOrFail($id);

        $loan->loan_status = '-1';
        $loan->decline_remarks = $request->remarks;
        $loan->save();

        return response()->json([
            'success' => true,
            'message' => 'Loan Declined Successfully'
        ]);
    } catch (\Illuminate\Validation\ValidationException $ve) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $ve->errors()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Loan decline error: '.$e->getMessage().' in '.$e->getFile().' on line '.$e->getLine());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}




}
