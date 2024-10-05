<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index');
    }

    public function organizationProfile()
    {
        return view('services.organization-profile');
    }

    public function generalSettings()
    {
        return view('services.general-settings');
    }

    public function PrivacyPolice(){
        $OrganizationProfile = OrganizationProfile::first();

        return view('services.privacy-policy');
    }

    public function StorePrivacyPolice(Request $request){
        // return $request;
        $validator  = $request->validate([
            'pravicy_ar'=> 'required',
            'pravicy_en' => 'required'
        ]);

        $OrganizationProfile = OrganizationProfile::first();
        $OrganizationProfile->pravicy_ar = $request->pravicy_ar;
        $OrganizationProfile->pravicy_en = $request->pravicy_en;
        $OrganizationProfile->save();

        return redirect()->route('home');
    }
}
