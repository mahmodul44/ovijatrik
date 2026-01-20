<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'member_id' => [
                'required',
                'string',
                'regex:/^(OBM|ODBM|OTBM|OPM|ODPM)\d{3}$/',
                'unique:users,member_id',
            ],

            'phone_no' => ['required', 'digits:11', 'unique:users,phone_no'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()],
        ], [
            'member_id.regex' => 'Member ID format must be like OPM001, OBM001.',
            'member_id.unique' => 'This Member ID is already registered.',
        ]);


        $user = User::create([
            'name' => $request->name,
            'member_id' => $request->member_id,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       // event(new Registered($user));

       // Auth::login($user);

       // return redirect(RouteServiceProvider::HOME);
 return redirect()->route('register')->with('success', 'Registration successful! Redirecting to login...');
    
    }
}
