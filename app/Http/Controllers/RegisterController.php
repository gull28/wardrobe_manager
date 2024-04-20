<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store()
    {
        // Validate the user
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        // Create and save the user
        $user = User::create($validated);

        // Sign them in
        auth()->login($user);

        // Redirect to the home page
        return redirect("/");
    }
}
