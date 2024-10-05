@extends('layouts.master')
@push('links')
<style>
@media print {






    @page {

        margin: 0;
        /* Set print page size to A6 */
    }

    #invoice-template-large,
    #invoice-template-large * {
        visibility: visible;
    }

    #invoice-template-large {
        left: 0px;
        right: 0;
        top: 0px;
        position: fixed;
    }

    #invoice-template-small,
    #invoice-template-small * {
        visibility: visible;
    }



    .invoice-table {
        width: 100%;
        /* Adjust the width to fit the A6 page */
    }
}



table {
    height: 100%;
    width: 100%;
}

</style>

@endpush

@section('content')



<div>
    <button class="btn btn-info" onclick="printInvoice()">Print Invoice</button>
    <br/>
    <br/>
 <div class="invoice-print"> <!-- Add class for printing -->
    @for ($i = 1; $i <= $order->number_of_pieces; $i++)


            <div style=" background-color:white" id="invoice-template-large">
                <table border="1"  class="invoice-table"  style="direction: ltr;border: 1px solid #030303;">
                    <tr style="text-align: center;">
                        <td style="width: 33% ">

                            <img src="{{ asset('uploads/' . $OrganizationProfile->logo) }}" alt="Company Logo"
                                style="max-width: 80px;">

                        </td>
                        <td >

                                <div   style="margin: 5px;">
                                {!! QrCode::size(80)->generate('https://app.proofast.com/order-tracking/'.$order->tracking_number ) !!}
                                </div>
                            </td>
                        <td style="width: 33% ">
                            <table border="1"  width="100%" height="100%" style=" border: 1px  #030303; " class="ca">

                                <tr>
                                    <td class="vac">
                                     {{ $order->receiverArea->country_code }} ,       {{ $order->receiverSubArea->area_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vac">
                                        {{ $order->service->ServiceCode }}
                                    </td>
                                </tr>
                            </table>



                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border: 0px; ">
                            <table  style="width: 100%;text-align: start; vertical-align: top;">
                                <tr>
                                    <td  class="va"  style="width: 50%; border: 1px solid #030303; padding: 10px;">
                                        <strong>From:</strong> <br>
                                          {{ $order->sender_name }}<br>

                                        <strong>Mobile:</strong> {{ $order->sender_phone }}<br>

                                         <strong>City:</strong> {{ $order->senderSubArea->name }}<br>
                                         <strong>Address:</strong> {{ $order->sender_address }}<br>
                                         {{-- @dd($order->sender_area_id); --}}
                                         {{ $order->senderArea->country_code }}

                                    </td>
                                    <td  class="va" style=" width: 50% ;border: 1px solid #030303; padding: 10px;">
                                        <strong>To</strong> :<br>
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
                    <tr style="text-align: center;">
                        <td colspan="3" style="text-align: center;  padding:5px">


                            <img class="barcode" src="data:image/png;base64, {!! DNS1D::getBarcodePNG($order->tracking_number, 'C128', 2, 50) !!}" alt="Barcode">

                        </td>
                    </tr>
                    <tr style="text-align: center;">
                        <td colspan="3" style="text-align: center; padding:5px">
                            <strong>Tracking Number:</strong> #{{ $order->tracking_number }}<br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border: 0px; ">
                            <table style="width: 100%;text-align: start; ">
                                <tr>
                                    <td style="width: 50% ;border: 1px solid #030303; padding: 10px;">
                                        <strong>Ref # </strong> {{ $order->orderRef }}<br>
                                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y H:i:s') }}<br>
                                        <strong>Pieces:</strong> {{ $order->number_of_pieces }}<br>
                                        <strong>Weight:</strong> {{ $order->order_weight }} Kg<br>
                                        <strong>Order Value:</strong> {{ $order->order_fees }}<br>
                                    </td>
                                    <td  style="width: 50% ;border: 1px solid #030303; padding: 10px; text-align: center;">
                                        <strong>COD : </strong> {{ $order->order_value?  $order->order_value : 0}}<br>


                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"  style="text-align: center;  padding:10px" >
                            <strong>Description:</strong>  {{ $order->note?$order->note:'----' }}<br>
                        </td>

                    </tr>
                </table>
            </div>

    @endfor
</div>
    <br/>
    <button class="btn btn-info" onclick="printInvoice()">Print Invoice</button>

</div>
<script>
    function printInvoice() {
        var printContents = document.querySelector('.invoice-print').innerHTML;
        var originalContents = document.body.innerHTML;

        var printWindow = window.open('', '_blank', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print Invoice</title>');

        printWindow.document.write('<link rel="stylesheet" href="/css/Printing.css" type="text/css" />'); // Optional: Include your stylesheet here
        printWindow.document.write('</head><body >');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();

        setTimeout(function() { // Give enough time for the new window to load the content and styles
            printWindow.print();
            // printWindow.close();
        }, 250);
    }
    </script>
@endsection
@push('script')



@endpush
