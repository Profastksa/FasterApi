<?php

namespace App\Http\Controllers;

use App\Models\ClientsTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientsTokensController extends Controller
{
    public function create( Request $request )
    {

        $name =  auth()->user()->fullname;
        $id = auth()->user()->id;
            // return 'jksa altignai omsan';
        $date = date('y-m-d h:m:i');

        $secret_key = md5("{$id}-{$name}-{$date}");

        // init date to client tokens ####################################

        $data = [
            'client_id' => $id,
            'api_key'=> ClientsTokens::generateUniqueApiKey(),
            'api_secret_token' => $secret_key,
        ];
       //    inser to database  ---------------------------------
        $Client  = ClientsTokens::create($data);
        return  response()->json(
            [
                'status' => false,
                'data'=> $Client
            ]
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientsTokens  $clientsTokens
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $clientsTokens = ClientsTokens::with('Client')
        ->where('api_key' , getallheaders()['api_key'])
        ->where('api_secret_token' , $request->api_secret_token)->first();
        if($clientsTokens){
            return $clientsTokens->Client;
        }else{
            return response()->json(['status' => false , 'messages' => 'something went wrog']);
        }
    }


}
