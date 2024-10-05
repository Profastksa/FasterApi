<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
 
use App\Mail\ProoFast;
 
 
class SendEmailController extends Controller
{
     
    public function index()
    {
 
        Mail::to('mohamed1v233@gmail.com')->send(new ProoFast());
 
     
    } 
}