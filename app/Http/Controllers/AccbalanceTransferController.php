<?php

namespace App\Http\Controllers;

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
        $data['transferlist'] = AccBalanceTransfer::with('fromProject','toProject')->get();
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

    function store(Request $request)
    {
        //dd($request->all());
        try {
            $validate = Validator::make($request->all(), [
                'from_account'       => 'required',
                'to_account'         => 'required',
                'transfer_date'      => 'required',
                'transfer_amount'    => 'required',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            $transferDate = Carbon::createFromFormat('d/m/Y', $request->transfer_date)->format('Y-m-d');
            $fiscalYear = getFiscalYearFromDate($transferDate);
           
            $transfer = new AccBalanceTransfer();
            
            do {
            $transferNo = 'OVIJ' . rand(1111, 9999) . date('Ymd');
            } while (AccBalanceTransfer::where('transfer_no', $transferNo)->exists());

            $transfer->transfer_no       = $transferNo;
            $transfer->from_account      = $request->from_account;
            $transfer->to_account        = $request->to_account;
            $transfer->fiscal_year       = $fiscalYear;
            $transfer->transfer_date     = $transferDate;
            $transfer->transfer_amount   = $request->transfer_amount;
            $transfer->transfer_remarks  = $request->transfer_remarks;
            $transfer->created_by        = Auth::id();
            $transfer->transfer_status   = $request->status ? $request->status : 0;

            if ($transfer->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successful.";
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

    function edit($id)
    {
        $data = array();
        $data['menu'] = "Transfer";
        $data['submenu'] = "list-Transfer";
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
}
