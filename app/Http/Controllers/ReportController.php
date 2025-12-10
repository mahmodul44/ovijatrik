<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Ledger;
use App\Models\Expense;
use App\Models\Project;
use App\Models\User;
use App\Models\MoneyReceipt;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class ReportController extends Controller
{
    function index()
    {
   
        $data['ledgers'] = Ledger::select(
        'project_id',
          DB::raw('SUM(ledger_amount) as total_amount')
         )
        ->with('project')  
        ->groupBy('project_id')
        ->get();

     return view('admin.pages.report.ledger', $data);
   }

   function projectWise(){
     $data['projects'] = Project::where('status',1)->get();
     return view('admin.pages.report.project-wise', $data);
   }

function projectWiseSearch(Request $request)
{
    $projectId = $request->project_id;
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    $previousBalance = 0;

    if ($from && $projectId) {
        $previousTransactions = DB::table('transactions')
            ->where('project_id', $projectId)
            ->where('transaction_date', '<', $from)
            ->get();

        foreach ($previousTransactions as $p) {
            if ($p->transaction_type == 1) {
                $previousBalance += $p->transaction_amount;
            } elseif ($p->transaction_type == -1) {
                $previousBalance -= $p->transaction_amount;
            }
        }
    }

    $query = DB::table('transactions')
        ->leftJoin('accounts', 'accounts.account_id', '=', 'transactions.account_id')
        ->leftJoin('users','users.id','=','transactions.member_id')
        ->leftJoin('expenses','expenses.expense_id','=','transactions.reference_id')
        ->leftJoin('expense_categories','expense_categories.expense_cat_id','=','expenses.expense_cat_id')
        ->leftJoin('money_receipts','money_receipts.mr_id','=','transactions.reference_id')
        ->leftJoin('projects', 'projects.project_id', '=', 'transactions.project_id')
        ->whereNotNull('transactions.project_id')
        ->orderBy('transactions.transaction_date', 'asc')
           ->select(
        'transactions.transaction_id',
        'transactions.transaction_date',
        'transactions.project_id',
        'transactions.transaction_type',
        'transactions.transaction_amount',
        'accounts.*',
        'users.name as member_name','users.member_id as memberID',
        'expenses.*','money_receipts.mr_no','expense_categories.expense_cat_name',
        'projects.project_title','projects.project_code','projects.target_amount',
        'projects.collection_amount','projects.total_expense'
    );

    if ($projectId) {
        $query->where('transactions.project_id', $projectId);
    }

    if ($from && $to) {
        $query->whereBetween('transactions.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transactions.transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('transactions.transaction_date', '<=', $to);
    }

    $reportData = $query->get();
    $projectInfo = null;

    if ($projectId) {
        $projectInfo = DB::table('projects')
            ->where('project_id', $projectId)
            ->select('project_id','project_title', 'project_code', 'project_details', 'project_start_date', 'project_end_date','collection_amount','target_amount','total_expense')
            ->first();
    }

    return view('admin.pages.report.project-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'projectId' => $projectId,
        'projectInfo' => $projectInfo,
        'previousBalance' => $previousBalance
    ]);
}

function memberWise(){
     $data['members'] = User::where(['status' =>1 , 'role' => 3])->get();
     $data['accounts'] = Account::where('status', 1)->where('account_type', 2)->get();
     return view('admin.pages.report.member-wise', $data);
   }

function memberWiseSearch(Request $request)
{
    $memberId = $request->member_id;
    $accountId = $request->account_id;
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    $query = DB::table('transactions')
        ->leftJoin('projects', 'projects.project_id', '=', 'transactions.project_id')
        ->leftJoin('accounts','accounts.account_id','=','transactions.account_id')
        ->leftJoin('users','users.id','=','transactions.member_id')
         ->leftJoin('money_receipts','money_receipts.mr_id','=','transactions.reference_id')
        ->where('transactions.transaction_type','>=',0)
        ->select(
            'transactions.transaction_date',
            'transactions.member_id',
            'users.name as member_name',
            'projects.project_title',
            'accounts.account_name',
            'accounts.account_no',
            'transactions.transaction_type',
            'transactions.transaction_amount',
            'transactions.reference_id', 'money_receipts.mr_no','money_receipts.donar_name',
        )
        ->orderBy('transactions.transaction_date', 'asc');

    if ($memberId) {
        $query->where('transactions.member_id', $memberId);
    }

    if ($accountId) {
        $query->where('transactions.account_id', $accountId);
    }

    if ($from && $to) {
        $query->whereBetween('transactions.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transactions.transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('transactions.transaction_date', '<=', $to);
    }

    $reportData = $query->get();

    $memberName = $memberId ? DB::table('users')->where('id', $memberId)->first() : null;

    return view('admin.pages.report.member-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'memberId' => $memberId,
        'memberName' => $memberName
    ]);
}


 function accountWise(){
     $data['projects'] = Project::where('status',1)->where('project_id','!=','10000001')->get();
     $data['accounts'] = Account::where('status', 1)->where('account_type', 2)->get();
     return view('admin.pages.report.account-wise', $data);
}

function accountWiseSearch(Request $request)
{
    $projectId = $request->project_id;
    $accountId = $request->account_id;

    if (!$projectId && !$accountId) {
        return back()->with('error', 'Please select at least Project or Account');
    }

    $query = Ledger::with('project', 'account');

    if ($projectId && $accountId) {
        $query->where('project_id', $projectId)
              ->where('account_id', $accountId);
    }
    elseif ($projectId && !$accountId) {
        $query->where('project_id', $projectId);
    }
    elseif (!$projectId && $accountId) {
        $query->where('account_id', $accountId)
              ->whereHas('project', function($q) {
                  $q->where('status', 1); 
              });
    }

    $reportData = $query->orderBy('project_id', 'asc')
                        ->orderBy('account_id', 'asc')
                        ->get();

    $projectInfo = $projectId ? Project::find($projectId) : null;
    $accountInfo = $accountId ? Account::find($accountId) : null;

    return view('admin.pages.report.account-wise-view', [
        'reportData'  => $reportData,
        'projectInfo' => $projectInfo,
        'accountInfo' => $accountInfo,
        'projectId'   => $projectId,
        'accountId'   => $accountId
    ]);
}

function dateWiseAccount(){
     $data['projects'] = Project::where('status',1)->where('project_id','!=','10000001')->get();
     $data['accounts'] = Account::where('status', 1)->where('account_type', 2)->get();
     return view('admin.pages.report.date-wise-account', $data);
}

function dateWiseAccountDetails(Request $request)
{
    $projectId = $request->project_id;
    $accountId = $request->account_id;

    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    if (!$projectId && !$accountId && !$from && !$to) {
        return view('admin.pages.report.date-wise-account-view', [
            'reportData' => collect(),
            'projectInfo' => null,
            'previousBalance' => 0,
            'from' => $from,
            'to' => $to
        ]);
    }

    $query = DB::table('transactions')
        ->leftJoin('accounts', 'accounts.account_id', '=', 'transactions.account_id')
        ->leftJoin('users', 'users.id', '=', 'transactions.member_id')
        ->leftJoin('money_receipts', 'money_receipts.mr_id', '=', 'transactions.reference_id')
        ->leftJoin('projects', 'projects.project_id', '=', 'transactions.project_id')
        ->whereNotNull('transactions.project_id')
        ->where('transactions.project_id', '!=', 1000001)
        ->where('transactions.transaction_type', '>=',0)    
        ->select(
            'transactions.*',
            'projects.project_title',
            'projects.project_code',
            'accounts.account_name',
            'accounts.account_no',
            'users.name as member_name',
            'money_receipts.mr_no','money_receipts.donar_name'
        )
        ->orderBy('transactions.transaction_date', 'asc');

    if ($projectId) {
        $query->where('transactions.project_id', $projectId);
    }

    if ($accountId) {
        $query->where('transactions.account_id', $accountId);
    }

    if ($from && $to) {
        $query->whereBetween('transactions.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transactions.transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('transactions.transaction_date', '<=', $to);
    }

    $reportData = $query->get();

    $projectInfo = null;
    if ($projectId) {
        $projectInfo = DB::table('projects')
            ->where('project_id', $projectId)
            ->select('project_id','project_title','project_code','project_details','project_start_date','project_end_date','collection_amount','target_amount','total_expense')
            ->first();
    }

    return view('admin.pages.report.date-wise-account-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'projectId' => $projectId,
        'projectInfo' => $projectInfo,
        'previousBalance' => 0
    ]);
}


}
