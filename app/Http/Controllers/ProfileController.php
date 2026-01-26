<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    /*public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    } */

public function update(ProfileUpdateRequest $request)
{
    $user = $request->user();
    $data = $request->validated();

    // Map custom field names to User model attributes
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->phone_no = $data['phone_no'];
    $user->occupation = $data['occupation'];

    if (!empty($data['password'])) {
        $user->password = Hash::make($data['password']);
    }

    if ($request->hasFile('profile_photo')) {
   
    if ($user->profile_photo) {
        Storage::disk('public')->delete($user->profile_photo);
    }
    
    $user->profile_photo = $request->file('profile_photo')->store('profiles', 'public');
    }

    if ($request->hasFile('id_card_photo')) {
        if ($user->id_card_photo) {
            Storage::disk('public')->delete($user->id_card_photo);
        }
        $user->id_card_photo = $request->file('id_card_photo')->store('uploads/id_cards', 'public');
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();
 return response()->json([
                'status'  => true,
                'message' => "Updated successful.",
                'category' => $user
            ], 200);
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
