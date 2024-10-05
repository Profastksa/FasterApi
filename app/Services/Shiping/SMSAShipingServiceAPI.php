<?php

namespace App\Services\Shiping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;


class SMSAShipingServiceAPI
{
    //public static $baseUrl  = 'https://smsaopenapis.azurewebsites.net/api/';
    public static $baseUrl  = 'https://ecomapis.smsaexpress.com/api/';





    public static function getToken()
    {
        $body = [
            'accountNumber' => "GI0344",
            'username' => "GI0344",
            'password' => "cXx8L9:8PRmPz&",
        ];

        $response = Http::post(self::$baseUrl  . 'Token', $body);
        return json_decode($response->body())->token;
    }

    public static function printAllLabel($awbNo)
    {
        $url = self::$baseUrl . 'Shipment/QueryB2CByAwb?awb=' . $awbNo[0];
        $token = self::getToken();



        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);



        $data = json_decode($response->body(), true);
        dd( $response);
        if (!isset($data['waybills'][0]['label'])) {
            return ['response' => 'error', 'msg' => 'Please try again in few minutes!'];
        }


        $labelData = base64_decode($data['waybills'][0]['label']);
        $labelName =  $awbNo[0] . '.pdf';

        // file_put_contents(public_path('labels/' . $labelName), $labelData);

