<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(){
    	return view('login');
    }

    public function authenticate(){
    	request()->validate([
    		'username' => 'required',
    		'password' => 'required',
    	]);

    	$credentials = request()->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
        return redirect('/login')->with('unauthorize', 'Username atau Password salah')->withInput(request()->only('username'));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
