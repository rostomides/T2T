<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpiredAccountController extends Controller
{
    public function expired_user(){

        return view('expired_account.expired_account');

    }


    public function banned_user(){

        return view('expired_account.banned');

    }
}
