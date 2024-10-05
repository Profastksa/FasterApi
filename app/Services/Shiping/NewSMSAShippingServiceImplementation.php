<?php

namespace App\Services\Shiping;

use SoapClient;
use SoapFault;

class NewSMSAShippingServiceImplementation
{
    protected $client;

    public function __construct()
    {
        // Initialize SOAP client using the locally cached WSDL
        try {


            if (!file_exists(storage_path('wsdl/smsa.wsdl'))) {
                throw new \Exception("WSDL file not found at " . storage_path('wsdl/smsa.wsdl'));
            }

            $this->client = new SoapClient(storage_path('wsdl/smsa.wsdl'), [
                'trace' => true,
                'exceptions' => true,
            ]);

            // $this->client = new SoapClient('http://track.smsaexpress.com/SECOM/SMSAwebService.asmx?wsdl', [
            //     'trace' => true,
            //     'exceptions' => true,
            // ]);

            // $functions = $this->client->__getFunctions();

            // dd($functions); // Output available SOAP functions


            //dd( $this->client ,storage_path('wsdl/smsa.wsdl' ));
        } catch (SoapFault $e) {

            dd($e);
            // Handle SOAP client initialization error
            throw new \Exception("Unable to initialize SOAP client: " . $e->getMessage());


        }
    }

    public function handleCustomerModel($request, $id)
    {
        try {
            return [
                'name' => "تجربه المطور",//$request->name[$id],
                'city' => $request->city[$id],
                'mobile' => $request->phone[$id],
                'street' => $request->address[$id],
                'tel1' => '',
                'country' => $request->country[$id],
                'ref' => $request->ref[$id],
                'ClinetName' => $request->ClinetName[$id],
                'id' => $id,
                'weight' => $request->weight[$id],
                'number_of_pieces' => $request->number_of_peaces[$id],
                'type' => $request->type,
                'ShipperName' =>  "تجربه المطور",// $request->shipper_name[$id] ?? $request->shipper_name,
                'ShipperContactName' => $request->shipper_contact_name[$id] ?? $request->shipper_contact_name,
                'ShipperaddressLine1' => $request->shipper_address_line1[$id] ?? $request->shipper_address_line1,
                'Shippercity' => $request->shipper_city[$id] ?? $request->shipper_city,
                'Shippercountry' => $request->shipper_country[$id] ?? $request->shipper_country,
                'Shipperphone' => $request->shipper_phone[$id] ?? $request->shipper_phone,
            ];
        }catch (\Exception $e) {
            return null;
        }


    }

    public function shipping($customer): string
    {
        try {



            // $params = [



            //     'passKey' => config('services.smsa.product_key'), // Your SMSA product key
            //     'refNo' => $customer['ref'],
            //     'sentDate' => date('Y-m-d'),
            //     'idNo' => $customer['id'],
            //     'cName' => $customer['name'],
            //     'cntry' => $customer['country'],
            //     'cCity' => $customer['city'],
            //     'cMobile' => $customer['mobile'],
            //     'cAddr1' => $customer['street'],
            //     'PCs' => $customer['number_of_pieces'],
            //     'weight' => $customer['weight'],
            //     'shipType' => 'DLV', // Delivery type, could be customized




            //     'cZip' => '11564',
            //     'cPOBox' => '1234',

            //     'cTel1' => '',
            //     'cTel2' => '',



            //      'cAddr2' => 'Street 2',
            //       'cEmail' => 'customer@example.com',

            //      'itemDesc' => 'Sample Item',





            // ];

            // try {
            //     $response = $this->client->__soapCall('addShipment', [$params]);
            //     dd($response);
            // } catch (\SoapFault $e) {
            //     // Handle SOAP error
            //     \Log::error("SOAP request failed: " . $e->getMessage());
            //     throw new \Exception("SOAP request failed: " . $e->getMessage());
            // }


            $params = [
                'passKey' => config('services.smsa.product_key'), // Your SMSA product key
                'refNo' => $customer['ref'],
                'sentDate' => date('Y-m-d'),
                'idNo' => $customer['id'].'',
                'cName' => "تجربه المطور",//$customer['name'],
                'cntry' => $customer['country'],
                'cCity' => $customer['city'],
                'cMobile' =>  $customer['mobile'],
                'cAddr1' => $customer['street'],
                'PCs' => $customer['number_of_pieces'],
                'weight' => $customer['weight'],
                'shipType' => 'DLV',
                'cZip' => '0',
                'cPOBox' => '0',
                'cTel1' => '0',
                'cTel2' => '',
                'cAddr2' => '',
                'carrValue' => '0',
                'carrCurr' => 'SAR',
                'cEmail' => 'a@a.c',
                'itemDesc' => $customer['ClinetName'],
                'custVal' => '0',
                'custCurr' => 'SAR',
                'insrAmt' => '0',
                'insrCurr' => 'SAR',
            ];

            // Add shipper details if available
            if (in_array($customer['type'], ['smsaWithSenderEdite', 'smsaWithOneSenderEdite'])) {
                $params['ShipperName'] = $customer['ShipperName'];
                $params['ShipperContactName'] = $customer['ShipperContactName'];
                $params['ShipperaddressLine1'] = $customer['ShipperaddressLine1'];
                $params['Shippercity'] = $customer['Shippercity'];
                $params['Shippercountry'] = $customer['Shippercountry'];
                $params['Shipperphone'] = $customer['Shipperphone'];
            }


            // Call the SMSA SOAP service to create a shipment
            //$response = $this->client->addShipment($params);
            $response = $this->client->__soapCall('addShipment', [$params]);

            // Parse response to get AWB (Airway Bill) number
            return $response->addShipmentResult;
        } catch (SoapFault $e) {
            throw $e;
        }
    }
}
