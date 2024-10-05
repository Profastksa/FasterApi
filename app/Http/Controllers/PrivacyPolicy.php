<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use Illuminate\Http\Request;

class PrivacyPolicy extends Controller
{
    public function index(){

        return view('privacy-policy');
    }
}
