<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    function index(){
        $data['accounts'] = Account::orderBy('account_id', 'desc')->get();
         return view('admin.pages.account.index',$data);
    }

    function create()
    {
        return view('admin.pages.account.create');
    }

    function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'account_name'  => 'required|max:50',
                'account_no'    => 'required|max:50',
                'account_type'  => 'required'
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
          
            $account = new Account();
            $account->account_name     = $request->account_name;
            $account->account_no       = $request->account_no;
            $account->account_type     = $request->account_type;
            $account->status           = $request->status ? $request->status : 1;
            $account->bank_name        = $request->bank_name;
            
            if ($account->save()) {
                $data['status'] = true;
                $data['message'] = "Saved Successful.";
                $data['account'] = $account;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save Failed! Please try again...";
                $data['account'] = $account;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    function accountLedger(){
          $membershipAccounts = Account::where('account_type', 1)
        ->orderBy('account_id', 'desc')
        ->get();

    $membershipTotal = $membershipAccounts->sum('current_balance');


    // Other Accounts (account_type = 0)
    $otherAccounts = Account::where('account_type', 2)
        ->orderBy('account_id', 'desc')
        ->get();

    $otherTotal = $otherAccounts->sum('current_balance');

    return view('admin.pages.account.account-ledger', compact(
        'membershipAccounts',
        'membershipTotal',
        'otherAccounts',
        'otherTotal'
    ));
    }
}
