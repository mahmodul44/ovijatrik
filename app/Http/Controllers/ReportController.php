<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\About;
use App\Models\Ledger;
use App\Models\Salary;
use App\Models\Account;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Project;
use App\Models\MoneyReceipt;
use App\Models\ProjectExpenseCategory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function index()
    {
   
        $data['ledgers'] = Ledger::select(
        'project_id',
          DB::raw('SUM(ledger_amount) as total_amount')
         )
         ->whereNotNull('project_id')
        ->with('project')  
        ->groupBy('project_id')
        ->get();

     return view('admin.pages.report.ledger', $data);
   }

   function projectWise(){
     $data['projects'] = Project::where('status',1)->get();
     $data['accounts'] = Account::where('status', 1)->get();
     return view('admin.pages.report.project-wise', $data);
   }

function projectWiseSearch(Request $request)
{
    $request->validate([
        'project_id' => 'required'
    ], [
        'project_id.required' => 'অনুগ্রহ করে একটি প্রজেক্ট সিলেক্ট করুন।'
    ]);

    $projectId = $request->project_id;
    $accountId = $request->account_id; 
    
    $from = $request->from_date ? Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d') : null;
    $to   = $request->to_date   ? Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d') : null;

    $previousBalance = 0;

    if ($from && $projectId) {
        $prevQuery = DB::table('transactions')
            ->where('project_id', $projectId)
            ->where('transaction_date', '<', $from);
            
        if ($accountId) {
            $prevQuery->where('account_id', $accountId);
        }

        $previousTransactions = $prevQuery->get();

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
        ->where('transactions.project_id', $projectId) 
        ->orderBy('transactions.transaction_date', 'asc')
        ->select(
            'transactions.*',
            'accounts.account_name', 'accounts.account_no', 'accounts.bank_name',
            'users.name as member_name','users.member_id as memberID',
            'expenses.expense_no','money_receipts.mr_no','money_receipts.donar_name','expense_categories.expense_cat_name',
            'projects.project_title','projects.project_code',
            DB::raw("CASE WHEN money_receipts.member_id IS NOT NULL THEN receipt_users.name ELSE money_receipts.donar_name END as receipt_donor_name")
        );

    if ($accountId) {
        $query->where('transactions.account_id', $accountId);
    }

    if ($from && $to) {
        $query->whereBetween('transactions.transaction_date', [$from, $to]);
    } elseif ($from) {
        $query->where('transactions.transaction_date', '>=', $from);
    }

    $reportData = $query->get();

    $projectInfo = DB::table('projects')->where('project_id', $projectId)->first();
    $accountInfo = $accountId ? DB::table('accounts')->where('account_id', $accountId)->first() : null;
    $abouts = About::first();
    return view('admin.pages.report.project-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'projectId' => $projectId,
        'projectInfo' => $projectInfo,
        'accountInfo' => $accountInfo,
        'previousBalance' => $previousBalance,
        'abouts' => $abouts
    ]);
}

