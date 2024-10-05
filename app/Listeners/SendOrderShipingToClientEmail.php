<?php

namespace App\Listeners;

use App\Events\OrderShipingCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Shiping\SMSAShipingService;

class SendOrderShipingToClientEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // App\Events
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderShipingCreated  $event
     * @return void
     */
    public function handle(\App\Events\OrderShipingCreated $event)
    {
        try {
            // Prepare reference ID and public URL
            $reference_id[] = $event->orderShiping->refrence_id;
            $publicUrl = SMSAShipingService::generateInvoiceUrl($reference_id);

            // Format phone numbers
          //  $RECEIVER_NUMBER1 = $this->formatPhoneNumber($event->orderShiping->order->client->phone);
            $RECEIVER_NUMBER2 = $this->formatPhoneNumber($event->orderShiping->order->receiver_phone_no);

            // Get names and order tracking number
            //$clientName = $event->orderShiping->order->client->name;
            $receiverName = $event->orderShiping->order->receiver_name;
            $tracking_number = $event->orderShiping->refrence_id;

            // Prepare messages
          //  $clientMessage = $this->createMessage($clientName, $tracking_number, $event->orderShiping->order);
            $receiverMessage = $this->createMessage($receiverName, $tracking_number, $event->orderShiping->order);

            // Send messages
            // $this->sendMessage($RECEIVER_NUMBER1, $clientMessage);
            // $this->sendMessage($RECEIVER_NUMBER1, '', $publicUrl);
            $this->sendMessage($RECEIVER_NUMBER2, $receiverMessage);
            $this->sendMessage($RECEIVER_NUMBER2, '', $publicUrl);
        } catch (\Throwable $th) {
            // Handle exception
        }
    }

    /**
     * Format the phone number to the desired format ().
     *
     * @param string $phoneNumber
     * @return string
     */
    private function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = ltrim($phoneNumber, '+');
        $phoneNumber = str_replace(' ', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) == '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }
        if (substr($phoneNumber, 0, 3) == '966') {
            $phoneNumber = substr($phoneNumber, 3);
        }

        if (substr($phoneNumber, 0, 1) == ' ') {
            $phoneNumber = substr($phoneNumber, 1);
        }
        if (substr($phoneNumber, 0, 1) == '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }
        return '966' . $phoneNumber;
    }

    /**
     * Create a customized message.
     *
     * @param string $name
     * @param string $orderId
     * @return string
     */
    private function createMessage($name, $orderId, $order)
    {
        $trackingLink = "https://www.smsaexpress.com/sa/trackingdetails?tracknumbers={$orderId}";

        return "
    السلام عليكم عزيزي العميل {$name} 😊,

    تم شحن طلبك من {$order->sender_name}. 🚚
    سوف يتم توصيل طلبك خلال ثلاثة أيام عمل عبر شركة سمسا. ⏰

    تتبع شحنتك هنا: {$trackingLink} 🔗

    رقم الطلب: {$order->tracking_number} 📝

    Dear {$name}, 😊

    Your order has been shipped from {$order->sender_name}. 🚚
    Your order will be delivered within three business days via SMSA. ⏰

    Track your shipment here: {$trackingLink} 🔗

    Order number: {$order->tracking_number} 📝
";

        // return "
        //         مرحباً 👋
        //         {$name}

        //          سوف يتم توصيل  شحنتك إلى عنوانك  لدينا خلال يومن عمل ٫
        //         سوف يتواصل معك مندوبنا لترتيب التوصيل.
        //         نتمنى لك يوماً سعيداً، ونسعى دائماً لتقديم أفضل الخدمات لننال رضاكم 🙏

        //         تتبع شحنتك هنا: {$trackingLink}

        //         Hello 👋
        //         {$name}

        //         Your shipment will be delivered to the recorded address.

        //         We wish you a happy day, and we always strive to satisfy you with our services. 🙏

        //         Track your shipment here: {$trackingLink}
        //                 ";
        //
    }

    /**
     * Send a message via cURL.
     *
     * @param string $to
     * @param string $message
     * @param string $file
     * @return void
     */
    private function sendMessage($to, $message, $file = '')
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://karzoun.app/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'appkey' => '52ffba10-6c80-4572-82a1-984c1eb210ac',
                'authkey' => 'W3jIfavu9HbY4KOEP5FQEEAYs3BZsVVkKe3vEF4lhQUhC6Giym',
                'to' => $to,
                'message' => $message,
                'file' => $file,
                'sandbox' => 'false',
            ],
        ]);
        curl_exec($curl);
        curl_close($curl);
    }
}
