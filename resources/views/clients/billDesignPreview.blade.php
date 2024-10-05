@php
    $totalBlade = 0;
    $DeliveryFess = [];
    $totalOfService = 0;
    $newOrder = $Orders;
    $total_quntity = 0;
    $total_of_fees = 0;

@endphp

<div class="d-flex justify-content-between align-items-center my-1">
    <div class="col-md-4"></div>
    <div class="col-md-4 text-center inprintOnly">
        <h1>Invoice - {{ __('translation.invoice') }}</h1>
    </div>
    <div class="col-md-4 p-2 text-right inprintOnly">
        <div class="imgContinaer text-right inprintOnly">
            @if ($client->organizationProfile && $client->organizationProfile->logo)
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('uploads/' . $client->organizationProfile->logo))) }}" alt="Company Logo">
            @else
                <p>No logo available</p>
            @endif
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center my-1">
    <div class="col-md-6 inprintOnly p-2">
        <div class="imgContinaer">
            <h3><b>{{ __('translation.name.of.company') }}</b>: {{ $client->organizationProfile->name ?? 'N/A' }}</h3>
            <h3>
                <span><b>{{ __('translation.name') }}:</b></span>
                <span>{{ $client->fullname }}</span>
            </h3>
            <h3>
                <span><b>رمز العميل:</b></span>
                <span>GIZ-{{ $client->id }}</span>
            </h3>
            <h3>
                <span><b>رقم الفاتورة:</b></span>
                <span>غير مصدره</span>
            </h3>
            <h3>
                <span><b>{{ __('translation.issue_date') }}:</b></span>
                <span>{{ date('y-m-d') }}</span>
            </h3>
        </div>
    </div>
    <div class="col-md-6 p-2 text-right inprintOnly"></div>
</div>

<div class="HiddenInPrint">
    <div class="d-flex justify-content-between">
        <h3>
            <span>{{ $client->fullname }}</span>
            <span class="badge badge-sm mx-1 badge-warning">غير مصدره</span>
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
                    a.document.write('html, body, html body {background:#fff; padding:10px}');
                    a.document.write(styles);
                    a.document.write('</style>');
                    a.document.write(divContents);
                    a.document.write('</body></html>');
                    setTimeout(() => {
                        a.print();
                    }, 3000);
                    a.document.close();
                }
            </script>
            <button onclick="Print()" class="btn btn-sm btn-primary">{{ __('translation.print') }}</button>
            <button id="base-tab42" data-toggle="tab" aria-controls="tab42" onclick="document.getElementById('base-tab42').click()" href="#tab42" class="btn btn-sm btn-primary">{{ __('translation.add.file') }}</button>
        </div>
    </div>
</div>

