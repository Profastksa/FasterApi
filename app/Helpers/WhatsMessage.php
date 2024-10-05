<?php

namespace App\Helpers;

use App\Jobs\CreateOrderBehindTheSenes;
use App\Models\Client;
use App\Models\Device;
use App\Models\MessageHistory;
use App\Models\Order;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class WhatsMessage
{
    public $body, $public_id, $file, $phone,  $has_file, $client;

    // Save The Order From Databse
    public function saveTheOrderInDatabase($request)
    {
        $this->client = Client::where('merchant_id', $request['store_id'])->first();
        // Job To Insert Order Behind The Senes
        Order::create([
            'merchant_id' => $request['store_id'],
            'client_id' => $this->client->id,
            // 'item_count' => count($request['data']['items']),
            'client_name' => $request['data']['customer']['first_name'] . ' ' . $request['data']['customer']['last_name'],
            'total_price' => $request['data']['items'][0]['amounts']['total']['amount'],
            'currency' => $request['data']['items'][0]['amounts']['total']['currency'],
            'tax_price' => $request['data']['items'][0]['amounts']['tax']['amount']['amount'],
        ]);
    }


    public function handelFileData($client)
    {

        $data['clients'] = [Client::find(3)];

        $ServiceHeading = [
            1 => [
                '<div>
        <h4> COD Orders - Delivered </h4>
        <h4> الدفع عند الاستلام  - تم التوصيل  </h4> </div>  ',
                '<div>
        <h4> Orders - Delivered </h4>
        <h4> طلبات التوصيل - المدفوعه - تم التوصيل </h4> </div>  ',
            ],
            2 => '<div>
        <h4> Local shipping Orders </h4>
        <h4>  شحن الطلبات خارج المنطقة </h4> </div>',
            3 => '<div>
        <h4> Returned Orders </h4>
        <h4> اعاده الشحنات بعد اعاده التسليم</h4> </div>',
            4 => '<div>
        <h4> International shipping Orders </h4>
        <h4> شحن دولي </h4> </div>',
        ];

        $data = array_merge($data, [
            'Services' => Service::all(),
            'ServiceHeading'  => $ServiceHeading
        ]);
        return $data;
    }
    public function HandelClientNotificationFile($client)
    {

        $data = $this->handelFileData($client);
        //  Html After Render The View
        $html = view('client_export_notification', $data)->render();
        // dd($html);
        $filename = 'clients/export_notification/' . 'invoices' . date('_y_m_d_h_i_s') . '.pdf';
        // print Invocie
        Browsershot::html($html)
            ->timeout(20)
            ->setNodeBinary("/c/Program Files/nodejs/node")
            // ->setNpmBinary('/usr/bin/npm')
            // // ->setChromePath('/var/www/html/Salla_Notify/node_modules/puppeteer/chrome/linux-1045629/chrome-linux/chrome')
            // ->addChromiumArguments([
            //     'no-sandbox',
            //     'disable-setuid-sandbox'
            // ])
            ->save($filename);
        dd('Hello');
        // Return File Name And Client
        return  asset($filename);
    }
    //  First I Handel The Content Of Message I Have Send It
    public function handelBodyOfMessage($request)
    {
        ini_set('max_execution_time', 3000);
        $this->public_id;
        info('order_repositry' . $request);
        // dd($request['data']['items'][0]['amounts']['total']['amount']);
        $this->client = Client::where('merchant_id', $request['merchant'])->first();
        $Title  = 'You Have A New Order Create';
        $MessageContent = 'You Are Have New Order I Your Store';
        $customer = $request['data']['customer']['first_name'] . ' ' . $request['data']['customer']['last_name'];
        $MessageContent .= '  By Customer ' . $customer;  #Customer Concatinate
        $MessageContent .= '  With ' . count($request['data']['items']) . " Order Item Count";
        $MessageContent .= ' With Total Pricing ' . $request['data']['items'][0]['amounts']['total']['amount'] . ' ' . $request['data']['items'][0]['amounts']['total']['currency'];
        # Handel Message Content
        // dd();
        // Get Client With Merchant Id
        $body = [
            'receiver' => $this->client->mobile,
            'message' => [
                "text" => $MessageContent,
            ]
        ];
        // dd($body);
        $this->body = $body;
    }

    public function handelMessageDataWithFile($client, $url)
    {
        // dd($url);
        ini_set('max_execution_time', 3000);
        $this->public_id;
        info('order_repositry' . $client);
        $this->client = $client;
        $body = [
            'receiver' => $client->mobile,
            'message' => [
                "document" => [
                    "url" => $url,
                ],
                "mimetype" => "application/pdf",
                "fileName" => "reports.pdf"
            ]
        ];
        $this->body = $body;
    }



    public function SendAndGetResponseStatus($body = null)
    {
        // dd($this->body);
        $json_body = $body ? $body : json_encode($this->body);
        //  Send To Node Js Server With Api
        $this->phone  = Device::where('status', 'connected')->first()->phone ?? "0990160365";
        // dd($json_body , $this->phone);
        $response = Http::withoutVerifying()->withBody($json_body, 'application/json')->post(
            env('URL_WA_SERVER',  '127.0.0.1:8000') . "/chats/send?id=$this->phone"
        );
        if (json_decode($response->body())->success) return json_decode($response->body())->success;
        else dd(json_decode($response->body()));
    }

    // public function SaveMessageToDatabase(array $data, $reports = false)
    // {
    //     // init Varibales
    //     $file_name = $reports ? $data['file_name'] : $this->client->merchant_id;
    //     $client =  $reports ?  $data['client'] : $this->client;
    //     $merchantid = $reports ? $client->merchant_id : $this->client->merchant_id;

    //     $messageHistory = MessageHistory::create([
    //         'phone_sender' => $this->phone,
    //         'title' => 'Order Message',
    //         'merchant_id' => $merchantid,
    //         'file_name' => $this->has_file ? '' : '',
    //         'content' => json_encode($this->body),
    //         'client_id' =>  $client->id,
    //         'file_name' =>  $file_name ?? '',
    //     ]);
    //     $this->public_id = $messageHistory->id;
    // }
    // Set Message As Sent affter inster it To Databse And Check it Is Go
    // public function SetMessageAsSent($status)
    // {
    //     MessageHistory::find($this->public_id)->SetSent($status);
    // }

    // public function handelSallaInvoceData($request)
    // {

    //     $data['merchant'] = Client::where('merchant_id', $request['merchant'])->first();
    //     $data['customer'] = $request['data']['customer'];
    //     $data['order_data'] = [
    //         'create_data' => $request['data']['date']['date'],
    //         'order_id' => $request['data']['id'],
    //     ];
    //     $items = [];
    //     foreach ($request['data']['items'] as $value) {
    //         $item = [
    //             'product_name' => $value['name'],
    //             'quantity' => $value['quantity'],
    //             'price' => $value['amounts']['total']['amount'],
    //             'total' => $value['amounts']['total']['amount'] * $value['quantity'],
    //         ];
    //         $items[] = $item;
    //     }
    //     $data['items'] = $items;
    //     $data['payment_method'] = $request['data']['payment_method'];
    //     return $data;
    // }

    public function handelZidInvoiceData($request)
    {
        // get Merchant Or Client Form Database
        $data['merchant'] = Client::where('merchant_id', $request['store_id'])->first();
        // Handel Customer From Request
        $data['customer'] = [
            'first_name' => $request['customer']['name'],
            'last_name' => '',
            'mobile' => $request['customer']['mobile'],
            'mobile_code' => '',
        ];
        $data['shipping']['address']['shipping_address'] = 'السودان'; #$request['shipping']['address']['street'] . $request['shipping']['address']['district'] . $request['shipping']['address']['city'][0]['name'] . $request['shipping']['address']['country'][0]['name'];
        $data['order_data'] = [
            'create_data' => $request['issue_date'],
            'order_id' => $request['id'],
        ];
        $items = [];
        foreach ($request['products'] as $value) {
            $item = [
                'product_name' => $value['name'],
                'quantity' => $value['quantity'],
                'price' => $value['net_price'],
                'total' => $value['net_price'] * $value['quantity'],
            ];
            $items[] = $item;
        }
        $data['items'] = $items;
        $data['payment_method'] = $request['payment']['method']['name'];
        return $data;
    }
}
