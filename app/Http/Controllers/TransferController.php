<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Project;
use App\Models\FiscalYear;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
USE DB;

class TransferController extends Controller
{
    public function index()
    {
        $data['transferlist'] = Transfer::with('fromProject','toProject')->get();
        return view('admin.pages.transfer.index', $data);
    }

    function create()
    {
        $data = array();
        $data['fiscalyears'] = FiscalYear::where('status',1)->get();
        $data['projects'] = Project::where('status', 1)->get();
        return view('admin.pages.transfer.create', $data);
    }

    function store(Request $request)
    {
        //dd($request->all());
        try {
            $validate = Validator::make($request->all(), [
                'project_id'         => 'required',
                'to_project'       => 'required',
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
           
            $transfer = new Transfer();
            
            do {
            $transferNo = 'OVIJ' . rand(1111, 9999) . date('Ymd');
            } while (Transfer::where('transfer_no', $transferNo)->exists());

            $transfer->transfer_no       = $transferNo;
            $transfer->from_project      = $request->project_id;
            $transfer->to_project        = $request->to_project;
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
        $data['transferEdit'] = Transfer::findOrFail($id);
        return view('admin.pages.transfer.edit', $data);
    }

    function update(Request $request,$id){
         try {
             
            $validate = Validator::make($request->all(), [
                'from_project'      => 'required',
                'to_project'        => 'required',
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
           
            $transfer = Transfer::find($id);

            $transfer->from_project      = $request->from_project;
            $transfer->to_project        = $request->to_project;
            $transfer->fiscal_year       = $fiscalYear;
            $transfer->transfer_date     = $transferDate;
            $transfer->transfer_amount    = $request->transfer_amount;
            $transfer->transfer_remarks   = $request->transfer_remarks;
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
        $transfer = Transfer::findOrFail($id);
        $transfer->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }

    function transferPreview($id){
       $data['invoiceInfo'] = Transfer::with(['fromProject','toProject'])->findOrFail($id);
        return view('admin.pages.transfer.invoice', $data);
    }

    function transferPendinglist(){
        $data['transfers'] = Transfer::with(['fromProject','toProject'])
        ->orderBy('transfer_id', 'desc')->where('transfer_status', '0')->get();
        return view('admin.pages.transfer.transferpendinglist',$data);
    }

    function transferapprove(Request $request){
        DB::beginTransaction();

    try {
        $transferFrom = Transfer::findOrFail($request->id);
        $projectLedger = Ledger::where('project_id',$transferFrom->from_project)->first();

        // ✅ Check balance
        if ($projectLedger->ledger_amount < $transferFrom->transfer_amount) {
            return response()->json([
                'error' => 'Insufficient Balance!',
                'message' => 'From Project ledger does not have enough balance to transfer.'
            ], 422); 
        }

        // Insert into transactions table for From project
        DB::table('transactions')->insert([
            'transaction_date'     => $transferFrom->transfer_date,
            'fiscal_year'          => $transferFrom->fiscal_year,
            'project_id'           => $transferFrom->from_project,
            'transaction_type'     => -2, 
            'transaction_amount'   => $transferFrom->transfer_amount,
            'reference_type'       => 'transfer from',
            'reference_id'         => $transferFrom->transfer_id, 
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
        ]);

        // Insert into transactions table for To project
        DB::table('transactions')->insert([
            'transaction_date'     => $transferFrom->transfer_date,
            'fiscal_year'          => $transferFrom->fiscal_year,
            'project_id'           => $transferFrom->to_project,
            'transaction_type'     => 2, 
            'transaction_amount'   => $transferFrom->transfer_amount,
            'reference_type'       => 'transfer To',
            'reference_id'         => $transferFrom->transfer_id, 
            'transaction_added_by' => Auth::id(),
            'transaction_added_on' => now(),
        ]);


        // Update money_receipts status
        $transferFrom->update([
            'transfer_status' => 1
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

public function transferDecline(Request $request)
{
    try {
        $transfer = Transfer::findOrFail($request->id);

        $transfer->update([
            'transfer_status' => -1,
            'decline_remarks' => $request->remarks
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
        $transfer = Transfer::find($id);

        if ($transfer) {
            return response()->json($transfer);
        }

        return response()->json(['error' => 'Transfer not found'], 404);
    }

}
