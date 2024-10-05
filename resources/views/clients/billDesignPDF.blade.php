<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap');
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Invoice</title>

    <style>
        body {
            font-family: "Tajawal", sans-serif;
            font-weight: 500;
            font-style: normal;
            font-size: 15px;
        }
        .tblinv  {
            text-align: right;
        }
        .tblinv td {
            transform: scaleX(-1);
        }

        .tblinv th {
            transform: scaleX(-1);
        }
    </style>
<style>
    .rtl-table {
        direction: rtl;
    }

    .rtl-table th,
    .rtl-table td {
        text-align: right;
    }
</style>
    <style>
        @page {
            size: a3;
            /* direction: rtl; */
        }

        h5 {
            font-weight: bold;
        }

        h2 {
            margin-top: 50px;
        }

        .breaker {
            page-break-before: always;
        }

        body {
            font-family: "Tajawal";
            font-weight: 500;
            font-style: normal;
            direction: rtl;
            text-align: right;
        }
        table{
            text-align: right;
        }
    </style>

    <style id='inline_style'>
        h5 {
            font-weight: bold;
        }

        h2 {
            margin-top: 50px;
        }

        .breaker {
            page-break-before: always;
        }
    </style>
    <style>
        :root {
            accent-color: #666ee8;
        }

        .inprintOnly {
            display: none;
        }

        nav.header-navbar,
        .main-menu {
            display: none;
        }

        .inprintOnly {
            display: block
        }

        .HiddenInPrint {
            display: none;
        }

        .enlarged-text {
            font-size: 20px;
            /* You can adjust the size of the header text as needed */
        }
    </style>
</head>


