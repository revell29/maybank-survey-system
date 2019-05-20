<?php

namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('front.auth.login');
    }

}