<div class="inprintOnly">
    <div class="d-flex justify-content-between">
        <div>
            <h3>
                <span><b>{{ __('translation.client.name') }}:</b></span>
                <span>{{ $client->fullname }}</span>
            </h3>
        </div>
        <div>
            <h3>
                <span><b>{{ __('translation.status') }}:</b></span>
                <span>غير مصدره</span>
            </h3>
        </div>
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
                <h2>{!! $ServiceHeading[$Services->find($keyy)->id][0] !!}</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3px">{{ __('translation.No') }}</th>
                            <th>{{ __('translation.order.date') }}</th>
                            <th>{{ __('translation.sender.name') }}</th>
                            <th>{{ __('translation.receiver.name') }}</th>
                            <th>{{ __('translation.order_value') }}</th>
                            <th class="HiddenInPrint">{{ __('translation.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ServiceOne as $key => $order)
                            <tr>
                                <td>{{ $order->tracking_number }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                <td>{{ $order->sender_name }}</td>
                                <td>{{ $order->order_value }}</td>
                                <td class="HiddenInPrint">
                                    <a href="{{ route('print.invoice', $order->id) }}" class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                    <a href="{{ route('orders.show.details', $order->id) }}" class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if (count($Cod) > 0)
                <h2>{!! $ServiceHeading[$Services->find($keyy)->id][1] !!}</h2>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3px">{{ __('translation.No') }}</th>
                            <th>{{ __('translation.order.date') }}</th>
                            <th>{{ __('translation.sender.name') }}</th>
                            <th>{{ __('translation.receiver.name') }}</th>
                            <th class="HiddenInPrint">{{ __('translation.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Cod as $key => $order)
                            <tr>
                                <td>{{ $order->tracking_number }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->sender_name }}</td>
                                <td>{{ $order->receiver_name }}</td>
                                <td class="HiddenInPrint">
                                    <a href="{{ route('print.invoice', $order->id) }}" class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                    <a href="{{ route('orders.show.details', $order->id) }}" class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
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
                    <th style="width: 3px">{{ __('translation.No') }}</th>
                    <th>{{ __('translation.order.date') }}</th>
                    <th>{{ __('translation.sender.name') }}</th>
                    <th>{{ __('translation.receiver.name') }}</th>
                    <th class="HiddenInPrint">{{ __('translation.action') }}</th>
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
                            <td class="HiddenInPrint">
                                <a href="{{ route('print.invoice', $order->id) }}" class="btn btn-sm btn-icon btn-warning"><i class="la la-print"></i></a>
                                <a href="{{ route('orders.show.details', $order->id) }}" class="btn btn-sm btn-icon btn-info"><i class="la la-info"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="10">{{ __('translation.table.empty') }}</td>
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
                        <div><h4 class="">Total</h4></div>
                        <div><h4 class="">{{ __('translation.service') }}</h4></div>
                    </th>
                    <th class="text-center">
                        <div><h4 class="">Quantity</h4></div>
                    <div><h4 class="">{{ __('translation.qunitity') }}</h4></div>
                    </th>
                    <th class="text-center">
                        <div><h4 class="">Service Charges</h4></div>
                        <div><h4 class="">{{ __('translation.service_fees') }}</h4></div>
                    </th>
                    <th class="text-center">
                        <div><h4 class="">Total</h4></div>
                        <div><h4 class="">{{ __('translation.total') }}</h4></div>
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
                                                $price = $client->ServicePrice->where('service_id', $key)->first()->price;
                                                echo $price;
                                            @endphp
                                        @else
                                            @php
                                                $price = $Services->where('id', $key)->first()->price;
                                                echo $price;
                                            @endphp
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $total_of_fees += count($ServiceOne) * $price;
                                            echo count($ServiceOne) * $price;
                                        @endphp
                                    </td>
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
                                                $price = $client->ServicePrice->where('service_id', $key)->where('type', 'pickup')->first()->price;
                                                echo $price;
                                            @endphp
                                        @else
                                            @php
                                                $price = $Services->where('id', $key)->first()->cod;
                                                echo $price;
                                            @endphp
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $total_of_fees += count($Cod) * $price;
                                            echo count($Cod) * $price;
                                        @endphp
                                    </td>
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
                                @else
                                    @php
                                        $price = $Services->where('id', $key)->first()->price;
                                        echo $price;
                                    @endphp
                                @endif
                            </td>
                            <td>
                                @php
                                    $total_of_fees += count($newOrderCollection) * $price;
                                    echo count($newOrderCollection) * $price;
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <h4>total</h4>
                            <h4>{{ __('translation.total') }}</h4>
                        </td>
                        <td>{{ $total_quntity }}</td>
                        <td></td>
                        <td>{{ $total_of_fees }}</td>
                    </tr>
                @else
                    <tr class="text-center">
                        <td colspan="10">{{ __('translation.table.empty') }}</td>
                    </tr>
                @endif
                @if (count($newOrder) > 0)
                    <tr>
                        <td colspan="2" class="text-right"><h4 class="text-right">Totol COD amount</h4></td>
                        <td><h4>{{ __('translation.cod_total_sum') }}</h4></td>
                        <td style="background:#d7e3bd"><h4>{{ isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0 }}</h4></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h4 class="text-right">Total Service Charges</h4></td>
                        <td><h4>{{ __('translation.total_fess_deserve') }}</h4></td>
                        <td style="background:#d7e3bd"><h4>{{ $total_of_fees }}</h4></td>
                    </tr>
                    <tr class="d-none">
                        <td colspan="2" class="text-right"><h4 class="text-right">TAX</h4></td>
                        <td><h4>{{ __('translation.tax') }}</h4></td>
                        <td style="background:#d7e3bd">
                            <h4>
                                @php
                                    $tax_value = $client_tax_value = 0;
                                    if (isset($ServiceOne)) {
                                        $client_tax_value = $total_of_fees * 0; //0.15;
                                    }
                                    echo $client_tax_value;
                                @endphp
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><h4 class="text-right">net. Total</h4></td>
                        <td><h4>{{ __('translation.free_total') }}</h4></td>
                        <td style="background:#d7e3bd"><h4>{{ (isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0) - $client_tax_value - $total_of_fees }}</h4></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
