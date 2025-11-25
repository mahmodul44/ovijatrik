<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FiscalYear;
use App\Models\Project;
use App\Models\Account;
use App\Models\MoneyReceipt;
use App\Models\FalseReceipt;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;

class MemberReceiptController extends Controller
{
    public function index()
    {
    $data['moneyreceipts'] = MoneyReceipt::select(
            'money_receipts.*',
            'users.name as member_name',
            'users.phone_no as member_phone','users.member_id as memberID','projects.project_title'
        )
        ->leftjoin('users', 'users.id', '=', 'money_receipts.member_id')
        ->leftjoin('projects', 'projects.project_id', '=', 'money_receipts.project_id')
        ->where('money_receipts.receipt_type',1)
        ->orderBy('money_receipts.mr_id', 'desc')
        ->get();

        return view('admin.pages.memberreceipt.index', $data);
    }

    public function create()
    {
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        return view('admin.pages.memberreceipt.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'payment_date'      => 'required',
                'payment_amount'    => 'required',
                'member_id'         => 'required',
                'account_id'        => 'required',
                'months'            => 'required|array',
                'pay_method_id'     => 'required',
                'bank_name'         => 'nullable|Max:100',
                'bank_account_no'   => 'nullable|Max:50',
                'mobile_account_no' => 'nullable|Max:15',
                'transaction_no'    => 'nullable|Max:100',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            $paymentDate = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($paymentDate);
           
            $moneyreceipt = new MoneyReceipt();
            
            $prefix = 'OVJMD';
            $yearMonth = date('ym'); 

            $lastReceipt = MoneyReceipt::where('mr_no', 'LIKE', "$prefix-$yearMonth%")
                            ->where('receipt_type', 1)
                            ->orderBy('mr_id', 'desc')
                            ->first();

            if ($lastReceipt) {
                $lastNumber = intval(substr($lastReceipt->mr_no, -3));
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            $mrNo = "$prefix-$yearMonth$newNumber";

            while (MoneyReceipt::where('mr_no', $mrNo)->exists()) {
                $newNumber = str_pad(intval($newNumber) + 1, 3, '0', STR_PAD_LEFT);
                $mrNo = "$prefix-$yearMonth$newNumber";
            }
            // do {
            // $mrNo = 'OVJ' . rand(1111, 9999) . date('Ymd');
            // } while (MoneyReceipt::where('mr_no', $mrNo)->exists());

            $moneyreceipt->mr_no             = $mrNo;
            $moneyreceipt->project_id        = '10000001';
            $moneyreceipt->receipt_type      = '1';
            $moneyreceipt->fiscal_year       = $fiscalYear;
            $moneyreceipt->payment_date      = $paymentDate;
            $moneyreceipt->selected_months   = json_encode($request->months);
            $moneyreceipt->member_id         = $request->member_id;
            $moneyreceipt->payment_amount    = $request->payment_amount;
            $moneyreceipt->account_id        = $request->account_id;
            $moneyreceipt->pay_method_id        = $request->pay_method_id;
            $moneyreceipt->bank_account_no      = $request->bank_account_no;
            $moneyreceipt->mobile_account_no    = $request->mobile_account_no;
            $moneyreceipt->bank_name            = $request->bank_name;
            $moneyreceipt->transaction_no       = $request->transaction_no;
            $moneyreceipt->payment_remarks   = $request->payment_remarks;
            $moneyreceipt->created_by        = Auth::id();
            $moneyreceipt->status            = $request->status ? $request->status : 0;

            if ($moneyreceipt->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
                $data['moneyreceipt'] = $moneyreceipt;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['moneyreceipt'] = $moneyreceipt;
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
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['invoiceInfo'] = MoneyReceipt::findOrFail($id);
        return view('admin.pages.memberreceipt.edit', $data);
    }

    function update(Request $request,$id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'payment_date'      => 'required',
                'payment_amount'    => 'required',
                'member_id'         => 'required',
                'account_id'        => 'required',
                'months'            => 'required|array',
                'pay_method_id'     => 'required',
                'bank_name'         => 'nullable|Max:100',
                'bank_account_no'   => 'nullable|Max:50',
                'mobile_account_no' => 'nullable|Max:15',
                'transaction_no'    => 'nullable|Max:100',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            $paymentDate = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($paymentDate);
           
            $moneyreceipt = MoneyReceipt::find($id);
            
            $moneyreceipt->fiscal_year       = $fiscalYear;
            $moneyreceipt->payment_date      = $paymentDate;
            $moneyreceipt->selected_months   = json_encode($request->months);
            $moneyreceipt->member_id         = $request->member_id;
            $moneyreceipt->payment_amount    = $request->payment_amount;
            $moneyreceipt->account_id        = $request->account_id;
            $moneyreceipt->pay_method_id        = $request->pay_method_id;
            $moneyreceipt->bank_account_no      = $request->bank_account_no;
            $moneyreceipt->mobile_account_no    = $request->mobile_account_no;
            $moneyreceipt->bank_name            = $request->bank_name;
            $moneyreceipt->transaction_no       = $request->transaction_no;
            $moneyreceipt->payment_remarks   = $request->payment_remarks;
            $moneyreceipt->updated_by        = Auth::id();
            $moneyreceipt->status            = $request->status ? $request->status : 0;

            if ($moneyreceipt->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully";
                $data['moneyreceipt'] = $moneyreceipt;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Saved failed! Please try again...";
                $data['moneyreceipt'] = $moneyreceipt;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    function memberSearch(Request $request)
    {
    $search = $request->q;

    $results = User::select('id','member_id', 'name', 'phone_no')
        ->where(['role' => 3, 'status' => 1])
        ->where('name', 'like', "%{$search}%")
        ->orWhere('member_id', 'like', "%{$search}%")
        ->orWhere('phone_no', 'like', "%{$search}%")
        ->limit(10)
        ->get();

        $formatted = [];

        foreach ($results as $user) {
            $formatted[] = [
                'id' => $user->id,
                'text' => "{$user->member_id} - {$user->name} ({$user->phone_no})"
            ];
        }

        return response()->json($formatted);
    }

    function invoiceDownload($id){
        $data['invoiceInfo'] = MoneyReceipt::with(['member','paymentmethod','project'])->findOrFail($id);
        return view('admin.pages.memberreceipt.invoice', $data);
    }

    function memberreceiptpendingList (){
        $data['receipts'] = MoneyReceipt::select(
            'money_receipts.*',
            'users.name as member_name',
            'users.phone_no as member_phone','users.member_id as memberID','projects.project_title', 'accounts.account_name',
        'accounts.account_no'
        )
        ->leftjoin('users', 'users.id', '=', 'money_receipts.member_id')
        ->leftjoin('projects', 'projects.project_id', '=', 'money_receipts.project_id')
        ->leftJoin('accounts','accounts.account_id','=','money_receipts.account_id')
        ->orderBy('money_receipts.mr_id', 'desc')->where('money_receipts.receipt_type', '1')->where('money_receipts.status', '0')->get();
       return view('admin.pages.memberreceipt.memberreceiptpendinglist',$data);
    }

public function memberreceiptApprove(Request $request)
{
    DB::beginTransaction();

    try {
        $moneyReceipt = MoneyReceipt::findOrFail($request->id);

        // Insert into transactions table
      DB::table('transactions')->insert([
            'transaction_date'     => $moneyReceipt->payment_date,
            'fiscal_year'          => $moneyReceipt->fiscal_year,
            'member_id'            => $moneyReceipt->member_id,
            'project_id'           => $moneyReceipt->project_id,
            'account_id'           => $moneyReceipt->account_id,
            'transaction_type'     => '1', 
            'transaction_amount'   => $moneyReceipt->payment_amount,
            'reference_id'         => $moneyReceipt->mr_id, 
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
            'operation_ip'         => $request->ip()
        ]);

         if ($moneyReceipt->project_id) {
            DB::table('projects')
                ->where('project_id', $moneyReceipt->project_id)
                ->increment('collection_amount', $moneyReceipt->payment_amount);
        }

        // Update money_receipts status
        $moneyReceipt->update([
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

public function memberreceiptDecline(Request $request)
{
    $request->validate([
        'id' => 'required|exists:money_receipts,mr_id',
        'remarks' => 'required|string|max:255',
    ]);

    try {
        $moneyReceipt = MoneyReceipt::findOrFail($request->id);

        $moneyReceipt->update([
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

public function getFiscalInfo($id)
{
    $member = User::find($id);

    if (!$member) {
        return response()->json(['message' => 'Member not found'], 404);
    }

    $currfiscalYear = getFiscalYearFromDate(date('Y-m-d'));  
    list($startYear, $endYear) = explode('-', $currfiscalYear);

    $fiscalYearStart = $startYear . '-07-01';  
    $fiscalYearEnd   = $endYear . '-06-30';

    $monthlyAmount = $member->monthly_donate ?? 0;

    $donatedAmount = MoneyReceipt::where('member_id', $id)
        ->whereBetween('payment_date', [$fiscalYearStart, $fiscalYearEnd])
        ->where('status',1)
        ->sum('payment_amount');
    
     $previousMonths = MoneyReceipt::where('member_id', $id)
        ->whereBetween('payment_date', [$fiscalYearStart, $fiscalYearEnd])
        ->where('status', 1)
        ->pluck('selected_months') 
        ->toArray();
        
    $paidMonths = [];
    foreach ($previousMonths as $pm) {
        $m = json_decode($pm, true); 
        if (is_array($m)) {
            $paidMonths = array_merge($paidMonths, $m);
        }
    }

    $paidMonths = array_unique($paidMonths);    

    $totalDue = ($monthlyAmount * 12) - $donatedAmount;

    return response()->json([
        'fiscal_year'    => "July {$startYear} - June {$endYear}",
        'fiscal_start'   => $fiscalYearStart,
        'fiscal_end'     => $fiscalYearEnd,
        'monthly_amount' => $monthlyAmount,
        'donated_amount' => $donatedAmount,
        'paid_months'    => $paidMonths,
        'due_amount'     => $totalDue,
    ]);
}

function destroy($id){
    $memberreceipt = MoneyReceipt::findOrFail($id);
    $memberreceipt->delete();

    return response()->json(['success' => true, 'message' => 'Deleted successfully']);
}


}
