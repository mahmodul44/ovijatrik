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

   public function store(Request $request)
{
    $request->validate([
        'name'       => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'occupation' => 'required|string|max:255',
        'phone_no'   => 'required',
        'monthly_donate' => 'required',
        'password'   => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',

        'member_id' => [
            'required',
            'string',
            'regex:/^(OBM|ODBM|OTBM|OPM|ODPM)\d{3}$/',
            'unique:users,member_id',
        ],
    ], [
        'member_id.regex'  => 'Invalid member ID format. Example: OBM001, ODBM001, OTBM001',
        'member_id.unique' => 'This Member ID already exists.',
    ]);

    $member = new User();
    $member->name            = $request->name;
    $member->phone_no        = $request->phone_no;
    $member->email           = $request->email;
    $member->password        = bcrypt($request->password);
    $member->member_id       = $request->member_id;
    $member->occupation      = $request->occupation;
    $member->monthly_donate  = $request->monthly_donate;
    $member->save();

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

   function edit($id){
    $data['member'] = User::findOrFail($id);
    return view('admin.pages.member.edit',$data);
   }

   function update(Request $request,$id){
        $member = User::findOrFail($id);
        $request->validate([
            'name'              => 'required|string|max:255',
            'occupation'        => 'required|string|max:255',
            'phone_no'          => 'required',
            'monthly_donate'    => 'required',
            'email'             => 'required|email|unique:users,email,' . $id,
            'id_card'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'member_id' => [
                    'required',
                    'string',
                    'regex:/^(OBM|ODBM|OTBM|OPM|ODPM)\d{3}$/',
                    'unique:users,member_id,' . $id,
                ],
            ], [
                'member_id.regex'  => 'Invalid member ID format. Example: OBM001, ODBM001, OTBM001, OPM001, ODPM001',
                'member_id.unique' => 'This Member ID already exists.',
            ]);

        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $member->name           = $request->name;
        $member->phone_no       = $request->phone_no;
        $member->email          = $request->email;
        $member->member_id      = $request->member_id;
        $member->occupation     = $request->occupation;
        $member->monthly_donate = $request->monthly_donate;

        if ($request->filled('password')) {
            $member->password = bcrypt($request->password);
        }

        if ($request->hasFile('id_card')) {
            if ($member->id_card_photo && file_exists(public_path('storage/' . $member->id_card_photo))) {
                unlink(public_path('storage/' . $member->id_card_photo));
            }

            $file = $request->file('id_card');
            $filename = 'id_' . time() . '.' . $file->getClientOriginalExtension();
            
            $file->move(public_path('storage/id_cards'), $filename);
            
            $member->id_card_photo = 'id_cards/' . $filename;
        }

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully!',
            'data'    => $member
        ]);
   }

   function show($id){

   }

   function destroy($id){
      $member = User::findOrFail($id);
      $member->delete();

      return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }
}
