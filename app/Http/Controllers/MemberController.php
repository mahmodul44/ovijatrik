<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    function index(){
        $data['members'] = User::where(['role' => 3])->orderBy('id', 'desc')->get();
        return view('admin.pages.member.index',$data);
    }

    function create(){
        return view('admin.pages.member.create');
    }

    function store(Request $request)
   {
    // Validation rules
    $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email|unique:users,email',
        'occupation'        => 'required|string|max:255',
        'phone_no'          => 'required',
        'monthly_donate'    => 'required',
        'password'          => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
        'member_id'         => 'nullable|string',
    ]);

    // Validate member_id format (OBM / OBBM / OBBBM + number)
    if ($request->member_id) {
        if (!preg_match('/^(OBM|OBBM|OBBBM)\d{3}$/', $request->member_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid member ID format. Example: OBM001 or OBBM001 or OBBBM001'
            ], 422);
        }
    }

    // If no member_id provided, auto-generate
    if (!$request->member_id) {
        $prefixes = ['OBM', 'OBBM', 'OBBBM'];
        $prefix = $prefixes[0]; // default = OBM (তুমি চাইলে request থেকে prefix পাঠাতে পারো)

        // Find last member_id with this prefix
        $lastMember = User::where('member_id', 'LIKE', $prefix . '%')
            ->orderBy('member_id', 'desc')
            ->first();

        if ($lastMember) {
            $lastNumber = (int)substr($lastMember->member_id, strlen($prefix));
            $newNumber  = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = "001";
        }

        $memberId = $prefix . $newNumber;
    } else {
        $memberId = $request->member_id;
    }

    // Save data
    $member = new User();
    $member->name      = $request->name;
    $member->phone_no  = $request->phone_no;
    $member->email     = $request->email;
    $member->password  = bcrypt($request->password); 
    $member->member_id = $memberId;
    $member->occupation     = $request->occupation;
    $member->monthly_donate = $request->monthly_donate;
    $member->save();

    // Response for AJAX
    return response()->json([
        'success' => true,
        'message' => 'Member saved successfully!',
        'data'    => $member
    ]);
   }

    function memberPending(){
        $data['users'] = User::where(['role' => 3,'status' => '0'])->get();
        return view('admin.pages.user.pendinglist',$data);
   }
}
