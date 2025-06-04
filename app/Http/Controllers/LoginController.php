<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        // Usuário e senha fixos para teste
        $usuario = 'admin';
        $senha = '123';

        if (
            $request->input('email') === $usuario &&
            $request->input('password') === $senha
        ) {
            // Simula login
            Session::put('logado', true);
            return redirect()->route('home')->with('success', 'Login realizado!');
        } else {
            return back()->withErrors(['error' => 'Usuário ou senha inválidos']);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('login');
    }
}