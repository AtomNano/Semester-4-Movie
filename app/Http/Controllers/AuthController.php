<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request){
        $credentials = $request -> validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
            );
            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect('/')->with('success', 'Login Succesfully,Welcome' . Auth::user()->name);
            }

            return back()->withErrors([
                'email' => 'Email Not Found'
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    //
}