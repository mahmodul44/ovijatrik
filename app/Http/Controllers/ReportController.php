<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\About;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Project;
use App\Models\MoneyReceipt;
use Illuminate\Http\Request;

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
        ->leftJoin('users as receipt_users', 'receipt_users.id', '=', 'money_receipts.member_id')
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
        'expenses.*','money_receipts.mr_no','money_receipts.donar_name','expense_categories.expense_cat_name',
        'projects.project_title','projects.project_code','projects.target_amount',
        'projects.collection_amount','projects.total_expense', DB::raw("
            CASE 
                WHEN money_receipts.member_id IS NOT NULL 
                THEN receipt_users.name
                ELSE money_receipts.donar_name
            END as receipt_donor_name
        ")
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

function paymethodWise(){
     $data['projects'] = Project::where('status',1)->where('project_id','!=','10000001')->get();
     $data['accounts'] = Account::where('status', 1)->get();
     return view('admin.pages.report.paymethod-wise', $data);
}

function paymethodWiseReport(Request $request) {
    $accountId = $request->account_id;
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;
    
    if (!$accountId) {
        return back()->with('error', 'Please select a Account');
    }
    $accountName = Account::findOrFail($accountId);
    $query = DB::table('transactions')
    ->leftJoin('projects', 'projects.project_id', '=', 'transactions.project_id')
    ->leftJoin('accounts','accounts.account_id','=','transactions.account_id')
    ->leftJoin('users','users.id','=','transactions.member_id')
    ->leftJoin('money_receipts','money_receipts.mr_id','=','transactions.reference_id')
 
    ->leftJoin('expenses','expenses.expense_id','=','transactions.reference_id') 
    ->leftJoin('expense_categories as ec','ec.expense_cat_id','=','expenses.expense_cat_id') 
    ->leftJoin('salaries', 'salaries.salary_id', '=', 'transactions.reference_id') 
    ->leftJoin('acc_balance_transfers as transfers', 'transfers.acc_transfer_id', '=', 'transactions.reference_id')
    ->leftJoin('users as us','us.id','=','transactions.transaction_added_by')
    ->select(
        'transactions.transaction_date',
        'transactions.transaction_type',
        'transactions.reference_type',
        'transactions.transaction_amount',
        'users.name as member_name',
        'us.name as creator_name',
        'projects.project_title',
        'money_receipts.mr_no',
        'money_receipts.donar_name',
        'expenses.expense_no', 
        'expenses.expense_remarks','ec.expense_cat_name',
        'salaries.salary_no','salaries.salary_month','salaries.salary_year','transfers.acc_transfer_no'
    )
    ->orderBy('transactions.transaction_date', 'asc');

    $query->where('transactions.account_id', $accountId);

    if ($from && $to) {
        $query->whereBetween('transactions.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transactions.transaction_date', '>=', $from);
    } elseif ($to) {
        $query->where('transactions.transaction_date', '<=', $to);
    }

    $reportData = $query->get();

    return view('admin.pages.report.paymethod-wise-report', [
        'reportData'  => $reportData,
        'accountId'   => $accountId,
        'accountName' => $accountName,
        'from'        => $from,
        'to'          => $to
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

function fiscalyearmemberWise(){
     return view('admin.pages.report.fiscalyrmember-wise');
}

public function fiscalYearMemberWiseReport(Request $request) {
    $fiscalYear = $request->fiscal_year;
    [$startYear, $endYear] = explode('-', $fiscalYear);

    $months = [
        "$startYear-07", "$startYear-08", "$startYear-09", "$startYear-10", "$startYear-11", "$startYear-12",
        "$endYear-01", "$endYear-02", "$endYear-03", "$endYear-04", "$endYear-05", "$endYear-06"
    ];

    $members = User::whereNotNull('member_id')
                   ->where('member_id', '!=', '0')
                   ->get();

    $activities = MoneyReceipt::where('fiscal_year', $fiscalYear)->get();

    $reportData = [];
    foreach ($members as $member) {
        $row = [
            'id'            => $member->member_id,
            'name'          => $member->name,
            'phone'         => $member->phone_no,
            'monthly_donate'=> $member->monthly_donate,
            'individual_total' => 0, 
            'payments'      => array_fill_keys($months, 0) 
        ];

        $memberActivities = $activities->where('member_id', $member->id);

        foreach ($memberActivities as $activity) {
            $selectedMonths = json_decode($activity->selected_months, true);
            $totalPayment = $activity->payment_amount;

            if (is_array($selectedMonths) && count($selectedMonths) > 0) {

                $amountPerMonth = $totalPayment / count($selectedMonths);

                foreach ($selectedMonths as $mKey) {
                  
                    if (array_key_exists($mKey, $row['payments'])) {
                        $row['payments'][$mKey] += $amountPerMonth;
                        $row['individual_total'] += $amountPerMonth;
                    }
                }
            }
        }
        
        $reportData[] = $row;
    }
    $abouts = About::first();
    return view('admin.pages.report.fiscalyrmember-wise-report', compact('reportData', 'months', 'fiscalYear','abouts'));
}

function fsyrmembertypeWise(){
     return view('admin.pages.report.fsyrmember-type-wise');
}

public function fsyrmembertypeWiseReport(Request $request) {
    $fiscalYear = $request->fiscal_year; 
    [$startYear, $endYear] = explode('-', $fiscalYear);

    $months = [
        "$startYear-07", "$startYear-08", "$startYear-09", "$startYear-10", "$startYear-11", "$startYear-12",
        "$endYear-01", "$endYear-02", "$endYear-03", "$endYear-04", "$endYear-05", "$endYear-06"
    ];

    $members = User::whereNotNull('member_id')->where('member_id', '!=', '0')->get();
    $activities = MoneyReceipt::where('fiscal_year', $fiscalYear)->get();

    $reportData = [];
    $typeMapping = [
        'OBM'  => 'Single Brick',
        'ODBM' => 'Double Brick',
        'OTBM' => 'Triple Brick',
        'OPM'  => 'Single Piller',
        'ODPM' => 'Double Piller'
    ];
    foreach ($members as $member) {
        preg_match('/^[a-zA-Z]+/', $member->member_id, $matches);
        $code = $matches[0] ?? 'Unknown';
        $typeName = $typeMapping[$code] ?? $code;

        if (!isset($reportData[$typeName])) {
            $reportData[$typeName] = [
                'type_name'        => $typeName,
                'total_type_paid'  => 0,
                'payments'         => array_fill_keys($months, 0)
            ];
        }

        $memberActivities = $activities->where('member_id', $member->id);

        foreach ($memberActivities as $activity) {
            $selectedMonths = json_decode($activity->selected_months, true);
            $totalPayment = $activity->payment_amount;

            if (is_array($selectedMonths) && count($selectedMonths) > 0) {
                $amountPerMonth = $totalPayment / count($selectedMonths);

                foreach ($selectedMonths as $mKey) {
                    if (array_key_exists($mKey, $reportData[$typeName]['payments'])) {
                        $reportData[$typeName]['payments'][$mKey] += $amountPerMonth;
                        $reportData[$typeName]['total_type_paid'] += $amountPerMonth;
                    }
                }
            }
        }
    }

    $abouts = About::first();
    ksort($reportData);

    return view('admin.pages.report.fsyrmember-type-wise-info', compact('reportData', 'months', 'fiscalYear', 'abouts'));
}


function fsyrmonthWise(){
     return view('admin.pages.report.month-wise-report');
}

public function fsyrmonthWiseReport(Request $request) {
    $fiscalYear = $request->fiscal_year;
    $month = $request->report_month; 
    
    $yearPart = explode('-', $fiscalYear)[($month >= 7 ? 0 : 1)]; 
    $startDate = Carbon::create($yearPart, $month, 1)->startOfMonth()->format('Y-m-d');
    $endDate = Carbon::create($yearPart, $month, 1)->endOfMonth()->format('Y-m-d');

    $prevIncome = MoneyReceipt::where('payment_date', '<', $startDate)
                    ->whereIn('receipt_type', [1])->sum('payment_amount');
    $prevExpense = Expense::where('expense_date', '<', $startDate)
                    ->whereIn('expense_type', [2])->sum('expense_amount');

    $openingBalance = $prevIncome - $prevExpense;

    $incomeItems = MoneyReceipt::whereBetween('payment_date', [$startDate, $endDate])
                    ->where('receipt_type', 1)->get(); 

    $expenseItems = Expense::with('expcategory')->whereBetween('expense_date', [$startDate, $endDate])
                    ->where('expense_type', 2)->get();
    
    $accountBalances = DB::table('accounts')
        ->select('accounts.account_id', 'accounts.account_name','accounts.account_no', 'accounts.bank_name')
        ->where('accounts.account_type', 1)
        ->get()
        ->map(function ($account) use ($endDate) {
            $totalIn = DB::table('money_receipts')
                ->where('account_id', $account->account_id)
                ->where('payment_date', '<=', $endDate)
                ->where('receipt_type', 1)
                ->sum('payment_amount');

            $totalOut = DB::table('expenses')
                ->where('account_id', $account->account_id)
                ->where('expense_date', '<=', $endDate)
                ->where('expense_type', 2)
                ->sum('expense_amount');

            $transferIn = DB::table('acc_balance_transfers') 
                ->where('to_account', $account->account_id)
                ->where('acc_transfer_date', '<=', $endDate)
                ->sum('transfer_amount');

            $transferOut = DB::table('acc_balance_transfers')
                ->where('from_account', $account->account_id)
                ->where('acc_transfer_date', '<=', $endDate)
                ->sum('transfer_amount');

            $account->calculated_balance = ($totalIn + $transferIn) - ($totalOut + $transferOut);

            return $account;
        })
        ->filter(function ($account) {
            return $account->calculated_balance != 0;
        });

     $abouts = About::first();
    return view('admin.pages.report.month-wise-report-info', compact('openingBalance', 'incomeItems', 'expenseItems', 'fiscalYear', 'month', 'abouts','accountBalances','endDate'));
}

}
