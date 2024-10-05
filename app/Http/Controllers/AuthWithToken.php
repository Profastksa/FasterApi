<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LoginWithToken;

class AuthWithToken extends Controller
{
    // use LoginWithToken;

    public function  ErrorMassage($Message){
        return response()->json([
            'status' => false,
            'messages' => $Message
        ]);
    }
}
