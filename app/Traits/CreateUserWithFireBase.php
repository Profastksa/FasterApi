<?php
namespace App\Traits;

use App\Exceptions\UserWasNotRegisterInFireBase;
use Exception;

trait CreateUserWithFireBase {

    public function AddUserToFirebase($email , $password){
        $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=AIzaSyBESuOeNOevWXRZbIRajR-vWwNMNRjPBiY';
        // $api_key = 'AAAAb3_g0Lo:APA91bFQ3rJysO1ogxTd09IMh5BRMoMc68IGX1mr4G_W7fxgLBMxXjGO1D4oejsgF7vpebdGEfANzXo6ron3p4Sjn3C2NRNCZK0vrM5aIeOlQxq3mG9RgkKwKTRVcYYE02iivq6Fid76';
        // $api_key = 'YOUR_FCM_SERVER_KEY_HERE';
        // $fields = [
        //     'notification' => [
        //         'title' => $title,
        //         'body' => $content,
        //     ],
        //     "to" => "/topics/" . $to,  //users are subscribed to topic all at startup
        // ];
        $fields  = [ 'email' => $email , 'password' => $password ,  "returnSecureToken"=>'true'];
        $headers = array(
            'Content-Type:application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $JonsResult  = json_decode($result);
        try{

        }catch(Exception $e){
            throw new UserWasNotRegisterInFireBase();
        };
    }

}
