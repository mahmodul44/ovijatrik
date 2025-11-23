<?php

namespace App\Http\Controllers;

use App\Models\MoneyReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyTransactionController extends Controller
{
    function index(){
        $userId = Auth::id(); 
        $data['moneyreceipts'] = MoneyReceipt::with('project')->where('member_id',$userId)->orderBy('mr_id', 'desc')->get();
        return view('admin.pages.mytransaction.myreceipt',$data);
    }

    function myReport(){
        return view('admin.pages.mytransaction.myreport');
    }

    function myReportView(Request $request)
    {
    $userId = Auth::id();
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    $query = DB::table('transactions as t')
        ->join('projects as p', 't.project_id', '=', 'p.project_id') // project name join
        ->select(
            't.transaction_date',
            't.project_id',
            'p.project_title as project_name',
            DB::raw("SUM(CASE WHEN t.transaction_type = 1 THEN t.transaction_amount ELSE 0 END) as total_receipt"),
            DB::raw("SUM(CASE WHEN t.transaction_type = -1 THEN t.transaction_amount ELSE 0 END) as total_expense")
        )
        ->where('t.member_id', $userId) // only login user transactions
        ->whereNotNull('t.project_id')
        ->groupBy('t.transaction_date', 't.project_id', 'p.project_title')
        ->orderBy('t.transaction_date', 'asc');

    if ($from && $to) {
        $query->whereBetween('t.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('t.transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('t.transaction_date', '<=', $to);
    }

    $reportData = $query->get();

    return view('admin.pages.mytransaction.myreportview', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to
    ]);
}
   
}
