<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\IssueClientStatement;
use App\Models\Order;
use Livewire\Component;
use app\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;


class ClientStatementIsues extends Component
{



    public $client_id;
    public $from_date;
    public $to_date, $client, $client_name;
    public $total_amount_in = 0;
    public $total_amount_out = 0;
    public $client_current_account_balance = 0;
    public $status;

    public function hydrate()
    {
        $this->emit("select2");
        $this->total_amount_in = 0;
        $this->total_amount_out = 0;
    }

    public function getData()
    {
        $this->client_name = null;
        return $data = IssueClientStatement::latest()->paginate(250);
    }
    // public function updatedStatus($val){
    //     // dd($val);
    // }
    public function getDataWithName()
    {
        $fromDate = $this->from_date;
        $ToDate = $this->to_date;
        $Status = $this->status;
        $this->client_name = Client::find($this->client_id)->fullname  ?? ' ';
        $data = IssueClientStatement::when($this->client_id, function ($query, $client_id) {
            $query->where('client_id', $client_id);
        })
            ->when($fromDate, function ($query, $from_date) {
                return $query->where('issue_date', '>', $from_date);
            })->when($ToDate, function ($query, $from_date) {
                return $query->where('issue_date', '<', $from_date);
            });
        if ($this->status != 'all') {
            $data->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            });
        }
        return $data->latest()
            ->paginate(1000);
    }

    public function resendWhatsApp($issueClientStatementId)
    {
       // $issueClientStatementId = $event->issueClientStatement->id;

        $ClientStatementIsues = \App\Models\IssueClientStatement::with('Photos')->find($issueClientStatementId);
        $Orders = Order::whereIn('id', $ClientStatementIsues->orders_ids)->get();


       //   $Orderss = Order::whereIn('status', [ 'pickup' , 'inProgress'])->get();

         //  $client1 = Client::with('ServicePrice')->where('status', $Orderss[0]->client_id)->first();
        $client = Client::with('ServicePrice')->where('id', $Orders[0]->client_id)->first();
        $Services  = \App\Models\Service::get();
        $ServicePrice =$client->is_has_custom_price ? $client->ServicePrice : $Services;
        // $cleint = Client::where('id' , 1)->first();
        // dd($ServicePrice);
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

                 <h4> International shipping Orders </h4>
            <h4> الشحن الدوالى </h4> </div>',
            4 => '<div>
            <h4> Returned Orders by the Client </h4>

            <h4> استرجاع الطلبات من العميل </h4> </div>',

             5 => '<div>
                      <h4> Retrieving orders after unsuccessful delivery </h4>

            <h4>استرجاع الطلبات بعد محاولة التسليم  </h4> </div>',

        ];

        // return $Orders;
      //  $html = View::make('clients.billDesignPDF', compact('Orders', 'ServicePrice',  'ClientStatementIsues', 'ServiceHeading' ,'issueClientStatementId', 'Services', 'client'))->toArabicHTML();

        // Generate PDF from HTML content
        $html = View::make('clients.billDesignPDF', compact('Orders', 'ServicePrice',  'ClientStatementIsues', 'ServiceHeading' ,'issueClientStatementId', 'Services', 'client'));
        $html = $html->toArabicHTML();
       // $html .= '<div style="position: fixed; bottom: 10px; right: 10px;">Page {PAGE_NUM} of {PAGE_COUNT}</div>';

        //return response( $html);
        // Generate PDF9= from HTML content
        $pdf = PDF::loadHTML($html);





        $whatsapp_message = "مرحبا ". $client->fullname.",
            يرجى العثور على الفاتورة المرفقة بصيغة PDF.شكرًا لاختياركم.تحياتنا،
             تاريخ الاصدار : ". $ClientStatementIsues->created_at."
            Profast - فواتير";


            // Send email with PDF attachment
            // Mail::to(['faster.saudi@gmail.com', 'ahmedict6@gmail.com'])->send(new IssueClientStatementCreatedMail($pdf->output()));
          //  $pdf = PDF::loadHTML($html);
            //return $pdf->stream('invoices.pdf');

            // Generate a unique filename for the PDF
            $filename = $client->id . time() . '.pdf';

            // Save the PDF to the public directory
            $pdf->save(public_path('pdfInvoices/' . $filename));

            // Get the full public URL for the saved PDF
            $publicUrl = asset('pdfInvoices/' . $filename);

            $phoneNumber = $client->phone;
            $phoneNumber = ltrim($phoneNumber, '+');
            $phoneNumber = ltrim($phoneNumber, '0');


            // Remove spaces
            $phoneNumber = str_replace(' ', '', $phoneNumber);
          //  dd($phoneNumber);
            // Remove country code if starts with "966"
            if (substr($phoneNumber, 0, 3) == '966') {
                $phoneNumber = substr($phoneNumber, 3);
            }


            //dd($publicUrl);
            $RECEIVER_NUMBER = '966'.$phoneNumber; //'966580044902';
            //dd($RECEIVER_NUMBER);
          //  $RECEIVER_NUMBER = '966580044902';


            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://karzoun.app/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
            'appkey' => 'c8f52a57-1ffe-4ef3-a952-f7e1b6a06f6c',
            'authkey' => 'W3jIfavu9HbY4KOEP5FQEEAYs3BZsVVkKe3vEF4lhQUhC6Giym',
            'to' => $RECEIVER_NUMBER,
            'message' => $whatsapp_message,
            'sandbox' => 'false'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
         //   echo $response;



            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://karzoun.app/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
            'appkey' => 'c8f52a57-1ffe-4ef3-a952-f7e1b6a06f6c',
            'authkey' => 'W3jIfavu9HbY4KOEP5FQEEAYs3BZsVVkKe3vEF4lhQUhC6Giym',
            'to' =>$RECEIVER_NUMBER,
            'message' => '',
            'file' => $publicUrl,
            'sandbox' => 'false'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

               // Retrieve the IssueClientStatement and set the flag to indicate that WhatsApp message is sent
        $issueClientStatement = \App\Models\IssueClientStatement::find($issueClientStatementId);
        $issueClientStatement->whatsapp_sent = true; // Set the flag
        $issueClientStatement->whatsapp_sent_at = now(); // Set the timestamp
        $issueClientStatement->save(); // Save the changes


    }
    public function render()
    {
        $Client = Client::all();
        if ($this->client_id || ($this->from_date || $this->to_date)) $data =  $this->getDataWithName();
        else $data = $this->getData();
        if ($this->status && $this->status != 'all') {
            if (!!$data->count()) $data = $data->toQuery()->where('status', $this->status)->paginate(1000);
        }
        $total_fess = $data->sum('total_fees');
        $total_delevirey = $data->sum('delivery_fees');
        $total_delevirey_inner  = $data->where('service_id', 2)->sum('delivery_fees');
        $total_delevirey_outer = $data->where('service_id', 3)->sum('delivery_fees');
        $total_of_total = ($total_fess - $total_delevirey_outer) - $total_delevirey_inner;
        return view('livewire.client-statement-isues', [
            "data" => $data,
            "clients" => $Client,
            'total_delevirey_inner' => $total_delevirey_inner,
            'total_delevirey_outer' => $total_delevirey_outer,
            'total_fess' => $total_fess,
            'total_of_total' => $total_of_total,
            'total_delevirey' => $total_delevirey,
            'client_name' => $this->client_name,
        ])
            ->layout('layouts.master');
    }
}