<body>

    @php
        $totalBlade = 0;
        $DeliveryFess = [];
        $totalOfService = 0;
        $newOrder = $Orders->groupBy('service_id');
        $total_quntity = 0;
        $total_of_fees = 0;
    @endphp



    <div class="d-flex justify-content-between justify-content-center my-1 mx-auto">
        <div class="col-md-12">
            <div class="imgContinaer text-left inprintOnly">

                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('uploads/' . $OrganizationProfile->logo))) }}"
                    alt="Company Logo">

                    <h1 style="display:inline; margin:200px;">
                        invocie - {{ __('translation.invoice') }}
                    </h1>

            </div>
        </div>


    </div>
    <div class=" ">
        <div class="col-md-12 inprintOnly ">
            <div class="imgContinaer text-right enlarged-text">
                <div>



                    {{ '  ' . $OrganizationProfile->name}}     <b>{{__('translation.name.of.company')}} : </b>


                </div>
                <div>
                    {{ $ClientStatementIsues->Client->fullname }} <b>{{ __('translation.name') }} العميل:</b>
                </div>
                <div>
                    GIZ- {{ $ClientStatementIsues->Client->id }} <b>رمز العميل :</b>
                </div>
                <div>
                    {{ $ClientStatementIsues->id }} <b>رقم الفاتورة :</b>
                </div>
                <div>
                    {{ Carbon\Carbon::parse($ClientStatementIsues->created_at)->format('Y-m-d') . ' | ' . Carbon\Carbon::parse($ClientStatementIsues->created_at)->format('Y-F-D') }} <b>{{ __('translation.issue_date') }} :</b>
                </div>

            </div>
        </div>
        <br/>
        <div class="col-md-12">
                 <h4 style="display:inline;">
                    <span>
                        {{ __('translation.' . $ClientStatementIsues->status) }}
                    </span>
                    <span>
                        <b>{{ __('translation.status') }} : </b>
                    </span>

                </h4>
                <h4 style="display:inline;  margin-left:450px;">
                    <span>
                        {{ $ClientStatementIsues->Client->fullname }}
                    </span>
                    <span>
                        <b>{{ __('translation.client.name') }} : </b>
                    </span>

                </h4>


        </div>

    </div>






    <div class="order_info">
        @foreach ($newOrder as $keyy => $newOrderCollection)
            @if ($keyy == 1)
                @php
                    $ServiceOne = $newOrderCollection->filter(fn($item) => $item->order_value != 0);
                    $Cod = $newOrderCollection->filter(fn($item) => $item->order_value == 0);
                @endphp
                @if (count($ServiceOne) > 0)
                    <h2> {!! $ServiceHeading[$Services->find($keyy)->id][0] !!}</h2>
                    <table class="table table-bordered text-right">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.order_value') }}</th>
                                <th>{{ __('translation.sender.name') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ServiceOne as $key => $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->order_value }}</td>
                                    <td>{{ $order->sender_name }}</td>
                                    <td>{{ $order->receiver_name }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if (count($Cod) > 0)
                    <h2> {!! $ServiceHeading[$Services->find($keyy)->id][1] !!}</h2>
                    <table class="table  table-bordered text-right">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.sender.name') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Cod as $key => $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->sender_name }}</td>
                                    <td>{{ $order->receiver_name }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @continue
            @endif
            {!! $ServiceHeading[$Services->find($keyy)->id] !!}
            <table class="table  table-bordered text-right">
                <thead>
                    <tr>
                        <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                        <th>{{ __('translation.sender.name') }}</th>
                        <th>{{ __('translation.receiver.name') }}</th>
                        <th>{{ __('translation.order.date') }}</th>

                        <th >{{ __('translation.No') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($newOrderCollection) > 0)
                        @foreach ($newOrderCollection as $key => $order)
                            <tr>
                                <td class='HiddenInPrint'>
                                    <a href="{{ route('print.invoice', $order->id) }}"
                                        class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                    <a href="{{ route('orders.show.details', $order->id) }}"
                                        class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                </td>
                                <td>{{ $order->sender_name }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->tracking_number }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="10">
                                {{ __('translation.table.empty') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach
    </div>


    <div class=" breaker">

        <h5>{{ __('translation.order_invoice') }}</h5>
        <div >
            <table   class="table datatable  table-bordered tblinv"  style="transform: scaleX(-1); ">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div>
                                <h5 class="">service</h5>
                            </div>
                            <div>
                                <h5 class="">
                                    {{ __('translation.service') }}</h5>
                            </div>
                        </th>
                        <th class="text-center">
                            <div>
                                <h5 class="">Qunitity</h5>
                            </div>
                            <div>
                                <h5 class="">
                                    {{ __('translation.qunitity') }}</h5>
                            </div>
                        </th>
                        <th class="text-center">
                            <div>
                                <h5 class="">Service Charges</h5>
                            </div>
                            <div>
                                <h5 class="">
                                    {{ __('translation.service_fees') }}</h5>
                            </div>
                        </th>
                        <th class="text-center">
                            <div>
                                <h5 class="">total</h5>
                            </div>
                            <div>
                                <h5 class="">
                                    {{ __('translation.total') }}</h5>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($newOrder) > 0)
                        @foreach ($newOrder as $key => $newOrderCollection)
                             @if ($key == 1)
                                @php
                                    $ServiceOne = $newOrderCollection->filter(fn($item) => $item->order_value != 0);
                                    $Cod = $newOrderCollection->filter(fn($item) => $item->order_value == 0);
                                @endphp
                                @if (count($ServiceOne) > 0)
                                    <tr>
                                        <td>{!! $ServiceHeading[$Services->find($key)->id][0] !!}</td>
                                        <td>
                                            @php
                                                $total_quntity += count($ServiceOne);
                                                echo count($ServiceOne);
                                            @endphp
                                        </td>
                                        <td>
                                            @if ($client->is_has_custom_price)
                                                @php
                                                    $price = $client->ServicePrice->where('service_id', $key)->first()
                                                        ->price;
                                                    echo $price;
                                                @endphp
                                            @endif
                                            @if (!$client->is_has_custom_price)
                                                @php
                                                    $price = $Services->where('id', $key)->first()->price;
                                                    echo $price;
                                                @endphp
                                            @endif
                                        </td>
                                        <td> @php
                                            $total_of_fees += count($ServiceOne) * $price;
                                            echo count($ServiceOne) * $price;
                                        @endphp</td>
                                    </tr>
                                @endif
                                @if (count($Cod) > 0)
                                    <tr>
                                        <td>{!! $ServiceHeading[$Services->find($key)->id][1] !!}</td>
                                        <td>
                                            @php
                                                $total_quntity += count($Cod);
                                                echo count($Cod);
                                            @endphp
                                        </td>
                                        <td>
                                            @if ($client->is_has_custom_price)
                                                @php
                                                    $price = $client->ServicePrice
                                                        ->where('service_id', $key)
                                                        ->where('type', 'pickup')
                                                        ->first()->price;
                                                    echo $price;
                                                @endphp
                                            @endif
                                            @if (!$client->is_has_custom_price)
                                                @php
                                                    $price = $Services->where('id', $key)->first()->cod;
                                                    echo $price;
                                                @endphp
                                            @endif
                                        </td>
                                        <td> @php
                                            $total_of_fees += count($Cod) * $price;
                                            echo count($Cod) * $price;
                                        @endphp</td>
                                    </tr>
                                @endif
                                @continue
                            @endif

                            <tr>
                                <td>{!! $ServiceHeading[$Services->find($key)->id] !!}</td>
                                <td>
                                    @php
                                        $total_quntity += count($newOrderCollection);
                                        echo count($newOrderCollection);
                                    @endphp
                                </td>
                                <td>
                                    @if ($client->is_has_custom_price)
                                        @php
                                            $price = $client->ServicePrice->where('service_id', $key)->first()->price;
                                            echo $price;
                                        @endphp
                                    @endif
                                    @if (!$client->is_has_custom_price)
                                        @php
                                            $price = $Services->where('id', $key)->first()->price;
                                            echo $price;
                                        @endphp
                                    @endif
                                </td>
                                <td> @php
                                    $total_of_fees += count($newOrderCollection) * $price;
                                    echo count($newOrderCollection) * $price;
                                @endphp</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>
                                <h5>total </h5>
                                <h5>{{ __('translation.total') }} </h5>
                            </td>
                            <td>{{ $total_quntity }}</td>
                            <td> </td>
                            <td> {{ $total_of_fees }}</td>
                        </tr>
                    @else
                        <tr class="text-center">
                            <td colspan="10">{{ __('translation.table.empty') }}</td>
                        </tr>
                    @endif
                    @if (count($newOrder) > 0)
                        <tr>
                             <td colspan="2" class="text-left">
                                <h5 class="text-left">
                                    Totol COD amount
                                </h5>
                            </td>
                            <td>
                                <h5>
                                    {{ __('translation.cod_total_sum') }}</h5>
                            </td>
                            <td >
                                <h5>
                                     {{ isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0 }}
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h5 class='text-left'>
                                    Total Service Charges
                                </h5>
                            </td>
                            <td>
                                <h5>
                                    {{ __('translation.total_fess_deserve') }}
                                </h5>
                            </td>
                            <td >
                                <h5>{{ $total_of_fees }}</h5>
                            </td>
                        </tr>
                        <tr class="d-none">
                             <td colspan="2" class="text-left">
                                <h5 class="text-right">
                                    TAX
                                </h5>
                            </td>
                            <td>
                                <h5>
                                    {{ __('translation.tax') }}</h5>
                            </td>
                            <td >
                                <h5>
                                     @php
                                        $tax_value = $client_tax_value = 0;
                                        if (isset($ServiceOne)) {
                                            $client_tax_value = $client_tax_value = $total_of_fees * 0; //0.15;
                                        }
                                        echo $client_tax_value;
                                    @endphp
                                </h5>
                            </td>
                        </tr>



                        <tr>

                            <td colspan="2">
                                <h5 class='text-left'> net. Total </h5>
                            </td>
                            <td>
                                <h5>
                                    {{ __('translation.free_total') }}
                                </h5>
                            </td>
                            <td >
                                <h5>
                                    {{ (isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0) - $client_tax_value - $total_of_fees }}
                                </h5>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>


        <div class="mt-5 breaker">
            <h5>توضيح</h5>
            <div class="table-responsive">
                <table class="table datatable  table-bordered">
                    <thead >
                        <tr>

                            <th class="text-center">
                                <div>
                                    <h5 class="">Qunitity</h5>
                                </div>
                                <div>
                                    <h5 class="">
                                        {{ __('translation.qunitity') }}</h5>
                                </div>
                            </th>

                            <th class="text-center">
                                <div>
                                    <h5 class="">Total</h5>
                                </div>
                                <div>
                                    <h5 class="">
                                        {{ __('translation.service') }}</h5>
                                </div>
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>
                                {{-- @dd($Cod); --}}
                                {{ $client->orders->whereIn('status', ['pickup', 'inProgress'])->where('is_collected', '0')->count() }}
                            </td>
                            <td>
                                <h5> {{ __('translation.number_order_count_out_the_clac') }} (قيد التنفيذ)<h5>
                            </td>

                        </tr>




                    </tbody>
                </table>

                <h3>التفاصيل :</h3>
                <br>
                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '1');

                @endphp

                @if (count($new) > 0)
                    <h5>توصيل الطلبات للمتاجر</h5>
                    <table class="table  table-bordered">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.client') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new as $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->receiver_name ?? '--' }}</td>
                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif







                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '2');

                @endphp

                @if (count($new) > 0)
                    <h5>شحن الطلبات للمتاجر</h5>
                    <table class="table  table-bordered">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.client') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new as $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->receiver_name ?? '--' }}</td>
                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif





                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '3');

                @endphp

                @if (count($new) > 0)
                    <h5>الشحن الدولي</h5>
                    <table class="table  table-bordered">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.client') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new as $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->receiver_name ?? '--' }}</td>
                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif










                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '4');

                @endphp

                @if (count($new) > 0)
                    <h5>استرجاع الطلبات من العميل</h5>
                    <table class="table  table-bordered">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.client') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new as $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->receiver_name ?? '--' }}</td>
                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif










                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '5');

                @endphp

                @if (count($new) > 0)
                    <h5>استرجاع الطلبات بعد محاولة التسليم</h5>
                    <table class="table  table-bordered">
                        <thead>
                            <tr>
                                <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                <th>{{ __('translation.receiver.name') }}</th>
                                <th>{{ __('translation.client') }}</th>
                                <th>{{ __('translation.order.date') }}</th>
                                <th >{{ __('translation.No') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new as $order)
                                <tr>
                                    <td class='HiddenInPrint'>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                        <a href="{{ route('orders.show.details', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                    </td>
                                    <td>{{ $order->receiver_name ?? '--' }}</td>
                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif






            </div>



        </div>


    </div>


</body>

</html>
