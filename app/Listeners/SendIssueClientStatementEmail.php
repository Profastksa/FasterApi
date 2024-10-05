<?php

namespace App\Listeners;

use App\Events\IssueClientStatementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\IssueClientStatementCreated as IssueClientStatementCreatedMail;
use app\Models\Order;
use app\Models\Client;
use app\Models\Service;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;




class SendIssueClientStatementEmail implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
      //  App\Events
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\IssueClientStatementCreated  $event
     * @return void
     */
    public function handle(\App\Events\IssueClientStatementCreated $event)
    {

        try {
            //code...


        $issueClientStatementId = $event->issueClientStatement->id;

        $ClientStatementIsues = \App\Models\IssueClientStatement::with('Photos')->find($issueClientStatementId);
        $Orders = Order::whereIn('id', $ClientStatementIsues->orders_ids)->get();


       //   $Orderss = Order::whereIn('status', [ 'pickup' , 'inProgress'])->get();

         //  $client1 = Client::with('ServicePrice')->where('status', $Orderss[0]->client_id)->first();
        $client = Client::with('ServicePrice')->where('id', $Orders[0]->client_id)->first();
        $Services  = Service::get();
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

        // Remove spaces
        $phoneNumber = str_replace(' ', '', $phoneNumber);

        // Remove country code if starts with "966"
        if (substr($phoneNumber, 0, 3) == '966') {
            $phoneNumber = substr($phoneNumber, 3);
        }


            //dd($publicUrl);
            $RECEIVER_NUMBER = '966'.$phoneNumber; //'966580044902';
          //  dd($RECEIVER_NUMBER);
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


        // Send email with PDF attachment
     //  Mail::to(['faster.saudi@gmail.com', 'ahmedict6@gmail.com'])->send(new IssueClientStatementCreatedMail($pdf->output()));
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
}
