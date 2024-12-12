<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('auth.index');
    }

    public function authenticate(LoginRequest $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        flash_message('validation', __('auth.failed'), State::ERROR);
        return redirect()->back();
    }

    public function unauthenticate() {
        Auth::logout();
        session()->flush();
        
        return redirect()->route('auth.login');
    }
}
