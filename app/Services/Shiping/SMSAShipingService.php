<?php

namespace App\Services\Shiping;

use App\Http\Livewire\MultiOrderMangement;
use \Alhoqbani\SmsaWebService\Smsa;
use \Alhoqbani\SmsaWebService\Models\Shipment;
use \Alhoqbani\SmsaWebService\Models\Customer;
use \Alhoqbani\SmsaWebService\Models\Shipper;
use App\Models\Order;
use App\Models\OrderShiping;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;

class  SMSAShipingService implements ShipingInterface
{

    public static  function HandelCustomerModel($request, $id)
    {


        if ($request->type  == 'smsaWithSenderEdite') {
        return $customer = [
            'name' => $request->name[$id],
            'city' => $request->city[$id],
            'mobile' => $request->phone[$id],
            'street' => $request->address[$id],
            'tel1' => '',
            'country' => $request->country[$id],
            'ref' => $request->ref[$id],
            'ClinetName' => $request->ClinetName[$id],
            'id' => $id,
            'weight' => $request->weight[$id],
            'number_of_peaces' => $request->number_of_peaces[$id],
            'ShipperName' => $request->shipper_name[$id],
            'ShipperContactName' => $request->shipper_contact_name[$id],
            'ShipperaddressLine1' => $request->shipper_address_line1[$id],
            'Shippercity' => $request->shipper_city[$id],
            'Shippercountry' => $request->shipper_country[$id],
            'Shipperphone' => $request->shipper_phone[$id],
            'type' => $request->type,

        ];
        }
        else if ($request->type  == 'smsaWithOneSenderEdite')
        {

            return $customer = [
                'name' => $request->name[$id],
                'city' => $request->city[$id],
                'mobile' => $request->phone[$id],
                'street' => $request->address[$id],
                'tel1' => '',
                'country' => $request->country[$id],
                'ref' => $request->ref[$id],
                'ClinetName' => $request->ClinetName[$id],
                'id' => $id,
                'weight' => $request->weight[$id],
                'number_of_peaces' => $request->number_of_peaces[$id],
                'ShipperName' => $request->shipper_name,
                'ShipperContactName' => $request->shipper_contact_name,
                'ShipperaddressLine1' => $request->shipper_address_line1,
                'Shippercity' => $request->shipper_city,
                'Shippercountry' => $request->shipper_country,
                'Shipperphone' => $request->shipper_phone,
                'type' => $request->type,

            ];
            }
        else
        {

            return $customer = [
                'name' => $request->name[$id],
                'city' => $request->city[$id],
                'mobile' => $request->phone[$id],
                'street' => $request->address[$id],
                'tel1' => '',
                'country' => $request->country[$id],
                'ref' => $request->ref[$id],
                'ClinetName' => $request->ClinetName[$id],
                'id' => $id,
                'weight' => $request->weight[$id],
                'number_of_peaces' => $request->number_of_peaces[$id],
                'type' => $request->type,

            ];

        }
    }

    public static  function shiping($customer): string
    {

        $smsa = new Smsa(config('services.smsa.product_key'));
        // Create a customer
        // dd($customer);
        $ShipmentCustomer = new Customer(
            $customer['name'], //customer name
            $customer['mobile'], // mobile number. must be > 9 digits
            $customer['street'], // street address
            $customer['city'] // city
        );
    //dd($ShipmentCustomer);
        $ShipmentCustomer->setCountry($customer['country']);

        $ShipmentCustomer->setTel1($customer['tel1']);
        // 290430465081
        // 290430465203

        $shipment = new Shipment(
            $customer['ref'], // Refrence number
            $ShipmentCustomer, // Customer object
            Shipment::TYPE_DLV // Shipment type.
        );
        $shipment->setDescription($customer['ClinetName']);
        $shipment->setWeight($customer['weight']);
        $shipment->setItemsCount($customer['number_of_peaces']);


        if ($customer['type']  == 'smsaWithSenderEdite' || $customer['type']  == 'smsaWithOneSenderEdite' ) {
            $Shipper = new Shipper(
                $customer['ShipperName'], //customer name
                $customer['ShipperContactName'], // ShipperContactName
                $customer['ShipperaddressLine1'], // street address
                $customer['Shippercity'], // Shippercity
                $customer['Shippercountry'],  // Shippercountry
                $customer['Shipperphone'], // Shipperphone
            );


            $Shipper->setAddressLine2(",");

            $shipment->setShipper($Shipper);
        }
        // dd( $shipment);

        $awb = $smsa->createShipment($shipment);
        // dd($awb->data);
        return $awb->data;
    }
    public static function printMultibleInvoice($invoice_number)
    {


        try {
            $smsa = new  Smsa(config('services.smsa.product_key'));
            $pdf = $smsa->awbPDF($invoice_number);

            $filename = "Test.pdf";
            header('Content-type:application/pdf');
            header('Content-disposition: inline; filename="' . $filename . '"');
            header('content-Transfer-Encoding:binary');
            header('Accept-Ranges:bytes');
            // echo ;
            echo ($pdf->data);
            die();
        } catch (\Alhoqbani\SmsaWebService\Exceptions\RequestError $e) {
            echo $e->getMessage();
            var_dump($e->smsaResponse);
        }
    }



