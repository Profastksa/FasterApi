<?php
namespace App\Traits;

use ErrorException;
use Exception;

trait LoginWithToken {

    public function getPhoneNumberFromApiToken($idToken, $loginType = 'phone'){
    $ch = curl_init();
    $Data = [
        'idToken' => $idToken
    ];
    $JsonData = json_encode($Data);
    $headers = [
        'Content-Type: application/json',
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // dd($JsonData);
    $Url = 'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=AIzaSyBESuOeNOevWXRZbIRajR-vWwNMNRjPBiY';
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $JsonData);

    // In real life you should use something like:
    // curl_setopt($ch, CURLOPT_POSTFIELDS,
    //          http_build_query(array('postvar1' => 'value1')));

    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Further processing ...
    $jsonResult = curl_exec($ch);
    curl_close($ch);

    if ($jsonResult === FALSE) {
        $this->ErrorMassage('Curl failed: ' . curl_error($ch));
    }
    $response  = json_decode($jsonResult);
        // if($loginType ='phone'){
            // dd($response->users[0]->providerUserInfo);
            try{
                return ($response->users[0]->providerUserInfo[0]->{$loginType});
            }catch(ErrorException $e){
                // dd($e);
                return ;
                // ErrorException
            }
        // }
    }

}
