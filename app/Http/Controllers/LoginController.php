<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request) {
        // check the request
        dd($request);
        // check the password
    }
}
