<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FiscalYear;
use App\Models\Account;
use App\Models\Project;
use App\Models\MoneyReceipt;
use App\Models\FalseReceipt;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;


class MoneyReceiptController extends Controller
{
    public function index()
    {
    $data['moneyreceipts'] = MoneyReceipt::select(
            'money_receipts.*',
            'users.name as member_name',
            'users.phone_no as member_phone','projects.project_title'
        )
        ->leftjoin('users', 'users.id', '=', 'money_receipts.member_id')
        ->leftjoin('projects', 'projects.project_id', '=', 'money_receipts.project_id')
        ->orderBy('money_receipts.mr_id', 'desc')
        ->where('money_receipts.receipt_type',2)
        ->get();

        return view('admin.pages.moneyreceipt.index', $data);
    }


    public function create()
    {
        $data['categoris'] = Category::where('status',1)->get();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        return view('admin.pages.moneyreceipt.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'payment_date'      => 'required',
                'payment_amount'    => 'required',
                'account_id'        => 'required',
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
            
            $prefix = 'OVJMR';
            $yearMonth = date('ym'); 

            $lastReceipt = MoneyReceipt::where('mr_no', 'LIKE', "$prefix-$yearMonth%")
                            ->where('receipt_type', 2)
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
            // $mrNo = 'OVIJ' . rand(1111, 9999) . date('Ymd');
            // } while (MoneyReceipt::where('mr_no', $mrNo)->exists());

            $moneyreceipt->mr_no             = $mrNo;
            $moneyreceipt->project_id        = $request->project_id;
            $moneyreceipt->receipt_type      = '2';
            $moneyreceipt->fiscal_year       = $fiscalYear;
            $moneyreceipt->payment_date      = $paymentDate;
            $moneyreceipt->donar_name        = $request->donar_name;
            $moneyreceipt->payment_amount    = $request->payment_amount;
            $moneyreceipt->account_id        = $request->account_id;
            $moneyreceipt->pay_method_id     = $request->pay_method_id;
            $moneyreceipt->bank_account_no   = $request->bank_account_no;
            $moneyreceipt->mobile_account_no = $request->mobile_account_no;
            $moneyreceipt->bank_name         = $request->bank_name;
            $moneyreceipt->transaction_no    = $request->transaction_no;
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

    public function edit($id)
    {
        $data['categoris'] = Category::where('status',1)->get();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['projects'] = Project::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['invoiceInfo'] = MoneyReceipt::findOrFail($id);
        return view('admin.pages.moneyreceipt.edit', $data);
    }

    public function update(Request $request,$id)
    {
        try {
             
            $validate = Validator::make($request->all(), [
                'payment_date'      => 'required',
                'payment_amount'    => 'required',
                'account_id'        => 'required',
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

            $moneyreceipt->project_id        = $request->project_id;
            $moneyreceipt->receipt_type      = '2';
            $moneyreceipt->fiscal_year       = $fiscalYear;
            $moneyreceipt->payment_date      = $paymentDate;
            $moneyreceipt->donar_name        = $request->donar_name;
            $moneyreceipt->payment_amount    = $request->payment_amount;
            $moneyreceipt->account_id        = $request->account_id;
            $moneyreceipt->pay_method_id     = $request->pay_method_id;
            $moneyreceipt->bank_account_no   = $request->bank_account_no;
            $moneyreceipt->mobile_account_no = $request->mobile_account_no;
            $moneyreceipt->bank_name         = $request->bank_name;
            $moneyreceipt->transaction_no    = $request->transaction_no;
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
    return view('admin.pages.moneyreceipt.invoice', $data);
}

function moneyreceiptpendingList (){
  $data['receipts'] = MoneyReceipt::with('paymentmethod')->select(
            'money_receipts.*',
            'users.name as member_name',
            'users.phone_no as member_phone','projects.project_title'
        )
        ->leftjoin('users', 'users.id', '=', 'money_receipts.member_id')
        ->leftjoin('projects', 'projects.project_id', '=', 'money_receipts.project_id')
        ->orderBy('money_receipts.mr_id', 'desc')->where('money_receipts.receipt_type', '2')->where('money_receipts.status', '0')->get();
  return view('admin.pages.moneyreceipt.moneyreceiptpendinglist',$data);
}

public function moneyreceiptApprove(Request $request)
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
            'transaction_type'     => 1, 
            'transaction_amount'   => $moneyReceipt->payment_amount,
            'reference_type'       => 'money_receipt',
            'reference_id'         => $moneyReceipt->mr_id, 
            'pay_method_id'        => $moneyReceipt->pay_method_id,
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
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

public function moneyreceiptDecline(Request $request)
{
   // dd($request->all());
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


    public function show($id)
    {
        $moneyreceipt = MoneyReceipt::with(['project','paymentmethod'])->find($id);

        if ($moneyreceipt) {
            return response()->json($moneyreceipt);
        }

        return response()->json(['error' => 'Money Receipt not found'], 404);
    }

    function destroy($id){
       $moneyreceipt = MoneyReceipt::findOrFail($id);
       $moneyreceipt->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }

}
