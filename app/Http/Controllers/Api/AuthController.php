<?php

namespace App\Http\Controllers\Api;

use App\Events\SendNotifcationWithFireBase;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\clientsFile;
use App\Models\IssuePhotos;
use App\Models\Representative;
use App\Scope\ApprovedScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\LoginWithToken;
use Exception;
use Fileable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    use LoginWithToken;
    public function clientRegister(Request $request)
    {
        // return $request;
        
        
       $Validator = validator($request->all() , [
               
            'fullname' => 'required|string',
            'email' => 'required_without:phone|email|unique:clients,email',
            'phone' => 'sometimes|unique:clients,phone',
            // 'sub_area_id' => 'required|exists:sub_areas,id',
            // 'area_id' => 'required|exists:areas,id',
            'password' => 'required|confirmed',
           // 'message_token' => 'required',
            'address' => 'required',
            'client_type' => 'required|in:normal,company',
            ]);
              
        if($Validator->fails()){
                  
                  
                Log::channel('clientregLog')->info(json_encode($request->all()) .'\n' .json_encode( $Validator->errors()) .'\n ==================');

                 
              }
          
        $fields = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required_without:phone|email|unique:clients,email',
            'phone' => 'sometimes|unique:clients,phone',
            // 'sub_area_id' => 'required|exists:sub_areas,id',
            // 'area_id' => 'required|exists:areas,id',
            'password' => 'required|confirmed',
            //'message_token' => 'required',
            'address' => 'required',
            'client_type' => 'required|in:normal,company',
            // 'bank' => 'required',
            // 'activity' => 'required',
            // 'name_in_invoice' => 'required',
            // 'bank_account_owner' => 'required',
            // 'bank_account_number' => 'required',
            // 'iban_number' => 'required',
            // 'civil_registry' => 'required',
        ]);

        // dd('jksa');
        // return $request->client_type;
        $email  = $request->email ?? ' ';
        $client = Client::create([
            'fullname' => $request->fullname,
            'email' => $email,
            'sub_area_id' => $request->sub_area_id ?? 14,
            'area_id' => $request->area_id ?? 5,
            'phone' => $request->phone ?? '',
            'password' => bcrypt($request->password),
            'address' => $request->address ,
            'message_token' => $request->message_token ,
            'client_type' => $request->client_type,
            'bank' => $request->bank,
            'activity' => $request->activity ,
            'name_in_invoice' => $request->name_in_invoice ,
            'bank_account_owner' => $request->bank_account_owner ,
            'bank_account_number' => $request->bank_account_number ,
            'iban_number' => $request->iban_number,
            'civil_registry' => $request->civil_registry,
        ]);

        if($request->banck_account_image){
            $profile_image_File = '/images/' . "profile_" . date('y_m_d') . '-' . time() . ".png";
            $path = public_path() . $profile_image_File;
            Image::make(file_get_contents($request->banck_account_image))->save($path);
            $profile_image = $profile_image_File;
            $ClietnFile  = clientsFile::create([
                'file' => $profile_image,
                'type' => 'bank_account_image',
                'fileable_id' => $client->id ,
                'fileable_type' => 'App\Models\Client',
            ]);

        }
        if($request->commercial_record){
            $profile_image_File = '/images/' . "profile_" . date('y_m_d') . '-' . time() . ".png";
            $path = public_path() . $profile_image_File;
            Image::make(file_get_contents($request->commercial_record))->save($path);
            $profile_image = $profile_image_File;
            clientsFile::create([
                'fileable_id' => $client->id ,
                'fileable_type' => 'App\Models\Client',
                'file' => $profile_image,
                'type' => 'commercial_record',
            ]);
        }
        if($request->identify_image){
            $profile_image_File = '/images/' . "profile_" . date('y_m_d') . '-' . time() . ".png";
            $path = public_path() . $profile_image_File;
            Image::make(file_get_contents($request->identify_image))->save($path);
            $profile_image = $profile_image_File;
            clientsFile::create([
                'fileable_id' => $client->id ,
                'fileable_type' => 'App\Models\Client',
                'file' => $profile_image,
                'type' => 'identify_image'
            ]);
        }

        // $token = $client->createToken($fields['device_name'])->plainTextToken;
        // dd($client->Files);
        $response = [
            'status' => true,
            'message' => 'your Acoount Created Successfuly  will be approved by admin please wait and login',
        ];
        return response($response, 201);
    }

    public function clientLogin(Request $request)
    {

        // $client = Client::first();
        // // return $client;
        // $token = $client->createToken('asdas')->plainTextToken;
        // return $token;

        $Validator = validator( $request->all() , [
            'device_name' => 'string',
            'idToken' => 'required',
            'login_type' => 'required|in:phoneNumber,email',
            'message_token' => 'required',
        ]);
        $device_name = $request->device_name ??  Str::random(10);
        if($Validator->fails()) return $Validator->errors();
        // get Login Key From Token         -------------------------
        $LoginKey = $this->getPhoneNumberFromApiToken($request->idToken, $request->login_type);
        // check if Login Key is Exist      --------------------------
        if(!$LoginKey) return response()->json(['status' => false , 'message' => 'the Token Is Invalid ...'] , 401);
        // Get Client Data From Database    --------------------------
        if ($request->login_type == 'phoneNumber') {
            $client = Client::withoutGlobalScope(new ApprovedScope)->where('phone', "$LoginKey")->first();
        }else {
            $client = Client::withoutGlobalScope(new ApprovedScope)->where('email', $LoginKey)->first();
        }
        if (!$client) {
            return response([
                'status' => false,
                'message' => 'Invalid Credentials ...',
                'Error_code' => 103,
            ], 401);
        }else{
            if($client->is_active == 0) return response()->json(['status' => false ,  'message' => 'your Account is disabled'  , 'Error_code' => 101] , 401);
            if($client->is_approved == 0) return response()->json(['status' => false ,  'message' => 'your Account is not approved' , 'Error_code' => 100] , 401);
        }
        $client->message_token = $request->message_token;
        $client->save();
        // genrate Token To Client
        $token = $client->createToken($device_name)->plainTextToken;
        $response = [
            'status' => true,
            'user' => $client,
            'token' => $token,
        ];
        return response($response, 201);
    }
    public function clientLogout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'status' => 'true',
            'message' => 'Logged out'
        ];
    }

    public function RepresentativeRegister(Request $request){
        try{
            $DriverFiles = ['driving_license' , 'identify_image', 'form_image'];
            
            
              /*  $fields = $request->validate([ 
                'fullname' => 'required|string',
                'email' => 'sometimes|email|unique:representatives,email',
                'phone' => 'required|unique:representatives,phone',
                'area_id' => 'required',
                'sub_area_id' => 'required',
                'password' => 'required|confirmed',
                'message_token' => 'required',
                'address' => 'required',
                ]);*/
                
            
            $Validator = validator($request->all() , [
                'fullname' => 'required|string',
                'email' => 'sometimes|email|unique:representatives,email',
                'phone' => 'required|unique:representatives,phone',
                'area_id' => 'required',
                'sub_area_id' => 'required',
                'password' => 'required|confirmed',
                'message_token' => 'required',
                'address' => 'required',
              
              
                ]);
                
              if($Validator->fails()){
                  
                     
                Log::channel('clientregLog')->info(json_encode($request->all()) .'\n' .json_encode( $Validator->errors()) .'\n ==================');

                 return $Validator->errors();
              }
          
               
                
                $email  = $request->email ?? ' ';
                $Representative = Representative::create([
                'fullname' => $request->fullname,
                'email' => $email ,
                'phone' => $request->phone,
                'area_id' => $request->area_id,
                'sub_area_id' => $request->sub_area_id,
                'phone' => $request->phone,
                'message_token' => $request->message_token,
                'password'=> bcrypt($request->password),
                'address' => $request->address,
            ]);

            try {
                 // Save Representive Files            --------------------------
            foreach($DriverFiles as $file){
                $RequestFile = $request->{$file};
            if($RequestFile){
            $profile_image_File = '/images/' . "profile_" . date('y_m_d') . '-' . time() . ".png";
            $path = public_path() . $profile_image_File;
            Image::make(file_get_contents($RequestFile))->save($path);
            $profile_image = $profile_image_File;
            $ClietnFile  = clientsFile::create([
                'file' => $profile_image,
                'type' => $file,
                'fileable_id' => $Representative->id,
                'fileable_type' => 'App\Models\Representative',
            ]);
            }
        }
            } catch (\Throwable $th) {
               
            }

           


            $response = [
                'status' => true,
                'message' => 'your account has beeen create please wait approved your account ..'
            ];
            return response($response, 201);
        }
        catch(Exception $e){
            return $e;
            return response()->json([
                'status' => false ,
                'message' => 'Somethisng went wonrg ...',
            ]);
        }
    }
    public function RepresentativeLogin(Request $request)
    {

        // Testing Token
        // $representative = Representative::first();
        // $token = $representative->createToken(1)->plainTextToken;
        // return $token;
        $fields = $request->validate([
            'idToken' => 'required',
            'login_type' => 'required|in:phoneNumber,email',
            'device_name' => 'string',
            'message_token' => 'required'
        ]);
        $device_name = $request->device_name ??  Str::random(10);
        try{
        $LoginKey = $this->getPhoneNumberFromApiToken($request->idToken , $request->login_type);
            // If Representive Is Exist Or Not         ------------------
        if(!$LoginKey) return response()->json(['status' => false , 'message' => 'the Token Is Invalid ...']);
        // get Representive Data From Database
        if ($request->login_type == 'phoneNumber') {
            $representative = Representative::withoutGlobalScope(new ApprovedScope)->where('phone', $LoginKey)->first();
        }else {
            // ApprovedScope
            $representative = Representative::withoutGlobalScope(new ApprovedScope)->where('email', $LoginKey)->first();
        }
        if (!$representative) {
            return response([
                'status' => false,
                'message' => 'Invalid Credentials ..',
                'Error_code' => 103,
            ], 401);
        }else{
            // dd($representative->is_approved);
            if($representative->is_active == 0) return response()->json(['status' => false ,  'message' => 'your Account is disabled'  ,  'Error_code' => 101 ] , 401);
            if($representative->is_approved == 0) return response()->json(['status' => false ,  'message' => 'your Account is not approved', 'Error_code' => 100 ] , 401);
        }

        $representative->message_token = $request->message_token;
        $representative->save();
            // create sunctom token -------------------
        $token = $representative->createToken($device_name)->plainTextToken;
            // init representive ----------------------
        $response = [
            'status' => true,
            'user' => $representative,
            'token' => $token,
        ];
        // return respone --------------------------
        return response($response, 201);
        }catch(Exception $e){
            return $e;
            return response([
                'status' => false,
                'message' => 'Invalid Credentials ...',
            ], 401);
        }
    }

    public function representativeLogout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'status' => 'true',
            'message' => 'Logged out'
        ];
    }

    public function TestLogin($Type = 'client'){
        $TestMOdel = Client::withoutGlobalScope(new ApprovedScope)->first();
        if($Type !== 'client') $TestMOdel = Representative::withoutGlobalScope(new ApprovedScope)->first();
        $token = $TestMOdel->createToken('jksa')->plainTextToken;
        return $token;
    }
}
