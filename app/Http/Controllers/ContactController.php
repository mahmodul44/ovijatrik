<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContactController extends Controller
{
     public function store(Request $request)
    {
      //  dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'phone'  => 'required|string|min:11',
            'email'   => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        Contact::create([
        'name'       => $request->name,
        'phone'     => $request->phone,
        'email'      => $request->email,
        'message'    => $request->message,
        'status'     => '1', 
        'created_by' => Auth::id() ?? 1,
    ]);

        return response()->json([
            'message' => 'আপনার মেসেজ সফলভাবে পাঠানো হয়েছে।'
        ], 201);
    }
}
