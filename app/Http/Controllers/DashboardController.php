<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        return view('dashboard');
    }

    public function verify()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        return view('auth.verify');
    }
}
