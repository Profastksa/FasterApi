@php
    $totalBlade = 0;
    $DeliveryFess = [];
    $totalOfService = 0;
    $newOrder = $Orders->groupBy('service_id');
    $total_quntity = 0;
    $total_of_fees = 0;
@endphp



<div class="d-flex justify-content-between align-items-center my-1">
    <div class="col-md-4"></div>
    <div class="col-md-4 text-center inprintOnly">
        <h1>
            invocie - {{ __('translation.invoice') }}
        </h1>
    </div>
    <div class="col-md-4  p-2 text-right inprintOnly">
        <div class="imgContinaer text-right inprintOnly">

            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('uploads/' . $OrganizationProfile->logo))) }}"
                alt="Company Logo">

        </div>
    </div>
</div>
{{-- prefrix the print section --}}
<div class="d-flex justify-content-between align-items-center my-1">
    <div class="col-md-6 inprintOnly p-2">
        <div class="imgContinaer">
            <h3> <b>{{ __('translation.name.of.company') }}</b> : {{ '  ' . $OrganizationProfile->name }} </h3>
            <h3>
                <span><b>{{ __('translation.name') }} :</b></span>
                <span>
                    {{ $ClientStatementIsues->Client->fullname }}
                </span>
                {{-- @dd($ClientStatementIsues->status); --}}
            </h3>

            <h3>
                <span><b>رمز العميل :</b></span>
                <span>
                    GIZ- {{ $ClientStatementIsues->Client->id }}
                </span>
                {{-- @dd($ClientStatementIsues->status); --}}
            </h3>

            <h3>
                <span><b>رقم الفاتورة :</b></span>
                <span>
                    {{ $ClientStatementIsues->id }}
                </span>
                {{-- @dd($ClientStatementIsues->status); --}}
            </h3>
            <h3>
                <span><b>{{ __('translation.issue_date') }} :</b></span>
                <span>
                    {{ '  ' . date('y-m-d') . ' | ' . date('Y-M-D') }}
                </span>
            </h3>
        </div>
    </div>
    <div class="col-md-6  p-2 text-right inprintOnly">
        <div class="imgContinaer text-right inprintOnly">

        </div>
    </div>
</div>
{{-- end prefix section --}}
<div class="HiddenInPrint">
    <div class=" d-flex justify-content-between ">
        <h3>
            <span>
                {{ $ClientStatementIsues->Client->fullname }}
            </span>
            {{-- @dd($ClientStatementIsues->status); --}}
            <span
                class="badge badge-sm mx-1 @switch($ClientStatementIsues->status)
                @case('paid')
                    badge-success
                    @break
                @case('unpaid')
                    badge-warning
                    @break
                @default
            @endswitch ">{{ __('translation.' . $ClientStatementIsues->status) }}</span>
        </h3>
        <div>
            <script>
                function Print() {
                    var divContents = document.getElementById("card-dashboard").innerHTML;
                    var styles = document.getElementById("inline_style").innerHTML;
                    var header = document.querySelector('head').innerHTML;
                    var a = window.open('', '', 'height=1000, width=1000');
                    a.document.write('<html>');
                    a.document.write(header);
                    a.document.write('<style>');
                    a.document.write('html, body , html body {background:#fff; padding:10px}');
                    a.document.write(styles);
                    a.document.write('</style>');
                    a.document.write(divContents);
                    a.document.write('</body></html>');
                    setTimeout(() => {
                        a.print();
                    }, 3000);
                    a.document.close();
                    // console.log(a.document.readyState === "complete" || a.document.readyState === "interactive");
                }
            </script>
            <button onclick="Print()" href="#tab42" class="btn btn-sm btn-primary">
                {{-- <i class="la  la-sm la-print"></i> --}}
                {{ __('translation.print') }}
            </button>

            <button id="base-tab42" data-toggle="tab" aria-controls="tab42"
                onclick="document.getElementById('base-tab42').click()" href="#tab42" class="btn btn-sm btn-primary">
                {{ __('translation.add.file') }}
            </button>
            @if ($ClientStatementIsues->status != 'paid')
                <a href="{{ route('issue.status', $ClientStatementIsues->id) }}" class="btn btn-sm btn-success">
                    {{ __('translation.asCompleted') }}
                </a>
            @else
                <a href="{{ route('issue.status', $ClientStatementIsues->id) }}" class="btn btn-sm btn-warning">
                    {{ __('translation.asNotCommpleted') }}
                </a>
            @endif
        </div>
    </div>
