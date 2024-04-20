<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{


    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
                'message' => 'Please check your credentials and try again.'
            ]);
        }

        return redirect("/");
    }

    public function destroy()
    {
        auth()->logout();

        return redirect("/");
    }
}
