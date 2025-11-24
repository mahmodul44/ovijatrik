<?php

namespace App\Http\Controllers;

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
    $data['ledgers'] = Ledger::with('project')->get();

    // $totalDebit = $ledgers->where('ledger_type', 1)->sum('ledger_amount');
    // $totalCredit = $ledgers->where('ledger_type', -1)->sum('ledger_amount');
    // $balance = $totalDebit - $totalCredit;

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

    $query = DB::table('transactions')
        ->leftJoin('accounts', 'accounts.account_id', '=', 'transactions.account_id')
        ->leftJoin('users','users.id','=','transactions.member_id')
        ->leftJoin('expenses','expenses.expense_id','=','transactions.reference_id')
        ->leftJoin('expense_categories','expense_categories.expense_cat_id','=','expenses.expense_cat_id')
        ->leftJoin('money_receipts','money_receipts.mr_id','=','transactions.reference_id')
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
        'expenses.*','money_receipts.mr_no','expense_categories.expense_cat_name'
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
            ->select('project_title', 'project_code', 'project_details', 'project_start_date', 'project_end_date')
            ->first();
    }
   //dd($reportData);
    return view('admin.pages.report.project-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'projectInfo' => $projectInfo
    ]);
}

function memberWise(){
     $data['members'] = User::where(['status' =>1 , 'role' => 3])->get();
     return view('admin.pages.report.member-wise', $data);
   }

function memberWiseSearch(Request $request)
{
    $memberId = $request->member_id;
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    $query = DB::table('transactions')
        ->join('projects', 'projects.project_id', '=', 'transactions.project_id')
        ->select(
            'transactions.transaction_date',
            'transactions.member_id',
            'projects.project_title',
            DB::raw("SUM(CASE WHEN transaction_type = 1 THEN transaction_amount ELSE 0 END) as total_receipt"),
            DB::raw("SUM(CASE WHEN transaction_type = -1 THEN transaction_amount ELSE 0 END) as total_expense")
        )
        ->groupBy('transactions.transaction_date', 'transactions.member_id', 'projects.project_title')
        ->whereNotNull('transactions.member_id')
        ->orderBy('transactions.transaction_date', 'asc');

    if ($memberId) {
        $query->where('transactions.member_id', $memberId);
    }

    if ($from && $to) {
        $query->whereBetween('transactions.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transactions.transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('transactions.transaction_date', '<=', $to);
    }

    $reportData = $query->get();

    // member name for header
    $memberName = null;
    if ($memberId) {
        $memberName = DB::table('users')->where('id', $memberId)->value('name');
    }

    return view('admin.pages.report.member-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'memberName' => $memberName
    ]);
}


}
