<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap');

        @page {
            margin: 0px;
            size: 10.16cm 15.24cm;
        }

        body {
            font-family: "Tajawal", sans-serif;
            font-weight: 500;
            font-style: normal;
            margin: 0;
            padding: 0;
        }

        .invoice-print {
            page-break-inside: avoid;
            width: 100%;
            height: 100%;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .invoice-table, .invoice-table th, .invoice-table td {
            border: 1px solid #030303;
            padding: 4px;
            font-size: 13px;
        }

        .va {
            vertical-align: top;
        }

        .ca {
            text-align: center;
        }

        .barcode {
            max-width: 100%;
            height: auto;
        }

        .logo, .qr-code, .service-info {
            width: 33%;
            text-align: center;
        }

        .logo img, .qr-code img {
            max-width: 80px;
        }

        .service-info table {
            width: 100%;
            height: auto;
            border: 0px ;
            border-collapse: collapse;
            text-align: center;
        }

        .service-info td {
            padding: 5px;
            border: 0px ;
        }

        .no-border {
            border: none !important;
        }

        .no-padding {
            padding: 0 !important;
        }

        .inner-table {
            border: 1px solid #030303;
            width: 100%;
            border-collapse: collapse;
        }

        .inner-table td {
            padding: 5px;
            border: 1px solid #030303 !important;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Invoice</title>
</head>
<body>

        @foreach ($Orders as $order)
        <div class="invoice-print">
            @for ($i = 1; $i <= $order->number_of_pieces; $i++)

                <table class="invoice-table">
                    <tr>
                        <td class="logo">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('uploads/' . $OrganizationProfile->logo))) }}" alt="Company Logo">
                        </td>
                        <td class="qr-code">
                            <div style="margin: 5px;">
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(80)->generate('https://app.proofast.com/order-tracking/' . $order->tracking_number)) !!} ">
                            </div>
                        </td>
                        <td class="service-info">
                            <table>
                                <tr>
                                    <td>{{ $order->receiverArea->country_code }} , {{ $order->receiverSubArea->area_code }}</td>
                                </tr>
                                <tr>
                                    <td><hr/>{{ $order->service->ServiceCode }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="no-border">
                            <table class="inner-table">
                                <tr>
                                    <td class="va" style="width: 50%;">
                                        <strong>From:</strong><br>
                                        {{ $order->sender_name }}<br>
                                        <strong>Mobile:</strong> {{ $order->sender_phone }}<br>
                                        <strong>City:</strong> {{ $order->senderSubArea->name }}<br>
                                        <strong>Address:</strong> {{ $order->sender_address }}<br>
                                        {{ $order->senderArea->country_code }}
                                    </td>
                                    <td class="va" style="width: 50%;">
                                        <strong>To:</strong><br>
                                        {{ $order->receiver_name }}<br>
                                        <strong>Mobile:</strong> {{ $order->receiver_phone_no }}<br>
                                        <strong>City:</strong> {{ $order->receiverSubArea->name }}<br>
                                        <strong>Address:</strong> {{ $order->receiver_address }}<br>
                                        {{ $order->receiverArea->country_code }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">
                            <img class="barcode" src="data:image/png;base64, {!! DNS1D::getBarcodePNG($order->tracking_number, 'C128', 2, 50) !!}" alt="Barcode">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">
                            <strong>Tracking Number:</strong> #{{ $order->tracking_number }}<br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="no-border">
                            <table class="inner-table">
                                <tr>
                                    <td style="width: 50%;">
                                        <strong>Ref #</strong> {{ $order->orderRef }}<br>
                                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y H:i:s') }}<br>
                                        <strong>Pieces:</strong> {{ $order->number_of_pieces }}<br>
                                        <strong>Weight:</strong> {{ $order->order_weight }} Kg<br>
                                        <strong>Order Value:</strong> {{ $order->order_fees }}<br>
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        <strong>COD:</strong> {{ $order->order_value ? $order->order_value : 0 }}<br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">
                            <strong>Description:</strong>
                            {{ $order->note ? $order->note : '----' }}

                        </td>
                    </tr>
                </table>


            @endfor
        </div>
        @endforeach

</body>
</html>
