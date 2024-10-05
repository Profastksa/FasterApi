<?php

namespace App\Traits;

use Exception;
use App\Exceptions\NotifcationException;
use Mockery\CountValidator\Exact;
use PhpParser\Builder\Trait_;

trait SendNotifcationWithFirebaseTrait
{
    public function sendFirebAseNotifcation($FcmToken, $title, $body , $fileName = '' ,  $id = 1)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // dd($fileName);
        // $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
        $serverKey = 'AAAAb3_g0Lo:APA91bFQ3rJysO1ogxTd09IMh5BRMoMc68IGX1mr4G_W7fxgLBMxXjGO1D4oejsgF7vpebdGEfANzXo6ron3p4Sjn3C2NRNCZK0vrM5aIeOlQxq3mG9RgkKwKTRVcYYE02iivq6Fid76';
        // $jsonFCMToken = json_encode(['Aug6tLqb6ecQvKOyRn5RN4nof3z2']);
        // dd($jsonFCMToken);
        $NotificationData = $this->getNotificationDataIfFileIsPassedFormParentListner($title, $body ,$fileName);
        // dd($NotificationData); asd

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => $NotificationData,
            'data' => [
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "sound" => "enable",
                'screen' => 'orders',
                'id' => $id,
            ]
        ];
        $encodedData = json_encode($data);
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            throw new Exception('the Messge is not Send');
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // dd($result);
        $FCMRespone =  json_decode($result);
        if (!$FCMRespone->success > 0) {
            throw new  NotifcationException;
        }
    }

    public function SendGloablNotifcation($to  , $title , $content ,  $fileName ,  $order_id = 1 )
    {
        // where you have to perform notification send operation.
        // $to  = $area ??  'representative';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAAb3_g0Lo:APA91bFQ3rJysO1ogxTd09IMh5BRMoMc68IGX1mr4G_W7fxgLBMxXjGO1D4oejsgF7vpebdGEfANzXo6ron3p4Sjn3C2NRNCZK0vrM5aIeOlQxq3mG9RgkKwKTRVcYYE02iivq6Fid76';
        // init Files To Database

        // if request with iamge
        $NotificationData = $this->getNotificationDataIfFileIsPassedFormParentListner($title, $content ,$fileName);

        // $withImage = [
        //     'title' => $title,
        //     'body' => $content,
        //     'image' => 'https://dev.faster.themsc.net/uploads/users_profile/user.png',
        // ];
        // $WithOutImage = [
        //     'title' => $title,
        //     'body' => $content,
        // ];

        // // Check If This Notification Came With Photo             -----
        // if($fileName) $NotificationArray = $withImage;
        // else $NotificationArray  = $WithOutImage;
        // // dd($NotificationArray);
        $fields = [
            'notification' => $NotificationData,
            "to" => "/topics/" . $to,
            'data' => [
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "sound" => "default",
                'screen' => 'orders',
                'id' => $order_id,
            ]
            //users are subscribed to topic all at startup
        ];
        // dd($fields);
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $api_key
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
        if ($result === FALSE) {
            throw new Exception;
        }
    }

    public function getNotificationDataIfFileIsPassedFormParentListner($title , $content , $fileName){
        // dd($fileName);
        $withImage = [
            'title' => $title,
            'body' => $content,
            'image' => $fileName,
        ];
        $WithOutImage = [
            'title' => $title,
            'body' => $content,
        ];

        // Check If This Notification Came With Photo             -----
        if($fileName) $NotificationArray = $withImage ;
        else $NotificationArray  = $WithOutImage;
        // dd($NotificationArray);
        return $NotificationArray;
    }
}
