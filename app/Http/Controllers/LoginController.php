<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $_credentials = $request->only('email', 'password');
        if (auth()->attempt($_credentials)) {
            return redirect()->route('home')->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('error', 'Email ou senha inválidos');
        }

    }

    public function destroy()
    {
        var_dump('logout');
    }
}