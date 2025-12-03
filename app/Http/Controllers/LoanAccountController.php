<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\LoanAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        return view('admin.pages.projectloan.index');
    }

    public function loanCreate(){
        $data['loanaccounts'] = LoanAccount::orderBy('loan_account_id', 'asc')->get();
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


}
