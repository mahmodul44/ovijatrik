<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\FiscalYear;
use Illuminate\Http\Request;
use App\Models\AccBalanceTransfer;
use App\Models\Account;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;

class AccbalanceTransferController extends Controller
{
    public function index()
    {
        $data['transferlist'] = AccBalanceTransfer::with('fromAccount','toAccount')->where('transfer_status', 1) 
        ->orderBy('acc_transfer_id', 'desc')->get();
        return view('admin.pages.accbalancetransfer.index', $data);
    }

    function create()
    {
        $data = array();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['projects'] = Project::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        return view('admin.pages.accbalancetransfer.create', $data);
    }

    public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'from_account'    => 'required|integer',
            'to_account'      => 'required|integer|different:from_account',
            'transfer_date'   => 'required',
            'transfer_amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed!',
                'errors'  => $validator->errors(),
            ], 400);
        }

        // ================= DATE & FISCAL YEAR =================
        $transferDate = Carbon::createFromFormat('d/m/Y', $request->transfer_date)->format('Y-m-d');
        $fiscalYear   = getFiscalYearFromDate($transferDate);

        // ================= LOCK ACCOUNTS =================
        $fromAccount = DB::table('accounts')
            ->where('account_id', $request->from_account)
            ->lockForUpdate()
            ->first();

        $toAccount = DB::table('accounts')
            ->where('account_id', $request->to_account)
            ->lockForUpdate()
            ->first();

        if (!$fromAccount || !$toAccount) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Invalid account selected!',
            ], 400);
        }

        if ($fromAccount->current_balance < $request->transfer_amount) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Insufficient balance in From Account!',
            ], 400);
        }

        do {
            $transferNo = 'OVIJ' . rand(111, 999) . date('y');
        } while (
            AccBalanceTransfer::where('acc_transfer_no', $transferNo)->exists()
        );

        $transfer = new AccBalanceTransfer();
        $transfer->acc_transfer_no    = $transferNo;
        $transfer->from_account       = $request->from_account;
        $transfer->to_account         = $request->to_account;
        $transfer->fiscal_year        = $fiscalYear;
        $transfer->acc_transfer_date  = $transferDate;
        $transfer->transfer_amount    = $request->transfer_amount;
        $transfer->transfer_remarks   = $request->transfer_remarks;
        $transfer->created_by         = Auth::id();
        $transfer->transfer_status    = $request->status ?? 1;
        $transfer->save();

        $generatedId = $transfer->acc_transfer_id;
       
        $fromNewBalance = $fromAccount->current_balance - $request->transfer_amount;
        $toNewBalance   = $toAccount->current_balance + $request->transfer_amount;

        DB::table('transactions')->insert([
            [
                'reference_type'       => 'acc_balance_transfers',
                'reference_id'         => $generatedId,
                'fiscal_year'          => $fiscalYear,
                'account_id'           => $request->from_account,
                'transaction_type'     => -5,
                'transaction_amount'   => $request->transfer_amount,
                'transaction_date'     => $transferDate,
                'pay_method_id'        => 101,
                'transaction_added_by' => Auth::id(),
                'transaction_added_on' => now(),
            ],
            [
                'reference_type'       => 'acc_balance_transfers',
                'reference_id'         => $generatedId,
                'fiscal_year'          => $fiscalYear,
                'account_id'           => $request->to_account,
                'transaction_type'     => 5,
                'transaction_amount'   => $request->transfer_amount,
                'transaction_date'     => $transferDate,
                'pay_method_id'        => 101,
                'transaction_added_by' => Auth::id(),
                'transaction_added_on' => now(),
            ],
        ]);

        DB::table('accounts')
            ->where('account_id', $request->from_account)
            ->update(['current_balance' => $fromNewBalance]);

        DB::table('accounts')
            ->where('account_id', $request->to_account)
            ->update(['current_balance' => $toNewBalance]);

        DB::commit();

        return response()->json([
            'status'   => true,
            'message'  => 'Balance transfer successful!',
            'transfer' => $transfer,
        ], 200);

    } catch (\Throwable $th) {

        DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong!',
            'error'   => $th->getMessage(),
        ], 500);
    }
}

    function edit($id)
    {
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['projects'] = Project::where('status', 1)->get();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['transferEdit'] = AccBalanceTransfer::findOrFail($id);
        return view('admin.pages.accbalancetransfer.edit', $data);
    }

    function update(Request $request,$id){
         try {
             
            $validate = Validator::make($request->all(), [
                'from_account'      => 'required',
                'to_account'        => 'required',
                'transfer_date'     => 'required',
                'transfer_amount'   => 'required',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            $transferDate = Carbon::createFromFormat('d/m/Y', $request->transfer_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($transferDate);
           
            $transfer = AccBalanceTransfer::find($id);

            $transfer->from_account      = $request->from_account;
            $transfer->to_account        = $request->to_account;
            $transfer->fiscal_year       = $fiscalYear;
            $transfer->transfer_date     = $transferDate;
            $transfer->transfer_amount   = $request->transfer_amount;
            $transfer->transfer_remarks  = $request->transfer_remarks;
            $transfer->updated_by        = Auth::id();
            $transfer->transfer_status   = $request->transfer_status ? $request->transfer_status : 0;

            if ($transfer->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
                $data['transfer'] = $transfer;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['transfer'] = $transfer;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    function destroy($id){
        $transfer = AccBalanceTransfer::findOrFail($id);
        $transfer->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }

    public function show($id)
    {
        $data['abouts'] = About::first();
        $data['accounts'] = Account::where('status', 1)->get();
        $data['transferPreview'] = AccBalanceTransfer::findOrFail($id);
        return view('admin.pages.accbalancetransfer.show', $data);
    }
}