function memberWise(){
     $data['members'] = User::where(['status' =>1 , 'role' => 3])->get();
     $data['accounts'] = Account::where('status', 1)->where('account_type', 1)->get();
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
            'accounts.account_name','accounts.bank_name',
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
     $abouts = About::first();
    return view('admin.pages.report.member-wise-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'memberId' => $memberId,
        'memberName' => $memberName,
        'abouts' => $abouts
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
    ->leftJoin('accounts as from_acc', 'from_acc.account_id', '=', 'transfers.from_account')
    ->leftJoin('accounts as to_acc', 'to_acc.account_id', '=', 'transfers.to_account')
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
        'salaries.salary_no','salaries.salary_month','salaries.salary_year',
        'transfers.acc_transfer_no',
        DB::raw("CONCAT(from_acc.bank_name, ' (', from_acc.account_no, ')') as from_account_info"),
        DB::raw("CONCAT(to_acc.bank_name, ' (', to_acc.account_no, ')') as to_account_info")
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
    $abouts = About::first();
    return view('admin.pages.report.paymethod-wise-report', [
        'reportData'  => $reportData,
        'accountId'   => $accountId,
        'accountName' => $accountName,
        'from'        => $from,
        'to'          => $to,
        'abouts'      => $abouts
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
            'accounts.bank_name',
            'accounts.account_no',
            'users.name as member_name','users.member_id',
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
    $abouts = About::first();
    return view('admin.pages.report.date-wise-account-view', [
        'reportData' => $reportData,
        'from' => $from,
        'to' => $to,
        'projectId' => $projectId,
        'projectInfo' => $projectInfo,
        'previousBalance' => 0,
        'abouts' => $abouts
    ]);
}

function fiscalyearmemberWise(){
     return view('admin.pages.report.fiscalyrmember-wise');
}

public function fiscalYearMemberWiseReport(Request $request) {
    $fiscalYear = $request->fiscal_year;
    $memberID   = $request->member_id;
    [$startYear, $endYear] = explode('-', $fiscalYear);

    $months = [
        "$startYear-07", "$startYear-08", "$startYear-09", "$startYear-10", "$startYear-11", "$startYear-12",
        "$endYear-01", "$endYear-02", "$endYear-03", "$endYear-04", "$endYear-05", "$endYear-06"
    ];

    $members = User::whereNotNull('member_id')
                    ->where('member_id', '!=', '0')
                    ->when($memberID, function ($query) use ($memberID) {
                        return $query->where('id', $memberID);
                    })
                    ->get()
                    ->sortBy('member_id', SORT_NATURAL);

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

function fiscalyearmemberWiseDue(){
     return view('admin.pages.report.fymember-wise-due');
}

public function fiscalyearmemberWiseDueReport(Request $request) {
    $fiscalYear = $request->fiscal_year; 
    $memberID   = $request->member_id;
    [$startYear, $endYear] = explode('-', $fiscalYear);

    $allMonths = [
        "$startYear-07", "$startYear-08", "$startYear-09", "$startYear-10", "$startYear-11", "$startYear-12",
        "$endYear-01", "$endYear-02", "$endYear-03", "$endYear-04", "$endYear-05", "$endYear-06"
    ];

    $currentMonth = date('Y-m');

    $months = array_values(array_filter($allMonths, function($m) use ($currentMonth) {
        return strcmp($m, $currentMonth) <= 0;
    }));

    $members = User::whereNotNull('member_id')
                    ->where('member_id', '!=', '0')
                    ->when($memberID, function ($query) use ($memberID) {
                        return $query->where('id', $memberID);
                    })
                    ->get()
                    ->sortBy('member_id', SORT_NATURAL);

    $activities = MoneyReceipt::where('fiscal_year', $fiscalYear)->get();

    $reportData = [];
    $totalElapsedMonths = count($months);

    foreach ($members as $member) {
        $row = [
            'id'             => $member->member_id,
            'name'           => $member->name,
            'phone'          => $member->phone_no,
            'monthly_donate' => $member->monthly_donate,
            'individual_total' => 0, 
            'total_due'      => 0,
            'due_months_count' => 0,
            'payments'       => array_fill_keys($months, 0) 
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

        $paidCount = 0;
        foreach ($months as $mKey) {
            if ($row['payments'][$mKey] >= $member->monthly_donate && $member->monthly_donate > 0) {
                $paidCount++;
            }
        }

        $expectedTotalTillNow = $totalElapsedMonths * $member->monthly_donate;
        $row['total_due'] = max(0, $expectedTotalTillNow - $row['individual_total']);
        $row['due_months_count'] = $totalElapsedMonths - $paidCount;
        
        $reportData[] = $row;
    }

    $abouts = About::first();
    return view('admin.pages.report.fymember-wise-due-report', compact('reportData', 'months', 'fiscalYear', 'abouts'));
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

    $typeOrder = [
        'Single Brick',   // OBM
        'Double Brick',   // ODBM
        'Triple Brick',   // OTBM
        'Single Piller',  // OPM
        'Double Piller',  // ODPM
    ];
    $orderedReportData = [];

    foreach ($typeOrder as $typeName) {
        if (isset($reportData[$typeName])) {
            $orderedReportData[$typeName] = $reportData[$typeName];
        }
    }

    // add any unexpected types at the end (optional but safe)
    foreach ($reportData as $key => $value) {
        if (!isset($orderedReportData[$key])) {
            $orderedReportData[$key] = $value;
        }
    }

    $reportData = $orderedReportData;
    //ksort($reportData);

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
    $prevSalary = Salary::where('salary_date', '<', $startDate)->sum('total_salary');
    $openingBalance = $prevIncome - ($prevExpense + $prevSalary);

    $incomeItems = MoneyReceipt::whereBetween('payment_date', [$startDate, $endDate])
                    ->where('receipt_type', 1)->get(); 

    $expenseItems = Expense::with('expcategory')
                    ->selectRaw('expense_cat_id, SUM(expense_amount) as total_amount')
                    ->whereBetween('expense_date', [$startDate, $endDate])
                    ->where('expense_type', 2)->groupBy('expense_cat_id')->get()
                    ->map(function($item) {
                    return [
                        'head_name' => $item->expcategory->expense_cat_name ?? 'Unknown',
                        'totalexp_amount'  => $item->total_amount
                        ];
                    });
    $totalSalary = Salary::whereBetween('salary_date', [$startDate, $endDate]) 
    ->sum('total_salary');

        if ($totalSalary > 0) {
            $expenseItems->push([
                'head_name'          => 'Staff Salary',
                'totalexp_amount'    => $totalSalary
            ]);
        }
    
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

            $totalSalaryOut = DB::table('salaries')
                ->where('account_id', $account->account_id) 
                ->where('salary_date', '<=', $endDate)
                ->sum('total_salary');

            $transferIn = DB::table('acc_balance_transfers') 
                ->where('to_account', $account->account_id)
                ->where('acc_transfer_date', '<=', $endDate)
                ->sum('transfer_amount');

            $transferOut = DB::table('acc_balance_transfers')
                ->where('from_account', $account->account_id)
                ->where('acc_transfer_date', '<=', $endDate)
                ->sum('transfer_amount');

            $account->calculated_balance = ($totalIn + $transferIn) - ($totalOut + $totalSalaryOut + $transferOut);

            return $account;
        })
        ->filter(function ($account) {
            return $account->calculated_balance != 0;
        });

     $abouts = About::first();
    return view('admin.pages.report.month-wise-report-info', compact('openingBalance', 'incomeItems', 'expenseItems', 'fiscalYear', 'month', 'abouts','accountBalances','endDate'));
}

function expenseWise(){
    $data['expensecat'] = ExpenseCategory::where('status',1)->get();
    return view('admin.pages.report.expense-wise-report',$data);
}

public function expenseReportview(Request $request)
{
    $fiscalYear = $request->fiscal_year;
    $month = $request->report_month;
    $expenseCatId = $request->expense_cat_id;

    [$startYear, $endYear] = explode('-', $fiscalYear);
    $startDate = "$startYear-07-01";
    $endDate = "$endYear-06-30";

    $isDetailed = ($month && $expenseCatId);

    $expensesQuery = DB::table('expenses')
        ->select('expense_cat_id', 'expense_amount as amount', 'expense_date','expense_no as invNo')
        ->where('project_id', '10000001')
        ->where('expense_type', 2)
        ->whereBetween('expense_date', [$startDate, $endDate]);

    $salariesQuery = DB::table('salaries')
        ->select(DB::raw("'salary' as expense_cat_id"), 'total_salary as amount', 'salary_date as expense_date','salary_no as invNo')
        ->where('project_id', '10000001')
        ->whereBetween('salary_date', [$startDate, $endDate]);

    if ($month) {
        $expensesQuery->whereMonth('expense_date', $month);
        $salariesQuery->whereMonth('salary_date', $month);
    }

    if ($expenseCatId) {
        if ($expenseCatId === 'salary') {
            $expensesQuery->whereRaw('1 = 0');
        } else {
            $expensesQuery->where('expense_cat_id', $expenseCatId);
            $salariesQuery->whereRaw('1 = 0');
        }
    }

    $combinedData = $expensesQuery->unionAll($salariesQuery);

    $query = DB::table(DB::raw("({$combinedData->toSql()}) as combined"))
        ->mergeBindings($combinedData)
        ->leftJoin('expense_categories', 'combined.expense_cat_id', '=', 'expense_categories.expense_cat_id');

    if ($isDetailed) {
        $reports = $query->select(
            'combined.expense_cat_id',
            'expense_categories.expense_cat_name',
            'combined.amount as total_amount',
            'combined.expense_date','combined.invNo'
        )
        ->orderBy('combined.expense_date', 'asc')
        ->get();
    } else {
        $reports = $query->select(
            'combined.expense_cat_id',
            'expense_categories.expense_cat_name',
            DB::raw('SUM(combined.amount) as total_amount'),
            DB::raw('COUNT(*) as transaction_count')
        )
        ->groupBy('combined.expense_cat_id', 'expense_categories.expense_cat_name')
        ->get();
    }

    $abouts = About::first();
    
    return view('admin.pages.report.expense-wise-report-info', compact('reports', 'fiscalYear', 'month', 'abouts', 'isDetailed'));
}

// membershipt Report 
function membershipAllledger(){
   $data['ledgers'] = Ledger::select(
        'project_id',
          DB::raw('SUM(ledger_amount) as total_amount')
         )
         ->whereNotNull('project_id')
        ->with('project')  
        ->groupBy('project_id')
        ->get();

    $data['membershipAccounts'] = Account::where('account_type', 1)
        ->orderBy('account_id', 'desc')
        ->get(); 

     return view('admin.pages.report.membership-all-ledger', $data); 
}

function headWise(){
    $data['categories'] = Category::where('status',1)->get();
    return view('admin.pages.report.head-wise-report',$data);
}

public function headWiseSearch(Request $request)
{
    $category_id = $request->category_id;
    $fiscal_year = $request->fiscal_year;

    $category = Category::findOrFail($category_id);
    $abouts = DB::table('abouts')->first();

    $reportData = DB::table('projects')
        ->leftJoin('transactions', function ($join) use ($fiscal_year) {
            $join->on('projects.project_id', '=', 'transactions.project_id')
                 ->where('transactions.fiscal_year', $fiscal_year);
        })
        ->select(
            'projects.project_title',
            DB::raw('SUM(CASE WHEN transactions.transaction_type < 0 THEN ABS(transactions.transaction_amount) ELSE 0 END) as total_debit'),
            DB::raw('SUM(CASE WHEN transactions.transaction_type > 0 THEN transactions.transaction_amount ELSE 0 END) as total_credit')
        )
        ->where('projects.category_id', $category_id)
        ->groupBy('projects.project_id', 'projects.project_title')
        ->get();

    return view('admin.pages.report.head-wise-result',
        compact('reportData', 'category', 'fiscal_year', 'abouts')
    );
}

function projectexpenseHead(){
    $data['categories'] = ProjectExpenseCategory::where('status',1)->get();
    return view('admin.pages.report.project-expense-head',$data);
}

public function projectexpenseHeadSearch(Request $request)
{
    $category_id = $request->category_id;
    $fiscal_year = $request->fiscal_year;

    $category = ProjectExpenseCategory::findOrFail($category_id);
    $abouts = DB::table('abouts')->first();

    $reportData = DB::table('expenses')
        ->leftJoin('projects', 'expenses.project_id', '=', 'projects.project_id')
        ->select(
            'projects.project_title',
            DB::raw('SUM(expenses.expense_amount) as total_expense')
        )
        ->where('expenses.project_exp_cat_id', $category_id)
        ->where('expenses.expense_type', 1)
        ->when($fiscal_year, function ($query) use ($fiscal_year) {
            $query->where('expenses.fiscal_year', $fiscal_year);
        })
        ->groupBy('projects.project_id', 'projects.project_title')
        ->get();

    return view('admin.pages.report.project-expense-head-result',
        compact('reportData', 'category', 'fiscal_year', 'abouts')
    );
}

}
