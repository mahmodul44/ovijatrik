<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\About;
use App\Models\MoneyReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

public function myReportView(Request $request)
{
    $userId = Auth::id();
    
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    $query = DB::table('transactions as t')
        ->join('projects as p', 't.project_id', '=', 'p.project_id') 
        ->join('money_receipts as m', 'm.mr_id', '=', 't.reference_id')
        ->leftJoin('payment_methods as pm', 'm.pay_method_id', '=', 'pm.pay_method_id')
        ->leftJoin('accounts as a', 'a.account_id', '=', 'm.account_id')
        ->leftJoin('users as u', 'u.id', '=', 'm.created_by')
        ->select(
            't.transaction_date',
            'p.project_title',
            'm.mr_no','m.selected_months','m.mobile_account_no','m.bank_name',
            'pm.pay_method_name',
            'a.account_no','a.account_name',   
            't.transaction_amount','u.name'
        )
        ->where('t.member_id', $userId) 
        ->where('m.receipt_type', 1) 
        ->orderBy('t.transaction_date', 'asc');

    if ($from && $to) {
        $query->whereBetween('t.transaction_date', [$from, $to]);
    }

    $reportData = $query->get();
    $abouts = About::first();
    return view('admin.pages.mytransaction.myreportview', [
        'reportData' => $reportData,
        'from' => $request->from_date, 
        'to' => $request->to_date,
        'abouts' => $abouts
    ]);
}
   
}
