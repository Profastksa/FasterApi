<div>
    <style>
        .inprintOnly {
            display: none !important;
        }
    </style>
    <style id='inline_style'>
        @page {
            size: A3 portrait;
            margin: 0px;
            /* Adjust margins as needed */
            scale: 0.8;
        }


    </style>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.representatives') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('representatives-orders') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">

                                <div class="">
                                </div>
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div wire:ignore class="col-md-6">
                                            <select wire:model="representative_id"
                                                class="select2 representativeSelect2 form-control " style="width:100%">
                                                <option value="">--{{ __('translation.select.representative') }}--
                                                </option>
                                                @foreach ($representatives as $representative)
                                                    <option
                                                        {{ $representative_id == $representative->id ? 'selected' : '' }}
                                                        value="{{ $representative->id }}">
                                                        {{ $representative->fullname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select wire:model="status" class=" form-control " style="width:100%">
                                                <option value="">--{{ __('translation.select.order.status') }}--
                                                </option>
                                                <option value="pending">
                                                    {{ __('translation.pending') }}</option>
                                                <option value="pickup">
                                                    {{ __('translation.pickup') }}</option>
                                                <option value="inProgress">
                                                    {{ __('translation.inProgress') }}</option>
                                                <option value="delivered">
                                                    {{ __('translation.delivered') }}</option>
                                                <option value="completed">
                                                    {{ __('translation.completed') }}</option>
                                                <option value="running_to_delivery">
                                                    {{ __('translation.running_to_delivery') }}</option>
                                                {{-- <option value="returned">
                                                    {{ __('translation.returned') }}</option>
                                                <option value="canceled">
                                                    {{ __('translation.canceled') }}</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="mx-2">مبالغ الدفع عند التسليم للمناديب</h5>
                        <br />
                        <div class="row">


                            @foreach ($representatives as $representative)
                                @if ($representative_id)
                                    @continue($representative_id != $representative->id)
                                @endif




                                <div class="col-xl-2 col-lg-2 col-2">
                                    {{-- <a data-toggle="modal" data-target="#FeesCollection" data-backdrop="static"
                                        data-keyboard="false"
                                        wire:click="ShowCollectionForRep({{ $representative->id }})"
                                        data-target="#showcollection" href="#"> --}}
                                    <div class="card pull-up">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="media-body text-left">
                                                        <h6>{{ $representative->fullname }}</h6>
                                                        <h3 class="info">
                                                            {{ $representative->getCurrentHoldingAmountAttribute() }}
                                                            <i class=" la la-dollar"></i>
                                                        </h3>

                                                    </div>

                                                </div>
                                                {{-- <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                    <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%"
                                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- </a> --}}
                                </div>
                            @endforeach
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mx-3 mt-2">
                                <div>
                                    <h5 class="mx-2">{{ __('translation.orders') }}</h5>
                                </div>
                                @if (count($ids) > 0)
                                    <div>
                                        <form id='shiping_orders_form' action="{{ route('preShiping') }}"
                                            method="GET" style="display: inline-block">
                                            <input type="hidden" name='ids' wire:model='json_ids' />

                                            <input type="hidden" name='shiping_type' wire:model='shiping_type' />

                                            <a href='#' data-toggle="modal" data-target="#showModal"
                                                class="btn btn-round btn-light btn-sm" type="button">
                                                <i class="la  la-sync"></i>
                                                {{ __('translation.sync_with_shipping_company') }} </button>
                                            </a>
                                        </form>

                                        <form action="{{ route('print_shiping_invoices') }}" method="GET"
                                            style="display: inline-block">
                                            @csrf
                                            <input type="hidden" name='ids' wire:model='json_ids' />
                                            <button class="btn btn-round btn-warning btn-sm" type="submit">
                                                <i class="la la-print la-sm"></i>
                                                {{ __('translation.print_shipping_invoice') }}</button>
                                        </form>

                                        <form action="{{ route('print.invoices') }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            <input type="hidden" name='ids' wire:model='ids' />
                                            <button type='submit' class="btn btn-round btn-light btn-sm"
                                                type="button"><i class="la la-print la-sm"></i>
                                                {{ __('translation.print.orders') }} </button>
                                        </form>


                                        <form method="POST" style="display: inline-block">
                                            @csrf
                                            <input type="hidden" name='ids' wire:model='ids' />
                                            <button data-toggle="modal" data-target="#exampleModal"
                                                class="btn btn-round btn-warning btn-sm" type="button">
                                                {{ __('translation.status.change.orders') }}</button>
                                        </form>




                                    </div>
                                @endif
                            </div>

                            <div class="card-content collapse show">

                                {{-- end prefix section --}}
                                <div class="HiddenInPrint">
                                    <div class="d-flex justify-content-between px-5 py-1 ">
                                        <h3>
                                            <span>
                                                {{ $representativeModel->fullname ?? ' -' }}
                                            </span>

                                        </h3>
                                        <div>
                                            <script>
                                                function Print() {
                                                    var divContents = document.getElementById("card-dashboard").innerHTML;
                                                    var styles = document.getElementById("inline_style").innerHTML;
                                                    var header = document.querySelector('head').innerHTML;
                                                    var a = window.open('', '', 'height=1000, width=5500');
                                                    a.document.write('<html>');
                                                    a.document.write(header);
                                                    a.document.write('<style>');
                                                    a.document.write('html, body , html body {background:#fff; padding:10px}');
                                                    a.document.write(styles);
                                                    a.document.write('</style>');
                                                    a.document.write(divContents);
                                                    a.document.write('</body></html>');
                                                    a.onload = function() {
                                                        a.document.querySelectorAll(".hidden_in_print").forEach(function(element) {
                                                            element.parentNode.removeChild(element);
                                                        });
                                                        a.print();
                                                    };
                                                    a.document.close();
                                                    // console.log(a.document.readyState === "complete" || a.document.readyState === "interactive");
                                                }
                                            </script>
                                            @if ($representativeModel)
                                                <button onclick="Print()" href="#tab42"
                                                    class="btn btn-sm btn-primary">
                                                    {{-- <i class="la  la-sm la-print"></i> --}}
                                                    {{ __('translation.print') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body card-dashboard" id="card-dashboard">
                                    <div class="d-flex justify-content-between align-items-center inprintOnly">



                                        {{-- prefrix the print section --}}
                                        <div class="d-flex justify-content-between align-items-center ">
                                            <div class="col-md-12  p-2">
                                                <div class="col-md-12">
                                                    <h3> <b>{{ __('translation.name.of.company') }}</b> :
                                                        {{ '  ' . $OrganizationProfile->name }} </h3>
                                                    <h3>
                                                        <span><b>{{ __('translation.representative') }} :</b></span>
                                                        <span>
                                                            {{ $representativeModel->fullname ?? '-' }}
                                                        </span>
                                                        {{-- @dd($ClientStatementIsues->status); --}}
                                                    </h3>
                                                    <h3>
                                                        <span><b>{{ __('translation.phone') }} :</b></span>
                                                        <span style="dir:ltr;">
                                                            {{ $representativeModel->phone ?? '-' }}
                                                        </span>
                                                        {{-- @dd($ClientStatementIsues->status); --}}
                                                    </h3>
                                                    <h3>
                                                        <span><b>{{ __('translation.total.fees') }} :</b></span>
                                                        <span>
                                                            {{ $representativeModel?->getCurrentHoldingAmountAttribute()?? 0  }}
                                                        </span>
                                                        {{-- @dd($ClientStatementIsues->status); --}}
                                                    </h3>
                                                    <h3>
                                                        <span><b>{{ __('translation.issue_date') }} :</b></span>
                                                        <span>
                                                            {{ '  ' . date('d-m-Y') }}
                                                        </span>
                                                    </h3>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-between  align-items-center my-1">
                                            <div class="col-md-4  p-2 text-right ">
                                                <div class="imgContinaer text-right ">
                                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('uploads/' . $OrganizationProfile->logo))) }}"
                                                        alt="Company Logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @include('includes.dashboard.notifications')

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>

                                                    <td style="width: 3px!important" class="hidden_in_print">
                                                        <div class="form-group">
                                                            !!!
                                                    </td>
                                                    <th style="width: 3px">الرقم</th>
                                                    <th>{{ __('translation.invoice.no') }}</th>
                                                    <th>{{ __('translation.order.date') }}</th>
                                                 <th>{{ __('translation.service') }}</th>
                                                      {{--  <th>{{ __('translation.client') }}</th> --}}
                                                    <th>{{ __('translation.phone') }}</th>

                                                    <th class="hidden_in_print">{{ __('translation.representative') }}</th>
                                                    {{-- <th>المبلغ تحت الحساب</th> --}}


                                                    <th>{{ __('translation.sender.name') }}</th>
                                                    <th>{{ __('translation.receiver.name') }}</th>
                                                    <th>{{ __('translation.total.fees') }}</th>
                                                    <th>{{ __('translation.status') }}</th>
                                                    <th class="hidden_in_print">{{ __('translation.order.transfer') }}
                                                    </th>
                                                    <th class="hidden_in_print">{{ __('translation.status.change') }}
                                                    </th>
                                                    <th class="hidden_in_print">{{ __('translation.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data) > 0)
                                                    @foreach ($data as $key => $order)
                                                        <tr>
                                                            <td style="width: 3px !important" class="hidden_in_print">
                                                                <div class="form-group">

                                                                    <input type="checkbox" class="form-control"
                                                                        wire:change="uppendToids({{ $order->id }})"
                                                                        value='{{ $order->id }}' id=""
                                                                        aria-describedby="helpId" placeholder="">
                                                                </div>
                                                            </td>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $order->tracking_number }}</td>

                                                            <td>{{ $order->order_date }}</td>
                                                            <td>{{ $order->service->name }}</td>
                                                           {{--  <td>{{ $order->client->fullname ?? '--' }}</td> --}}
                                                            <td>{{ $order->client->phone }}</td>

                                                            <td class="hidden_in_print">{{ $order->representative->fullname ?? ' -- ' }}</td>
                                                            {{-- <td>

                                                                @if ($order->representative)
                                                                    {{ $order->representative->getCurrentHoldingAmountAttribute() }}
                                                                @else
                                                                    0
                                                                @endif
                                                            </td> --}}


                                                            <td>{{ $order->sender_name }}</td>
                                                            <td>{{ $order->receiver_name }}</td>
                                                            <td>{{ $order->order_value }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge @switch($order->status)
                                                        @case('pending')
                                                            badge-warning
                                                            @break
                                                        @case('pickup')
                                                            badge-secondary
                                                            @break
                                                        @case('inProgress')
                                                            badge-primary
                                                            @break
                                                        @case('delivered')
                                                            badge-info
                                                            @break
                                                        @case('completed')
                                                            badge-success
                                                            @break
                                                        @case('canceled')
                                                            badge-danger
                                                            @break

                                                        @default

                                                    @endswitch ">{{ __('translation.' . $order->status) }}</span>
                                                                {{-- {{ $order->status }}</td> --}}
                                                            <td class="hidden_in_print">
                                                                <select wire:model="order_transfer_data"
                                                                    class="select2 orderTransferSelect2 form-control "
                                                                    style="width:150px">
                                                                    <option value="">
                                                                        {{ __('translation.select.representative') }}
                                                                    </option>
                                                                    @foreach ($representatives as $representative)
                                                                        <option
                                                                            @if ($representative->id == $order->representative_id) selected @endif
                                                                            value="{{ json_encode(['representative_id' => $representative->id, 'order_id' => $order->id]) }}">
                                                                            {{ $representative->fullname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hidden_in_print">
                                                                <select wire:model="status_change_data"
                                                                    class="form-control change-status"
                                                                    style="width:150px">
                                                                    <option value="">
                                                                        {{ __('translation.select.order.status') }}
                                                                    </option>
                                                                    <option
                                                                        @if ($order->status == 'pending') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'pending', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.pending') }}</option>
                                                                    <option
                                                                        @if ($order->status == 'pickup') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'pickup', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.pickup') }}</option>
                                                                    <option
                                                                        @if ($order->status == 'inProgress') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'inProgress', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.inProgress') }}</option>
                                                                    <option
                                                                        @if ($order->status == 'delivered') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'delivered', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.delivered') }}</option>
                                                                    <option
                                                                        @if ($order->status == 'completed') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'completed', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.completed') }}</option>
                                                                    {{-- <option
                                                                        @if ($order->status == 'returned') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'returned', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.returned') }}</option>
                                                                    <option
                                                                        @if ($order->status == 'canceled') selected = "true" @endif
                                                                        value="{{ json_encode(['status' => 'canceled', 'order_id' => $order->id]) }}">
                                                                        {{ __('translation.canceled') }}</option> --}}
                                                                </select>
                                                            </td>
                                                            <td class="hidden_in_print">
                                                                <button data-toggle="modal"
                                                                    data-target="#showModal{{ $order->id }}"
                                                                    class="btn btn-sm btn-icon
                                                                    btn-info"><i
                                                                        class="la la-info"></i></button>
                                                            </td>
                                                        </tr>
                                                        <div wire:ignore.self
                                                            class="modal animated bounceInDown fade text-left"
                                                            id="showModal{{ $order->id }}" role="dialog"
                                                            aria-labelledby="myModalLabel35" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-info">
                                                                        <h3 class="modal-title white"
                                                                            id="myModalLabel35">
                                                                            {{ __('translation.order.show') }}
                                                                            ({{ $order->id }})
                                                                        </h3>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h4 class="form-section"><i
                                                                                        class="la la-pencil-square-o"></i>
                                                                                    {{ __('translation.service.info') }}
                                                                                </h4>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.service') }}
                                                                                            : </b>

                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->service->name }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.client') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->client->fullname ?? '--' }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <h4 class="form-section"><i
                                                                                        class="la la-pencil-square-o"></i>
                                                                                    {{ __('translation.area.info') }}
                                                                                </h4>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.sender.name') }}
                                                                                            : </b>

                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->sender_name }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-7 p-0">
                                                                                        <b>{{ __('translation.sender.phone.no') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-5 p-0">
                                                                                        {{ $order->sender_phone }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.sender.area') }}
                                                                                            : </b>

                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        {{ $order->senderArea->name }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.sender.sub.area') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        {{ $order->senderSubArea->name }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.sender.address') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->sender_address }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.receiver.name') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->receiver_name }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-7 p-0">
                                                                                        <b>{{ __('translation.receiver.phone.no') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-5 p-0">
                                                                                        {{ $order->receiver_phone_no }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.receiver.area') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        {{ $order->receiverArea->name ?? '--' }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.receiver.sub.area') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        {{ $order->receiverSubArea->name ?? '---' }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4 p-0">
                                                                                        <b>{{ __('translation.receiver.address') }}
                                                                                            :
                                                                                        </b>
                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->receiver_address }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <h4 class="form-section"><i
                                                                                        class="la la-pencil-square-o"></i>
                                                                                    {{ __('translation.management.info') }}
                                                                                </h4>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.representative') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->representative->fullname ?? '-- ' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <b>{{ __('translation.status') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        {{ __('translation.' . $order->status) }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.delivery.fees') }}
                                                                                            :
                                                                                        </b>

                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        {{ $order->delivery_fees }}

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.order.fees') }}
                                                                                            : </b>

                                                                                    </div>
                                                                                    <div class="col-4">

                                                                                        {{ $order->order_fees }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-5">
                                                                                        <b>{{ __('translation.total.fees') }}
                                                                                            : </b>

                                                                                    </div>
                                                                                    <div class="col-7">
                                                                                        {{ $order->total_fees }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.order.date') }}
                                                                                            : </b>
                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ date('Y-m-d h:m:s', strtotime($order->order_date)) }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <b>{{ __('translation.payment.method') }}
                                                                                            :
                                                                                        </b>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        {{ __('translation.' . $order->payment_method) }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-2">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <b>{{ __('translation.representative.deserves') }}
                                                                                            : </b>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        {{ $order->representative_deserves }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-5">
                                                                                        <b>{{ __('translation.company.deserves') }}:
                                                                                        </b>
                                                                                    </div>
                                                                                    <div class="col-7">
                                                                                        {{ $order->company_deserves }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.delivery.date') }}
                                                                                            :
                                                                                        </b>
                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        {{ $order->delivery_date ? $order->delivery_date : '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <b>{{ __('translation.police.file') }}
                                                                                            :
                                                                                        </b>
                                                                                    </div>
                                                                                    <div class="col-8">
                                                                                        @if ($order->police_file)
                                                                                            <a
                                                                                                href="{{ asset('uploads/' . $order->police_file) }}">
                                                                                                <i
                                                                                                    class="la la-link"></i>{{ __('translation.police.file') }}
                                                                                            </a>
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="20`">{{ __('translation.table.empty') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            {{-- <tfoot>
                                                <tr>
                                                    <td style="width: 3px!important" class="hidden_in_print">
                                                        <div class="form-group">
                                                            !!!
                                                    </td>
                                                    <th style="width: 3px">{{ __('translation.No') }}</th>
                                                    <th>{{ __('translation.invoice.no') }}</th>
                                                    <th>{{ __('translation.order.date') }}</th>
                                                    <th>{{ __('translation.service') }}</th>
                                                    <th>{{ __('translation.client') }}</th>
                                                    <th>{{ __('translation.representative') }}</th>
                                                    <th>{{ __('translation.sender.name') }}</th>
                                                    <th>{{ __('translation.receiver.name') }}</th>
                                                    <th>{{ __('translation.total.fees') }}</th>
                                                    <th>{{ __('translation.status') }}</th>
                                                    <th class="hidden_in_print">
                                                        {{ __('translation.order.transfer') }}</th>
                                                    <th class="hidden_in_print">{{ __('translation.status.change') }}
                                                    </th>
                                                    <th class="hidden_in_print">{{ __('translation.action') }}</th>
                                                </tr>
                                            </tfoot> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! $data->links() !!}
            </section>
        </div>

        <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="showModal" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h3 class="modal-title white" id="myModalLabel35">
                            {{ __('translation.sync_with_shipping_company') }}
                        </h3>

                        <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">{{ __('translation.chose_the_shiping_company') }}</label>
                            <select class="form-control" wire:model='shiping_type' name="" id="">
                                <option value='sama' selected> SMSA Company </option>
                                <option value='smsa2'> Smas Comany 2 </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input wire:click.prevent="cancel()" type="reset" class="btn btn-outline-secondary "
                            data-dismiss="modal" value="{{ __('translation.cancel') }}">
                        <a class='btn btn-success text-white'
                            onclick="document.getElementById('shiping_orders_form').submit()">
                            {{ __('translation.shipping') }} </a>

                    </div>

                </div>
            </div>
        </div>
        {{-- <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="FeesCollection" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h3 class="modal-title white" id="myModalLabel35"> {{ __('translation.collacation_Lable')  }}

                        </h3>
                        <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="MakeCollectionForRep()">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="form-section"><i class="la la-pencil-square-o"></i>
                                        {{ __('translation.orders.details') }}
                                    </h4>
                                </div>
                                 <div class="col-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 3px">{{ __('translation.No') }}</th>
                                                <th>{{ __('translation.order.date') }}</th>
                                                <th>{{ __('translation.service') }}</th>
                                                <th>{{ __('translation.client') }}</th>
                                                <th>{{ __('translation.representative') }}</th>
                                                <th>{{ __('translation.total.fees') }}</th>
                                                <th>{{ __('translation.action') }}</th>
                                                <th>{{ __('translation.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($RepCollectionData) > 0)
                                                @foreach ($RepCollectionData as $key => $order)
                                                    <tr>
                                                        <td>{{ $order->tracking_number }}</td>
                                                        <td>{{ $order->order_date }}</td>
                                                        <td>{{ $order->service->name }}</td>
                                                        <td>{{ $order->client->fullname ?? ('--' ?? '-') }}</td>
                                                        <td>{{ $order->representative->fullname ?? ' - ' }}</td>

                                                        @if ($order->order_value == null)
                                                            <td>0</td>
                                                        @else
                                                            <td>{{ $order->order_value }}</td>
                                                        @endif


                                                        <td>

                                                            <div class="container">

                                                                <!-- Trigger the modal with a button -->
                                                                <button type="button" class="btn btn-danger"
                                                                    data-toggle="modal" data-target="#myModal">طريقة
                                                                    الدفع</button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="myModal" role="dialog">
                                                                    <div class="modal-dialog">

                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">

                                                                                <h4 class="modal-title">طريقة الدفع
                                                                                </h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>طريقة الدفع
                                                                                    :{{ $order->payment_method }}</p>
                                                                                <p>رقم التحويل
                                                                                    :{{ $order->transfer_number }}</p>

                                                                                <div
                                                                                    class="row h-100 justify-content-center align-items-center">
                                                                                    <p>صورة من الفاتورة</p>
                                                                                </div>
                                                                                <div
                                                                                    class="row h-100 justify-content-center align-items-center">
                                                                                    <img src="/uploads/{{ $order->image }}"
                                                                                        class="img-rounded"
                                                                                        alt="Cinque Terre"
                                                                                        width="304" height="236"
                                                                                        algin="center">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </td>
                                                        <td>
                                                            <input type="checkbox" value="{{ $order->client_id }}"
                                                                wire:model="checked_orders.{{ $order->id }}"
                                                                class="">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="10">{{ __('translation.table.empty') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th class="text-center">{{ __('translation.total.fees') }}
                                                </th>
                                                <th>{{ $order_value }}</th>
                                                <th>

                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                 </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input wire:click.prevent="cancel()" type="reset"
                                class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                                value="{{ __('translation.cancel') }}">
                                <button wire:click="MakeCollectionForRep" type="subamit" class="btn btn-outline-info btn-lg"">
                                    {{ __('translation.collect') }}
                                </button>

                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="FeesCollection" role="dialog"
            aria-labelledby="myModalLabel35" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h3 class="modal-title white" id="myModalLabel35">{{ __('translation.collacation_Lable') }}
                        </h3>
                        <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="MakeCollectionForRepnew">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="form-section"><i
                                            class="la la-pencil-square-o"></i>{{ __('translation.orders.details') }}
                                    </h4>
                                </div>
                                <div class="col-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" wire:model="allSelected" value="all"
                                                        wire:click="toggleSelectAll" />
                                                </th>
                                                <th>{{ __('translation.No') }}</th>
                                                <th>{{ __('translation.order.date') }}</th>
                                                <th>{{ __('translation.service') }}</th>
                                                <th>{{ __('translation.client') }}</th>
                                                <th>{{ __('translation.representative') }}</th>
                                                <th>{{ __('translation.total.fees') }}</th>
                                                <th>{{ __('translation.payment_method') }}</th>
                                                <th>{{ __('translation.cash_amount') }}</th>
                                                <th>{{ __('translation.E_transfer_amount') }}</th>
                                                <th>{{ __('translation.E_transfer_number') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($RepCollectionData as $index => $order)
                                                @php
                                                    $isCashAmountDisabled =
                                                        isset($disabled[$index]['cash_amount']) &&
                                                        $disabled[$index]['cash_amount'];
                                                    $isTransferAmountDisabled =
                                                        isset($disabled[$index]['E_transfer_amount']) &&
                                                        $disabled[$index]['E_transfer_amount'];
                                                    $isBothDisabled =
                                                        $isCashAmountDisabled && $isTransferAmountDisabled;
                                                @endphp
                                                <tr>

                                                    <td>
                                                        <input type="checkbox" wire:model="selectedOrders"
                                                            value="{{ $order->id }}" />
                                                    </td>

                                                    <td>{{ $order->tracking_number }}</td>
                                                    <td>{{ $order->order_date }}</td>
                                                    <td>{{ $order->service->name }}</td>
                                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                                    <td>{{ $order->representative->fullname ?? '-' }}</td>
                                                    <td>{{ $order->order_value ?? '0' }} <input type="hidden"
                                                            value="{{ $order->order_value ?? '0' }}"
                                                            wire:model="RepCollectionData.{{ $index }}.rowTotal">
                                                    </td>

                                                    <td>
                                                        <select
                                                            wire:model="RepCollectionData.{{ $index }}.COD_payment_method">
                                                            <option selected value="">---</option>
                                                            <option value="cash">Cash</option>
                                                            <option value="transfer">Transfer</option>
                                                            <option value="cash & transfer">Cash & Transfer</option>
                                                        </select>
                                                        @if ($errors->has("RepCollectionData.$index.COD_payment_method"))
                                                            <div class="text-danger">
                                                                {{ __('translation.reqired') }}
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <input type="number"
                                                            wire:model="RepCollectionData.{{ $index }}.cash_amount"
                                                            step="0.01"
                                                            @if (
                                                                $RepCollectionData[$index]['COD_payment_method'] === 'transfer' ||
                                                                    $RepCollectionData[$index]['COD_payment_method'] === '') disabled @endif>
                                                        @if ($errors->has("RepCollectionData.$index.cash_amount"))
                                                            <div class="text-danger">
                                                                {{ __('translation.reqired') }}
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <input type="number"
                                                            wire:model="RepCollectionData.{{ $index }}.E_transfer_amount"
                                                            step="0.01"
                                                            @if (
                                                                $RepCollectionData[$index]['COD_payment_method'] === 'cash' ||
                                                                    $RepCollectionData[$index]['COD_payment_method'] === '') disabled @endif>
                                                        @if ($errors->has("RepCollectionData.$index.E_transfer_amount"))
                                                            <div class="text-danger">
                                                                {{ __('translation.reqired') }}
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <input type="text"
                                                            wire:model="RepCollectionData.{{ $index }}.E_transfer_number">
                                                        @if ($errors->has("RepCollectionData.$index.E_transfer_number"))
                                                            <div class="text-danger">
                                                                {{ __('translation.reqired') }}
                                                            </div>
                                                        @endif
                                                    </td>


                                                </tr>
                                            @empty
                                                <tr class="text-center">
                                                    <td colspan="11">{{ __('translation.table.empty') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" class="text-right"> </th>
                                                <th>{{ number_format($totalFees, 2) }}</th>
                                                <th> </th>
                                                <th>{{ number_format($totalCash, 2) }}</th>
                                                <th>{{ number_format($totalTransfer, 2) }}</th>
                                                <th></th> <!-- Assuming there's an action column -->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- Display validation errors within the modal -->

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @if ($errors->has('totalFees'))
                                            <li>يجب ان يتساوي مجموع التحويل و الكاش مع اجمالي قيمه الدفع عند التسليم
                                            </li>
                                            <li>{{ $errors->first('totalFees') }}</li>
                                        @endif

                                        @if ($errors->has('no_selected_rows'))
                                            <li>{{ $errors->first('no_selected_rows') }}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <input wire:click.prevent="cancel()" type="reset"
                                class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                                value="{{ __('translation.cancel') }}">
                            <button wire:click="MakeCollectionForRepnew" type="submit"
                                class="btn btn-outline-info btn-lg">{{ __('translation.collect') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('translation.status.change.orders') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('translation.status.change.orders') }}</label>
                        <select name="status" wire:model='NewStatus' class="form-control">
                            <option value="pending">---</option>

                            @foreach ($Status as $status)
                                <option value="{{ $status }}">{{ __('translation.' . $status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-dismiss="modal">{{ __('translation.cancel') }}</button>
                    <button type="button" class="btn btn-sm btn-primary"
                        wire:click="ChangeOrdersStatus()">{{ __('translation.status.change') }}</button>
                </div>
            </div>
        </div>
    </div>


</div>



@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            window.livewire.on('hidemodel', () => {
                $('#exampleModal').modal('hide');
                $('#ChaneRep').modal('hide');
            });
            // window.livewire.on('status_change_confirmation', (status_change_data) => {
            //     // console.log(e.target.value);
            //     Swal.fire({
            //         title: '{{ __('translation.status.change') }}',
            //         text: '{{ __('translation.status.change.confirmation.text') }}',
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#aaa',
            //         confirmButtonText: '{{ __('translation.yes') }}',
            //         cancelButtonText: '{{ __('translation.cancel') }}'
            //     }).then((result) => {
            //         //if user clicks on delete
            //         if (result.value) {
            //             // calling destroy method to delete
            //             // @this.set('status_change_data', e.target.value);
            //             @this.emit('status_change_confirmed', status_change_data)
            //             // success response
            //             // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            //         } else {
            //             Swal.fire({
            //                 title: '{{ __('translation.operation.canceled') }}',
            //                 icon: 'success'
            //             });
            //         }
            //     });
            // });
            // window.livewire.on('status_change_to_pending_confirmation', (status_change_data) => {
            //     // console.log(e.target.value);
            //     Swal.fire({
            //         title: '{{ __('translation.status.change') }}',
            //         text: '{{ __('translation.status.change.to.pending.confirmation.text') }}',
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#aaa',
            //         confirmButtonText: '{{ __('translation.yes') }}',
            //         cancelButtonText: '{{ __('translation.cancel') }}'
            //     }).then((result) => {
            //         //if user clicks on delete
            //         if (result.value) {
            //             // calling destroy method to delete
            //             // @this.set('status_change_data', e.target.value);
            //             @this.emit('status_change_confirmed', status_change_data)
            //             // success response
            //             // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            //         } else {
            //             Swal.fire({
            //                 title: '{{ __('translation.operation.canceled') }}',
            //                 icon: 'success'
            //             });
            //         }
            //     });
            // });
            // window.livewire.on('representative_change_confirmation', (order_transfer_data) => {
            //     // console.log(e.target.value);
            //     Swal.fire({
            //         title: '{{ __('translation.representative.change') }}',
            //         text: '{{ __('translation.representative.change.confirmation.text') }}',
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#aaa',
            //         confirmButtonText: '{{ __('translation.yes') }}',
            //         cancelButtonText: '{{ __('translation.cancel') }}'
            //     }).then((result) => {
            //         //if user clicks on delete
            //         if (result.value) {
            //             // calling destroy method to delete
            //             // @this.set('status_change_data', e.target.value);
            //             Livewire.emit('representative_change_confirmed', order_transfer_data);
            //             // success response
            //             // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            //         } else {
            //             Swal.fire({
            //                 title: '{{ __('translation.operation.canceled') }}',
            //                 icon: 'success'
            //             });
            //         }
            //     });
            // });
            window.livewire.on('stored', () => {
                $('#AddModal').modal('hide');
            });
            window.livewire.on('updated', () => {
                $('#updateModal').modal('hide');
            });

            window.livewire.on('CollectionComplted', () => {
                $('#FeesCollection').modal('hide');
            });

        })
        // representativeSelect2
        $('.representativeSelect2').select2();
        $('.representativeSelect2').on('change', function(e) {
            @this.set('representative_id', e.target.value);
        });
        // orderTransferSelect2
        $('.orderTransferSelect2').select2({
            width: '200'
        });
        $('.orderTransferSelect2').on('change', function(e) {
            @this.set('order_transfer_data', e.target.value);
        });
        window.Livewire.on('select2', function() {
            $('.select2').select2();
            $('.orderTransferSelect2').select2({
                width: '200'
            });
            $('.orderTransferSelect2').on('change', function(e) {
                @this.set('order_transfer_data', e.target.value);
            });

        })

        function showPass($num) {
            $('.iconLeft3').attr('type', 'text');
        }
    </script>
@endpush