        // return ['response' => 'success', 'msg' => public_path('labels/' . $labelName)];
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $labelName . '"',
        ];

        $filename = "Test.pdf";
        header('Content-type:application/pdf');
        header('Content-disposition: inline; filename="' . $filename . '"');
        header('content-Transfer-Encoding:binary');
        header('Accept-Ranges:bytes');
        // echo ;
        echo ($labelData);
        die();
        // Return the file as response
        return Response::download(public_path('labels/' . $labelName), $labelName, $headers);
        // Logic for printing all labels
        // This function is not fully implemented as it requires more details on how the printing is handled.
    }
    public static function printAllLabel2($awbNo)
    {
        // Check if AWB number is provided
        if (empty($awbNo)) {
            return response()->json([
                'response' => 'error',
                'msg' => 'Invalid AWB number.'
            ]);
        }

        try {
            // Build URL and get the token
            $url = self::$baseUrl . 'Shipment/QueryB2CByAwb?awb=' . $awbNo[0];
            $token = self::getToken();

            // Call API with Bearer token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url);

            // Parse response body
            $data = json_decode($response->body(), true);

            // Check if the label exists
            if (!isset($data['waybills'][0]['label'])) {
                return response()->json([
                    'response' => 'error',
                    'msg' => 'AWB file not found.'
                ]);
            }

            // Decode base64 label data
            $labelData = base64_decode($data['waybills'][0]['label']);
            $labelName = $awbNo[0] . '.pdf';

            // Create label file in the public directory
            $filePath = public_path('labels/' . $labelName);
            if (!file_put_contents($filePath, $labelData)) {
                return response()->json([
                    'response' => 'error',
                    'msg' => 'Failed to save the AWB file.'
                ]);
            }

            // Generate the public URL for the saved file
            $publicUrl = url('labels/' . $labelName);

            // Return success response with file URL
            return response()->json([
                'response' => 'success',
                'msg' => $publicUrl
            ]);

        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'response' => 'error',
                'msg' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }


    public static function generateLabelUrl($awbNo)
    {

       try {
        //code...

        $url = self::$baseUrl . 'Shipment/QueryB2CByAwb?awb=' . $awbNo[0];
        $token = self::getToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url);
        dd( $response->body() );

        $data = json_decode($response->body(), true);


        $data = json_decode($response->body(), true);
dd( $data);
        if (!isset($data['waybills'][0]['label'])) {
            return '';
        }

        $labelData = base64_decode($data['waybills'][0]['label']);
        $labelName = $awbNo[0] . '.pdf';
        $filePath = public_path('labels/' . $labelName);
        if (!file_put_contents($filePath, $labelData)) {
            return 'nofile';
        }

        return ''. url('labels/' . $labelName);

    } catch (\Throwable $th) {
        throw $th;
       }
    }

    public function deleteLabel($attachUrl)
    {
        // Logic for deleting a label
        // This function is not fully implemented as it requires more details on how the deletion is handled.
    }

    public static function addShipping($orderDetails)
    {
        $token = self::getToken();

        if (!$token) {
            return ['error' => 'Authentication failed.'];
        }

        $shippingData = self::prepareShippingData($orderDetails);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post(self::$baseUrl . '/Shipment/B2CNewShipment', $shippingData);

        return self::handleResponse(response: $response);
    }


    public static function prepareShippingData($request, $id)
    {
        $shippingData = [];

        // Shipper address details
        $shippingData['shipperAddressDetails'] = [
            'addressType' => "SHIPPER",
            'name' => $request->site_title, // Assuming 'site_title' is a part of the request
            'addressLine1' => $request->store_address,
            'addressLine2' => $request->store_address_2,
            'district' => $request->store_state,
            'addressCity' => $request->store_city,
            'addressCountryCode' => $request->store_country,
            'postalCode' => $request->store_postcode,
            'phoneNumber' => $request->store_phone,
        ];



        // Reference number and consignee address details, extracting by ID
        $shippingData['reference'] = $request->ref[$id];
        $shippingData['consigneeAddressDetails'] = [
            'addressType' => "CONSIGNEE",
            'name' => ucwords($request->name[$id]),
            'addressLine1' => $request->addressLine1[$id],
           // 'addressLine2' => $request->addressLine2[$id],
            'district' => ucwords($request->district[$id]),
            'addressCity' => ucwords($request->addressCity[$id]),
            'addressCountryCode' => $request->addressCountryCode[$id],
            'postalCode' => $request->postalCode[$id],
            'phoneNumber' => $request->c_phone[$id],
        ];

        // Additional shipping details, extracting by ID
        $shippingData['codAmount'] = (float)$request->cod[$id];
        $shippingData['declaredValue'] = (float)$request->declaredValue[$id];
        $shippingData['shipmentCurrency'] = $request->shipmentCurrency[$id];
        $shippingData['shipmentWeight'] = (float)$request->weight[$id];
        $shippingData['weightUnit'] = "KG";
        $shippingData['shipmentContents'] = $request->shipmentContents[$id];
        $shippingData['shipmentParcelsCount'] = (float)$request->parcels[$id];

        return $shippingData;
    }



    // protected static function prepareShippingData($request, $id)
    // {
    //        // Base data structure for all requests
    //     $shippingData = [
    //         'consigneeDetails' => [
    //             'name'    => $request->name[$id],
    //             'city'    => $request->city[$id],
    //             'mobile'  => $request->phone[$id],
    //             'street'  => $request->address[$id],
    //             'country' => $request->country[$id],
    //         ],
    //         'shipmentDetails' => [
    //             'referenceNumber' => $request->ref[$id],
    //             'weight'          => $request->weight[$id],
    //             'pieces'          => $request->number_of_peaces[$id],
    //         ],
    //     ];

    //     // Additional data for specific request types
    //     if ($request->type == 'smsaWithSenderEdit') {
    //         $shippingData['senderDetails'] = [
    //             'name'        => $request->shipper_name[$id],
    //             'contactName' => $request->shipper_contact_name[$id],
    //             'addressLine1'=> $request->shipper_address_line1[$id],
    //             'city'        => $request->shipper_city[$id],
    //             'country'     => $request->shipper_country[$id],
    //             'phone'       => $request->shipper_phone[$id],
    //         ];
    //     }

    //     return $shippingData;
    // }

    protected function handleResponse($response)
    {
        // Handle the API response
        // Return success data or error messages
    }


    public static function generateLabel($data)
    {
    }




    // Other functions can be added similarly...

}
