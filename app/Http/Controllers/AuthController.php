<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }



}
