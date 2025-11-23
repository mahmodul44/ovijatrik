<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   function index(){
     $data['users'] = User::where(['role' => 3,'status' => '1'])->get();
     return view('admin.pages.user.index',$data);
   }

   function userPending(){
    $data['users'] = User::where(['role' => 3,'status' => '0'])->get();
    return view('admin.pages.user.pendinglist',$data);
   }

   function approveUser(Request $request)
   {
        $user = User::findOrFail($request->id);
        $user->status = 1;
        $user->save();

        return response()->json(['success' => 'User approved successfully!']);
   }

}
