<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FiscalYear;
use App\Models\Account;
use App\Models\Project;
use App\Models\FalseReceipt;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;

class FalseReceiptController extends Controller
{
     function index()
    {
        $data['falsereceipts'] = FalseReceipt::with(['project','paymentmethod'])->orderBy('fls_receipt_id', 'desc')->get();
        return view('admin.pages.falsereceipt.index', $data);
    }

    public function create()
    {
        $data['categoris'] = Category::where('status',1)->get();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        return view('admin.pages.falsereceipt.create', $data);
    }

    function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'payment_date'      => 'required',
                'donar_name'        => 'required|Max:250',
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
           
            $falsereceipt = new FalseReceipt();

            $prefix = 'OVJDR';
            $currentYear = date('y');  
            $currentMonth = date('m'); 

            $lastReceipt = FalseReceipt::where('fls_receipt_no', 'LIKE', "$prefix-$currentYear%")
                            ->orderBy('fls_receipt_id', 'desc')
                            ->first();

            if ($lastReceipt) {
                $lastNumber = intval(substr($lastReceipt->fls_receipt_no, -3));
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            $mrNo = "$prefix$currentYear{$currentMonth}{$newNumber}";

            while (FalseReceipt::where('fls_receipt_no', $mrNo)->exists()) {
                $newNumber = str_pad(intval($newNumber) + 1, 3, '0', STR_PAD_LEFT);
                $mrNo = "$prefix{$currentMonth}{$currentYear}{$newNumber}";
            }

            $falsereceipt->fls_receipt_no       = $mrNo;
            $falsereceipt->project_id           = $request->project_id;
            $falsereceipt->fiscal_year          = $fiscalYear;
            $falsereceipt->fls_receipt_date     = $paymentDate;
            $falsereceipt->account_id           = $request->account_id;
            $falsereceipt->donar_name           = $request->donar_name;
            $falsereceipt->fls_receipt_amount   = $request->payment_amount;
            $falsereceipt->pay_method_id        = $request->pay_method_id;
            $falsereceipt->bank_account_no      = $request->bank_account_no;
            $falsereceipt->mobile_account_no    = $request->mobile_account_no;
            $falsereceipt->bank_name            = $request->bank_name;
            $falsereceipt->transaction_no       = $request->transaction_no;
            $falsereceipt->remarks              = $request->payment_remarks;
            $falsereceipt->created_by           = Auth::id();
            $falsereceipt->operation_ip         = $request->ip();
            $falsereceipt->posting_type         = $request->posting_type ? $request->posting_type : 1;

            if ($falsereceipt->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
                $data['falsereceipt'] = $falsereceipt;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['falsereceipt'] = $falsereceipt;
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
        $data['accounts'] = Account::where('status', 1)->get();
        $data['memberlist'] = User::where(['status' => 1,'role' => '3'])->get();
        $data['paymentmethod'] = PaymentMethod::where('status', 1)->get();
        $data['projects'] = Project::where('status', 1)->get();
        $data['falsereceiptEdit'] = FalseReceipt::findOrFail($id);
        return view('admin.pages.falsereceipt.edit', $data);
    }

    function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'payment_date'      => 'required',
                'donar_name'        => 'required|Max:250',
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
           
            $falsereceipt = FalseReceipt::findOrFail($id);

            $falsereceipt->project_id           = $request->project_id;
            $falsereceipt->fiscal_year          = $fiscalYear;
            $falsereceipt->fls_receipt_date     = $paymentDate;
            $falsereceipt->account_id           = $request->account_id;
            $falsereceipt->donar_name           = $request->donar_name;
            $falsereceipt->fls_receipt_amount   = $request->payment_amount;
            $falsereceipt->pay_method_id        = $request->pay_method_id;
            $falsereceipt->bank_account_no      = $request->bank_account_no;
            $falsereceipt->mobile_account_no    = $request->mobile_account_no;
            $falsereceipt->bank_name            = $request->bank_name;
            $falsereceipt->transaction_no       = $request->transaction_no;
            $falsereceipt->remarks              = $request->payment_remarks;
            $falsereceipt->updated_by           = Auth::id();
            $falsereceipt->updated_at           = now();
            $falsereceipt->operation_ip         = $request->ip();
            $falsereceipt->posting_type         = $request->posting_type ? $request->posting_type : 1;

            if ($falsereceipt->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
                $data['moneyreceipt'] = $falsereceipt;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['moneyreceipt'] = $falsereceipt;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    function show($id){
        $data['invoiceInfo'] = FalseReceipt::with(['paymentmethod','project'])->findOrFail($id);
        return view('admin.pages.falsereceipt.falseinvoice', $data);
    }

    function destroy($id){
        $falseReceipt = FalseReceipt::findOrFail($id);
        $falseReceipt->delete();
        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);
    }
}
