<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserWasNotRegisterInFireBase;
use App\Http\Controllers\Controller;
use App\Jobs\RegisterClientOnFireBase;
use App\Models\Client;
use App\Scope\ApprovedScope;
use App\Traits\LoginWithToken;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    use LoginWithToken;
    public function GeustLogin()
    {
        $client = Client::factory()->create(
            ['fullname' => 'Guest User']
        );
        $token = $client->createToken($client->fullname)->plainTextToken;
        // Return Respone To The Client
        $client = Client::find($client->id);
        $response = [
            'status' => true,
            'user' => $client,
            'token' => $token,
        ];
        return response()->json($response);
    }

    public function GuestRegisterAccount(Request $request)
    {
        // dd($request);
        try {

        $Validator = validator($request->all(), [
            'device_name' => 'string',
            'message_token' => 'required',
            'password' => 'required',
            'fullname' => 'required|string',
            'email' => 'required|unique:clients,email',
            'phone' => 'required|unique:clients,phone',
            'client_type' => 'required|in:normal,company'
        ]);

        $device_name = $request->device_name ??  Str::random(10);
        if ($Validator->fails()) return $Validator->errors();
        // get Login Key From Token         -------------------------
        // Get Client Data From Database    --------------------------
        $client = Client::withoutGlobalScope(new ApprovedScope)->find(auth()->user()->id);
        $client->removeGuestFlag();
        $data = [
            'message_token' => $request->message_token,
            'fullname' => $request->fullname,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'email' => $request->email,
            'client_type' => $request->client_type,
        ];
        // dd($data);
        // fire Job To Create This Credntials On FireBase
        dispatch(new RegisterClientOnFireBase($request->email, $request->password));
        // Check If Mail Or Phone And Add Index Key
        $client->update($data);
        if ($client->is_active == 0) return response()->json(['status' => false,  'message' => 'your Account is disabled', 'Error_code' => 101], 401);
        // if ($client->is_approved == 0) return response()->json(['status' => false,  'message' => 'your Account is not approved', 'Error_code' => 100], 401);
        // genrate Token To Client
        $token = $client->createToken($device_name)->plainTextToken;
        $response = [
            'status' => true,
            'user' => $client,
            'token' => $token,
        ];
        return response($response, 201);
        }
        catch(UserWasNotRegisterInFireBase $e){
            return $e;
        }
        catch (Exception $th) {
            return $th;
            return response()->json([
                'status' => false,
                'message' => 'some thing went worng',
            ]);
        }
    }
}