    public static function printInvoice($invoice_numbers, $filePath)
    {
        try {
            $merger = new Fpdi();
            $smsa = new Smsa(config('services.smsa.product_key'));

            $firstPageSet = false;
            $firstPageSize = [];
           // Set headers for streaming PDF
            // header('Content-type: application/pdf');
            // header('Content-Disposition: inline; filename="MergedInvoices.pdf"');
            // header('Content-Transfer-Encoding: binary');
            // header('Accept-Ranges: bytes');/

            // Create an output buffer for streaming
            ob_start();

            foreach ($invoice_numbers as $invoice_number) {
                $pdfContent = $smsa->awbPDF($invoice_number)->data;
                $orderShipping =  OrderShiping::where("refrence_id", $invoice_number)->first();
                $order =  Order::where("id", $orderShipping->order_id)->first();

                for ($i = 1; $i <= $order->number_of_pieces; $i++) {
                    // Write the PDF content directly to the merger object
                    $tempPdf = tempnam(sys_get_temp_dir(), 'pdf');
                    file_put_contents($tempPdf, $pdfContent);
                    $pageCount = $merger->setSourceFile($tempPdf);
                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        $templateId = $merger->importPage($pageNo);
                        $size = $merger->getTemplateSize($templateId);

                        // Set the size for the first page and use it for subsequent pages
                        if (!$firstPageSet) {
                            $firstPageSize = ['width' => $size['width'], 'height' => $size['height']];
                            $firstPageSet = true;
                        }

                        $merger->AddPage('P', [$firstPageSize['width'], $firstPageSize['height']]);
                        $merger->useTemplate($templateId, 0, 0, $size['width'], $size['height']);
                    }
                    unlink($tempPdf);
                }
            }

            $merger->Output($filePath, 'F');
            // Output the merged PDF
            // echo $merger->Output('S');

            // Flush the output buffer
            ob_end_flush();
            // exit(); // Terminate script after streaming the PDF
        } catch (\Exception $e) {
            echo $e->getMessage();
            // Additional error handling if needed
        }
    }

    public static function generateInvoiceUrl($invoice_numbers)
    {
        try {
            $merger = new Fpdi();
            $smsa = new Smsa(config('services.smsa.product_key'));

            $firstPageSet = false;
            $firstPageSize = [];

            foreach ($invoice_numbers as $invoice_number) {
                $pdfContent = $smsa->awbPDF($invoice_number)->data;
                $orderShipping = OrderShiping::where("refrence_id", $invoice_number)->first();
                $order = Order::where("id", $orderShipping->order_id)->first();

                for ($i = 1; $i <= $order->number_of_pieces; $i++) {
                    $tempPdf = tempnam(sys_get_temp_dir(), 'pdf');
                    file_put_contents($tempPdf, $pdfContent);
                    $pageCount = $merger->setSourceFile($tempPdf);
                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        $templateId = $merger->importPage($pageNo);
                        $size = $merger->getTemplateSize($templateId);

                        if (!$firstPageSet) {
                            $firstPageSize = ['width' => $size['width'], 'height' => $size['height']];
                            $firstPageSet = true;
                        }

                        $merger->AddPage('P', [$firstPageSize['width'], $firstPageSize['height']]);
                        $merger->useTemplate($templateId, 0, 0, $size['width'], $size['height']);
                    }
                    unlink($tempPdf);
                }
            }

            $mergedPdfContent = $merger->Output('S');
            $fileName = 'PWA' . date('Ymd_His') . '.pdf';
            $filePath = public_path('invoices/' . $fileName);

            if (!file_put_contents($filePath, $mergedPdfContent)) {
                return '';
            }

            return url('invoices/' . $fileName);
        } catch (\Exception $e) {
            return ''; // Return an empty string on error
        }
    }


    public static function Tracking($invoice_number)
    {
        $smsa = new  Smsa(config('services.smsa.product_key'));
        $track = $smsa->track($invoice_number);




        if ($track->success) {

            // Initialize an array to store tracking data
            $trackingData = [];

            // Accessing the root element
            $rootElement = $track->response->documentElement;

            // Getting child nodes
            $trackingNodes = $rootElement->getElementsByTagName('Tracking');

            // Looping through child nodes
            foreach ($trackingNodes as $node) {
                // Initialize an array to store individual tracking details
                $trackingDetails = [];

                // Accessing individual elements
                $trackingDetails['awbNo'] = $node->getElementsByTagName('awbNo')->item(0)->nodeValue;
                $trackingDetails['date'] = $node->getElementsByTagName('Date')->item(0)->nodeValue;
                $trackingDetails['activity'] = $node->getElementsByTagName('Activity')->item(0)->nodeValue;
                $trackingDetails['note'] = $node->getElementsByTagName('Details')->item(0)->nodeValue;
                $trackingDetails['refNo'] = $node->getElementsByTagName('refNo')->item(0)->nodeValue;
                $trackingDetails['location'] = $node->getElementsByTagName('Location')->item(0)->nodeValue;

                // Add the tracking details to the tracking data array
                $trackingData[] = $trackingDetails;
            }

            return $trackingData;
        } else {
        }
    }



    public static  function  cancel($invoice_number, $reason)
    {
        $smsa = new  Smsa(config('services.smsa.product_key'));
        $result = $smsa->cancel($invoice_number, $reason);
    }
}
