<?php

namespace App\Http\Controllers;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|email',
        'address' => 'required|string',
        'skills' => 'required|string',
    ]);

    Volunteer::create($request->all());

    return response()->json(['message' => 'নিবন্ধন সফল হয়েছে!'], 201);
}

}