</div>
<div class="inprintOnly">
    <div class="d-flex justify-content-between">
        <div>
            <h3>
                <span>
                    <b>{{ __('translation.client.name') }} : </b>
                </span>
                <span>
                    {{ $ClientStatementIsues->Client->fullname }}
                </span>
            </h3>
        </div>
        <div>
            <h3>
                <span>
                    <b>{{ __('translation.status') }} : </b>
                </span>
                <span>
                    {{ __('translation.' . $ClientStatementIsues->status) }}
                </span>
            </h3>
        </div>
    </div>
</div>
<div class="order_info ">
    @foreach ($newOrder as $keyy => $newOrderCollection)
        @if ($keyy == 1)
            @php
                $ServiceOne = $newOrderCollection->filter(fn($item) => $item->order_value != 0);
                $Cod = $newOrderCollection->filter(fn($item) => $item->order_value == 0);
            @endphp
            @if (count($ServiceOne) > 0)
                <h2> {!! $ServiceHeading[$Services->find($keyy)->id][0] !!}</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3px">
                                {{ __('translation.No') }}</th>
                            <th>{{ __('translation.order.date') }}</th>
                            {{-- <th>{{ __('translation.service') }}</th> --}}
                            <th>{{ __('translation.sender.name') }}</th>
                            <th>{{ __('translation.receiver.name') }}</th>
                            <th>{{ __('translation.order_value') }}</th>
                            {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                            <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (count($ServiceOne) > 0) --}}
                        @foreach ($ServiceOne as $key => $order)
                            <tr>
                                <td>{{ $order->tracking_number }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->sender_name }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                </td>
                                <td>{{ $order->order_value }}</td>
                                {{-- <td>{{ $order->order_fees }}</td> --}}
                                <td class='HiddenInPrint'>
                                    <a href="{{ route('print.invoice', $order->id) }}"
                                        class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                    <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}} href="{{ route('orders.show.details', $order->id) }}"
                                        class="btn btn-sm btn-icon
                                btn-info"><i
                                            class="la la-info"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if (count($Cod) > 0)
                {{-- @dd($Services->find($keyy) , $key); --}}
                <h2> {!! $ServiceHeading[$Services->find($keyy)->id][1] !!}</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3px">
                                {{ __('translation.No') }}</th>
                            <th>{{ __('translation.order.date') }}</th>
                            <th>{{ __('translation.sender.name') }}</th>
                            <th>{{ __('translation.receiver.name') }}</th>
                            {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                            <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (count($ServiceOne) > 0) --}}
                        @foreach ($Cod as $key => $order)
                            <tr>
                                <td>{{ $order->tracking_number }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->sender_name }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                {{-- <td>{{ $order->order_fees }}</td> --}}
                                <td class='HiddenInPrint'>
                                    <a href="{{ route('print.invoice', $order->id) }}"
                                        class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                    <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}} href="{{ route('orders.show.details', $order->id) }}"
                                        class="btn btn-sm btn-icon
                                btn-info"><i
                                            class="la la-info"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @continue
        @endif
        {!! $ServiceHeading[$Services->find($keyy)->id] !!}
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width: 3px">{{ __('translation.No') }}
                    </th>
                    <th>{{ __('translation.order.date') }}</th>
                    <th>{{ __('translation.sender.name') }}</th>
                    <th>{{ __('translation.receiver.name') }}</th>
                    {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                    {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                    <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (count($newOrderCollection) > 0)
                    @foreach ($newOrderCollection as $key => $order)
                        <tr>
                            <td>{{ $order->tracking_number }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->sender_name }}</td>
                            <td>{{ $order->receiver_name }}</td>
                            {{-- <td>{{ $order->order_fees }}</td> --}}
                            <td class='HiddenInPrint'>
                                <a href="{{ route('print.invoice', $order->id) }}"
                                    class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}} href="{{ route('orders.show.details', $order->id) }}"
                                    class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                            </td>
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
<div class="mt-5 breaker">
    <h4>{{ __('translation.order_invoice') }}</h4>
    <div class="table-responsive">
        <table class="table datatable table-striped table-bordered">
            <thead style="background:#d7e3bd">
                <tr>
                    <th class="text-center">
                        <div>
                            <h4 class="">Service</h4>
                        </div>
                        <div>
                            <h4 class="">
                                {{ __('translation.service') }}</h4>
                        </div>
                    </th>
                    <th class="text-center">
                        <div>
                            <h4 class="">Qunitity</h4>
                        </div>
                        <div>
                            <h4 class="">
                                {{ __('translation.qunitity') }}</h4>
                        </div>
                    </th>
                    <th class="text-center">
                        <div>
                            <h4 class="">Service Charges</h4>
                        </div>
                        <div>
                            <h4 class="">
                                {{ __('translation.service_fees') }}</h4>
                        </div>
                    </th>
                    <th class="text-center">
                        <div>
                            <h4 class="">total</h4>
                        </div>
                        <div>
                            <h4 class="">
                                {{ __('translation.total') }}</h4>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>

                @if (count($newOrder) > 0)
                    @foreach ($newOrder as $key => $newOrderCollection)
                        {{-- @if ($newOrderCo) --}}
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
                            <h4>total </h4>
                            <h4>{{ __('translation.total') }} </h4>
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
                        {{-- <td></td> --}}
                        <td colspan="2" class="text-rigth">
                            <h4 class="text-right">
                                Totol COD amount
                            </h4>
                        </td>
                        <td>
                            <h4>
                                {{ __('translation.cod_total_sum') }}</h4>
                        </td>
                        <td style="background:#d7e3bd">
                            <h4>
                                {{-- @dd($Cod); --}}
                                {{ isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0 }}
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h4 class='text-right'>
                                Total Service Charges
                            </h4>
                        </td>
                        <td>
                            <h4>
                                {{ __('translation.total_fess_deserve') }}
                            </h4>
                        </td>
                        <td style='background:#d7e3bd'>
                            <h4>{{ $total_of_fees }}</h4>
                        </td>
                    </tr>
                    <tr class="d-none">
                        {{-- <td></td> --}}
                        <td colspan="2" class="text-rigth">
                            <h4 class="text-right">
                                TAX
                            </h4>
                        </td>
                        <td>
                            <h4>
                                {{ __('translation.tax') }}</h4>
                        </td>
                        <td style="background:#d7e3bd">
                            <h4>
                                {{-- @dd($Cod); --}}
                                @php
                                    $tax_value = $client_tax_value = 0;
                                    if (isset($ServiceOne)) {
                                        $client_tax_value = $client_tax_value = $total_of_fees * 0; //0.15;
                                    }
                                    echo $client_tax_value;
                                @endphp
                            </h4>
                        </td>
                    </tr>



                    <tr>
                        {{-- <td colspan="2"></td> --}}
                        {{-- <td></td> --}}
                        {{-- @dd($Cod->sum('total_fees')); --}}
                        <td colspan="2">
                            <h4 class='text-right'> net. Total </h4>
                        </td>
                        <td>
                            <h4>
                                {{ __('translation.free_total') }}
                            </h4>
                        </td>
                        <td style="background:#d7e3bd">
                            <h4>
                                {{ (isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0) - $client_tax_value - $total_of_fees }}
                            </h4>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    <div class="mt-5 breaker">
        <h4>توضيح</h4>
        <div class="table-responsive">
            <table class="table datatable table-striped table-bordered">
                <thead style="background:#d7e3bd">
                    <tr>
                        <th class="text-center">
                            <div>
                                <h4 class="">Total</h4>
                            </div>
                            <div>
                                <h4 class="">
                                    {{ __('translation.service') }}</h4>
                            </div>
                        </th>
                        <th class="text-center">
                            <div>
                                <h4 class="">Qunitity</h4>
                            </div>
                            <div>
                                <h4 class="">
                                    {{ __('translation.qunitity') }}</h4>
                            </div>
                        </th>


                </thead>


                </tr>
                <tr>
                    <td>
                        <h4> {{ __('translation.number_order_count_out_the_clac') }} (قيد التنفيذ)<h4>
                    </td>
                    <td>
                        {{-- @dd($Cod); --}}
                        {{ $client->orders->whereIn('status', ['pickup', 'inProgress'])->where('is_collected', '0')->count() }}
                    </td>

                </tr>




                <tbody>
            </table>

            <h3>التفاصيل :</h3>
            <br>
            @php

                $newServiceOne = $client->orders
                    ->whereIn('status', ['pickup', 'inProgress'])
                    ->where('is_collected', '0')
                    ->where('service_id', '1')
                    ->where('order_value', '!=', 0);

                $newServiceOneCod = $client->orders // Corrected here
                    ->whereIn('status', ['pickup', 'inProgress'])
                    ->where('is_collected', '0')
                    ->where('service_id', '1')
                    ->where('order_value', 0);

            @endphp


            {{-- @if (count($new) > 0)
                <h4>توصيل الطلبات للمتاجر</h2>
                    <table>
                        <table class="table table-striped table-bordered">

                            <thead>
                                <tr>
                                    <th style="width: 3px">{{ __('translation.No') }}
                                    </th>
                                    <th>{{ __('translation.order.date') }}</th>
                                    <th>{{ __('translation.client') }}</th>
                                    <th>{{ __('translation.receiver.name') }}</th>
                                    <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($new as $order)
                                    <tr>
                                        <td>{{ $order->tracking_number }}</td>
                                        <td>{{ $order->order_date }}</td>

                                        <td>{{ $order->client->fullname ?? '--' }}</td>
                                        <td>{{ $order->receiver_name ?? '--' }}</td>

                                        <td class='HiddenInPrint'>
                                            <a href="{{ route('print.invoice', $order->id) }}"
                                                class="btn btn-sm btn-icon btn-warning"><i
                                                    class="la la-print"></i></a>
                                            <a
                                                href="{{ route('orders.show.details', $order->id) }}"
                                                class="btn btn-sm btn-icon
                                btn-info"><i
                                                    class="la la-info"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            @endif --}}


            @if (count($newServiceOne) > 0)
                <h4>طلبات التوصيل - المدفوعه</h2>
                    <table>
                        <table class="table table-striped table-bordered">

                            <thead>
                                <tr>
                                    <th style="width: 3px">{{ __('translation.No') }}
                                    </th>
                                    <th>{{ __('translation.order.date') }}</th>
                                    {{-- <th>{{ __('translation.service') }}</th> --}}
                                    <th>{{ __('translation.client') }}</th>
                                    <th>{{ __('translation.sender.name') }}</th>
                                    {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                                    {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                                    <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newServiceOne as $order)
                                    <tr>
                                        <td>{{ $order->tracking_number }}</td>
                                        <td>{{ $order->order_date }}</td>

                                        <td>{{ $order->client->fullname ?? '--' }}</td>
                                        <td>{{ $order->receiver_name ?? '--' }}</td>
                                        {{-- <td>{{ $order->order_fees }}</td> --}}
                                        <td class='HiddenInPrint'>
                                            <a href="{{ route('print.invoice', $order->id) }}"
                                                class="btn btn-sm btn-icon btn-warning"><i
                                                    class="la la-print"></i></a>
                                            <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                href="{{ route('orders.show.details', $order->id) }}"
                                                class="btn btn-sm btn-icon
                            btn-info"><i
                                                    class="la la-info"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            @endif


            @if (count($newServiceOneCod) > 0)
                <h4>الدفع عند الاستلام </h2>
                    <table>
                        <table class="table table-striped table-bordered">

                            <thead>
                                <tr>
                                    <th style="width: 3px">{{ __('translation.No') }}
                                    </th>
                                    <th>{{ __('translation.order.date') }}</th>
                                    {{-- <th>{{ __('translation.service') }}</th> --}}
                                    <th>{{ __('translation.client') }}</th>
                                    <th>{{ __('translation.receiver.name') }}</th>
                                    {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                                    {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                                    <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newServiceOneCod as $order)
                                    <tr>
                                        <td>{{ $order->tracking_number }}</td>
                                        <td>{{ $order->order_date }}</td>

                                        <td>{{ $order->client->fullname ?? '--' }}</td>
                                        <td>{{ $order->receiver_name ?? '--' }}</td>

                                        <td class='HiddenInPrint'>
                                            <a href="{{ route('print.invoice', $order->id) }}"
                                                class="btn btn-sm btn-icon btn-warning"><i
                                                    class="la la-print"></i></a>
                                            <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                href="{{ route('orders.show.details', $order->id) }}"
                                                class="btn btn-sm btn-icon
                             btn-info"><i
                                                    class="la la-info"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            @endif

            <tbody>
                </table>




                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '2');

                @endphp

                @if (count($new) > 0)
                    <h4>

                        شحن الطلبات للمتاجر
                        </h2>
                        <table>
                            <table class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th style="width: 3px">{{ __('translation.No') }}
                                        </th>
                                        <th>{{ __('translation.order.date') }}</th>
                                        {{-- <th>{{ __('translation.service') }}</th> --}}
                                        <th>{{ __('translation.client') }}</th>
                                        <th>{{ __('translation.receiver.name') }}</th>

                                        {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                                        {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                                        <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($new as $order)
                                        <tr>
                                            <td>{{ $order->tracking_number }}</td>
                                            <td>{{ $order->order_date }}</td>

                                            <td>{{ $order->client->fullname ?? '--' }}</td>
                                            <td>{{ $order->receiver_name ?? '--' }}</td>
                                            {{-- <td>{{ $order->order_fees }}</td> --}}
                                            <td class='HiddenInPrint'>
                                                <a href="{{ route('print.invoice', $order->id) }}"
                                                    class="btn btn-sm btn-icon btn-warning"><i
                                                        class="la la-print"></i></a>
                                                <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                    href="{{ route('orders.show.details', $order->id) }}"
                                                    class="btn btn-sm btn-icon
                                btn-info"><i
                                                        class="la la-info"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                @endif


            <tbody>
                </table>

                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '3');

                @endphp

                @if (count($new) > 0)
                    <h4>الشحن الدولي</h2>
                        <table>
                            <table class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th style="width: 3px">{{ __('translation.No') }}
                                        </th>
                                        <th>{{ __('translation.order.date') }}</th>
                                        {{-- <th>{{ __('translation.service') }}</th> --}}
                                        <th>{{ __('translation.client') }}</th>
                                        <th>{{ __('translation.receiver.name') }}</th>

                                        {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                                        {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                                        <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($new as $order)
                                        <tr>
                                            <td>{{ $order->tracking_number }}</td>
                                            <td>{{ $order->order_date }}</td>

                                            <td>{{ $order->client->fullname ?? '--' }}</td>
                                            <td>{{ $order->receiver_name ?? '--' }}</td>
                                            {{-- <td>{{ $order->order_fees }}</td> --}}
                                            <td class='HiddenInPrint'>
                                                <a href="{{ route('print.invoice', $order->id) }}"
                                                    class="btn btn-sm btn-icon btn-warning"><i
                                                        class="la la-print"></i></a>
                                                <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                    href="{{ route('orders.show.details', $order->id) }}"
                                                    class="btn btn-sm btn-icon
                                btn-info"><i
                                                        class="la la-info"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                @endif


            <tbody>
                </table>





                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '4');

                @endphp

                @if (count($new) > 0)
                    <h4>


                        استرجاع الطلبات من العميل


                        </h2>
                        <table>
                            <table class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th style="width: 3px">{{ __('translation.No') }}
                                        </th>
                                        <th>{{ __('translation.order.date') }}</th>
                                        {{-- <th>{{ __('translation.service') }}</th> --}}
                                        <th>{{ __('translation.client') }}</th>
                                        <th>{{ __('translation.receiver.name') }}</th>

                                        {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                                        {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                                        <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($new as $order)
                                        <tr>
                                            <td>{{ $order->tracking_number }}</td>
                                            <td>{{ $order->order_date }}</td>

                                            <td>{{ $order->client->fullname ?? '--' }}</td>
                                            <td>{{ $order->receiver_name ?? '--' }}</td>
                                            {{-- <td>{{ $order->order_fees }}</td> --}}
                                            <td class='HiddenInPrint'>
                                                <a href="{{ route('print.invoice', $order->id) }}"
                                                    class="btn btn-sm btn-icon btn-warning"><i
                                                        class="la la-print"></i></a>
                                                <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                    href="{{ route('orders.show.details', $order->id) }}"
                                                    class="btn btn-sm btn-icon
                                btn-info"><i
                                                        class="la la-info"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                @endif


            <tbody>
                </table>








                @php
                    $new = $client->orders
                        ->whereIn('status', ['pickup', 'inProgress'])
                        ->where('is_collected', '0')
                        ->whereIn('service_id', '5');

                @endphp

                @if (count($new) > 0)
                    <h4>

                        استرجاع الطلبات بعد محاولة التسليم

                        </h2>
                        <table>
                            <table class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th style="width: 3px">{{ __('translation.No') }}
                                        </th>
                                        <th>{{ __('translation.order.date') }}</th>
                                        {{-- <th>{{ __('translation.service') }}</th> --}}
                                        <th>{{ __('translation.client') }}</th>
                                        <th>{{ __('translation.receiver.name') }}</th>

                                        {{-- <th>{{ __('translation.total.fees') }}</th> --}}
                                        {{-- <th>{{ __('translation.order_value_on_delverd') }}</th> --}}
                                        <th class='HiddenInPrint'>{{ __('translation.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($new as $order)
                                        <tr>
                                            <td>{{ $order->tracking_number }}</td>
                                            <td>{{ $order->order_date }}</td>

                                            <td>{{ $order->client->fullname ?? '--' }}</td>
                                            <td>{{ $order->receiver_name ?? '--' }}</td>
                                            {{-- <td>{{ $order->order_fees }}</td> --}}
                                            <td class='HiddenInPrint'>
                                                <a href="{{ route('print.invoice', $order->id) }}"
                                                    class="btn btn-sm btn-icon btn-warning"><i
                                                        class="la la-print"></i></a>
                                                <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                    href="{{ route('orders.show.details', $order->id) }}"
                                                    class="btn btn-sm btn-icon
                                btn-info"><i
                                                        class="la la-info"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                @endif


            <tbody>
                </table>



        </div>
