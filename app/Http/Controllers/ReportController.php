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
        ->select(
            'transaction_date',
            'project_id',
            DB::raw("SUM(CASE WHEN transaction_type = 1 THEN transaction_amount ELSE 0 END) as total_receipt"),
            DB::raw("SUM(CASE WHEN transaction_type = -1 THEN transaction_amount ELSE 0 END) as total_expense")
        )
        ->groupBy('transaction_date', 'project_id')
         ->whereNotNull('project_id')
        ->orderBy('transaction_date', 'asc');

    // ✅ Apply filters dynamically
    if ($projectId) {
        $query->where('project_id', $projectId);
    }

    if ($from && $to) {
        $query->whereBetween('transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('transaction_date', '<=', $to);
    }

    $reportData = $query->get();

    // ✅ Project Name (if selected)
    $projectName = null;
    if ($projectId) {
        $projectName = DB::table('projects')->where('project_id', $projectId)->value('project_title');
    }

    return view('admin.pages.report.project-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'projectName' => $projectName
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
