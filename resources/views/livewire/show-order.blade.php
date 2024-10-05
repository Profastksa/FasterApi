<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.orders.management') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">

                <div class="btn-group">
                    <button data-toggle="modal" data-target="#AddArea" class="btn btn-round btn-info" type="button"><i
                            class="la la-plus la-sm"></i>
                        {{ __('translation.add') }}</button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <fieldset class="form-group posision-relative">
                                                <label for="">{{ __('translation.search') }}</label>
                                                <input placeholder="{{ __('translation.search.by.order.id') }}"
                                                    wire:model="searchTerm" type="search" class="form-control"
                                                    id="search">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group posision-relative">
                                                <label for="">{{ __('translation.status') }}</label>
                                                <select class="form-control " wire:model='status_filter' id="">
                                                    <option value="">{{ __('translation.change_the_status') }}
                                                    </option>
                                                    @foreach (App\Models\Order::STATUS as $status)
                                                        <option value='{{ $status }}'>
                                                            {{ __('translation.' . $status) }}</option>
                                                    @endforeach
                                                    <option value="-1">{{ __('translation.deleted')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group posision-relative">
                                                <label for="">{{ __('translation.client') }}</label>
                                                <select class="form-control select2" wire:model='cleint_filter'
                                                    id="cleintfilter">
                                                    <option value="">{{ __('translation.client') }}
                                                    </option>
                                                    @foreach ($clients as $client)
                                                        <option value='{{ $client->id }}'>
                                                            {{ $client->fullname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="title">{{ __('translation.service') }}</label>
                                                <select class="form-control " wire:model='status_filter1'
                                                    id="">
                                                    <option value="">----</option>
                                                    @foreach ($services->where('is_active', 1) as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('service_id')
                                                    <span class="text-danger error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="title">خدمة العملاء</label>
                                                <input placeholder="  رقم هاتف العميل او المرسل او المستلم"
                                                    wire:model="coustmer_service_Filter" type="search"
                                                    class="form-control" id="search">
                                            </div>
                                        </div>



                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">{{ __('translation.from') }}</label>
                                                <input wire:model="from_date"
                                                    placeholder="{{ __('translation.from') }}" type="date"
                                                    class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">{{ __('translation.to') }}</label>
                                                <input wire:model="to_date" placeholder="{{ __('translation.to') }}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">عدد الطلبات للعرض </label>
                                                <input wire:model="paginatenum"
                                                    type="txt" class="form-control" id="paginatenum">
                                            </fieldset>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                                        <form action="{{ route('printPDF.invoices') }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        <input type="hidden" name='ids' wire:model='ids' />
                                        <button type='submit' class="btn btn-round btn-light btn-sm"
                                            type="button"><i class="la la-print la-sm"></i>
                                            {{ __('translation.print.orders') }} PDF </button>
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
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>

                                                    <td>
                                                        <div class="form-group">
                                                            <input type="checkbox" class="form-control"
                                                                wire:change="chkAll('all')" wire:model="all_toggler"
                                                                id="all" value='all'
                                                                aria-describedby="helpId" placeholder="">
                                                    </td>
                                                    {{-- <th style="width: 3px">{{ __('translation.No') }}</th> --}}
                                                    <th>{{ __('translation.invoice.no') }}</th>
                                                    <th>{{ __('translation.order.date') }}</th>
                                                    <th>{{ __('translation.service') }}</th>
                                                    <th>{{ __('translation.client') }}</th>
                                                    <th>الرمز</th>
                                                    <th>{{ __('translation.representative') }}</th>
                                                    <th>{{ __('translation.sender.name') }}</th>
                                                    <th>{{ __('translation.receiver.name') }}</th>
                                                    <th>الدفع عند الاستلام</th>

                                                    {{-- <th>{{ __('translation.service_fees') }}</th> --}}
                                                    <th>{{ __('translation.status') }}</th>
                                                    <th>{{ __('translation.order_source') }}</th>
                                                    <th>{{ __('translation.order_reference') }}</th>
                                                    <th>{{ __('translation.shipping') }}</th>
                                                    <th>{{ __('translation.shipping_date') }}</th>
                                                    <th>{{ __('translation.completed_at_date') }}</th>
                                                    <th>{{ __('translation.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data) > 0)
                                                    @foreach ($data as $key => $order)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">

                                                                    <input type="checkbox" class="form-control"
                                                                        wire:change="uppendToids({{ $order->id }})"
                                                                        wire:model="ids" value='{{ $order->id }}'
                                                                        id="chek_{{ $order->id }}"
                                                                        aria-describedby="helpId" placeholder="">
                                                                </div>
                                                            </td>
                                                            {{-- <td align ="center">{{ $order->id }}</td> --}}
                                                            <td>{{ $order->tracking_number }}</td>
                                                            <td>{{ $order->order_date }}</td>
                                                            <td>{{ $order->service->name }}</td>
                                                            <td>{{ $order->client->fullname ?? '--' }}</td>
                                                            <td>GIZ-{{ $order->client->id ?? 0 }}</td>
                                                            <td>{{ $order->representative ? $order->representative->fullname : '-' }}
                                                            </td>
                                                            <td>{{ $order->sender_name }}</td>
                                                            <td>{{ $order->receiver_name }}</td>

                                                            </td>
                                                            @if ($order->order_value == null)
                                                                <td>0</td>
                                                            @else
                                                                <td>{{ $order->order_value }}</td>
                                                            @endif


                                                            {{-- <td>{{ $order->delivery_fees }}</td> --}}



                                                            <td><span
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

                                                            @default
                                                            badge-danger
                                                        @endswitch ">{{ __('translation.' . $order->status) }}</span>
                                                            </td>


                                                            <td>
                                                                {!! $order->getOrderSourceStatus() !!}
                                                            </td>
                                                            <td>
                                                                {{ $order->orderRef }}
                                                            </td>
                                                            <td>
                                                                @if ($order->Shipping)
                                                                    {{ $order->Shipping->created_at }}
                                                                @endif

                                                            </td>
                                                            <td>
                                                                {{$order->completed_at  }}
                                                            </td>
                                                            <td>


                                                                @if ($order->Shipping)
                                                                    {{ $order->Shipping->refrence_id }}
                                                                    <br />
                                                                    <a class='btn btn-round btn-warning btn-sm'
                                                                       target="_blank"
                                                                       href='{{ route('print_shiping_invoice', $order->id) }}'>
                                                                        <i class="la la-print"></i>
                                                                        {{ __('translation.print_shipping_invoice') }}
                                                                    </a>
                                                                @elseif(!$order->Shipping)
                                                                    <form action="{{ route('preShiping') }}"
                                                                          method="GET" style="display: inline-block">

                                                                        <input type="hidden" name='ids'
                                                                               value="{{ encrypt([$order->id]) }}" />

                                                                        <input type="hidden" name='shiping_type'
                                                                               wire:model='shiping_type' />

                                                                        <button class="btn btn-round btn-light btn-sm"
                                                                                type="submit">
                                                                            <i class="la  la-sync"></i>
                                                                            {{ __('translation.sync_with_shipping_company') }}
                                                                        </button>

                                                                    </form>
                                                                @endif

                                                            </td>

                                                            <td>
                                                                <a href="{{ route('print.invoice', $order->id) }}"
                                                                    class="btn btn-sm btn-icon btn-warning"><i
                                                                        class="la la-print"></i></a>
                                                                <a {{-- data-toggle="modal" data-target="#showModal --}}
                                                                    href="{{ route('orders.show.details', $order->id) }}"
                                                                    class="btn btn-sm btn-icon
                                                                            btn-info"><i
                                                                        class="la la-info"></i></a>
                                                                <button data-toggle="modal" data-target="#updateModal"
                                                                    data-backdrop="static" data-keyboard="false"
                                                                    wire:click="edit({{ $order->id }})"
                                                                    class="btn btn-sm btn-icon btn-primary"><i class="la la-edit"></i></button>
                                                                <button data-toggle="tooltip" data-placement="top"
                                                                    data-original-title="{{ __('translation.delete') }}"
                                                                    wire:click="$emit('triggerOrderDelete', {{ $order->id }})"
                                                                    class="btn btn-icon btn-danger btn-sm"><i class="la la-trash"></i></button>


                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="18">{{ __('translation.table.empty') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <div wire:ignore.self class="modal animated bounceInDown fade text-left"
                                                id="showModal" role="dialog" aria-labelledby="myModalLabel35"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h3 class="modal-title white" id="myModalLabel35">
                                                                {{ __('translation.sync_with_shipping_company') }}
                                                            </h3>

                                                            <button type="button" wire:click.prevent="cancel()"
                                                                class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>

                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label
                                                                    for="">{{ __('translation.chose_the_shiping_company') }}</label>
                                                                <select class="form-control" wire:model='shiping_type'
                                                                    name="" id="">
                                                                    <option value='sama' selected> الربط مع سمسا
                                                                    </option>
                                                                    <option value='smsaWithSenderEdite'>
                                                                        الربط مع سمسا  و تخصيص بيانات  مرسل لكل طلب

                                                                    </option>
                                                                        <option value='smsaWithOneSenderEdite'> الربط مع سمسا
                                                                            و تخصيص بيانات  مرسل واحد </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input wire:click.prevent="cancel()" type="reset"
                                                                class="btn btn-outline-secondary "
                                                                data-dismiss="modal"
                                                                value="{{ __('translation.cancel') }}">
                                                            <a class='btn btn-success text-white'
                                                                onclick="document.getElementById('shiping_orders_form').submit()">
                                                                {{ __('translation.shipping') }} </a>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <tfoot>

                                            </tfoot>
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
    </div>

    {{-- <div class="content-header-right text-md-right col-md-6 col-12">
        <a href="{{ route('add_order') }}">
            <div class="btn-group">
                <button data-toggle="modal" data-target="#AddArea" class="btn btn-round btn-info" type="button"><i
                        class="la la-plus la-sm"></i>
                    {{ __('translation.add_order') }}</button>

            </div>
        </a>
    </div> --}}





    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="AddArea" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{ __('translation.order.add') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-pencil-square-o"></i>
                                    {{ __('translation.service.info') }}
                                </h4>
                            </div>
                            <div class="row col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('translation.service') }}</label>
                                        <select wire:model.defer="service_id"
                                            class="select2 servicesSelect form-control " style="width:100%">
                                            <option value="">----</option>
                                            @foreach ($services->whereIn('id', [1, 2, 3])->where('is_active', 1) as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('translation.client') }}</label>
                                        <select wire:model.defer="client_id"
                                            class="select2 clientSelect2 form-control " style="width:100%">
                                            <option value="">----</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->fullname }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-6 p-0 m-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('translation.representative') }}</label>
                                        <select wire:model.defer="representative_id"
                                            class="select2 representativeSelect2 form-control " style="width:100%">
                                            <option value="">----</option>
                                            @foreach ($representatives as $representative)
                                                <option value="{{ $representative->id }}">
                                                    {{ $representative->fullname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('representative_id')
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('translation.status') }}</label>
                                        <select wire:model.defer="status" class="  form-control " style="width:100%">
                                            <option value="">----</option>
                                            <option value="pending">{{ __('translation.pending') }} </option>
                                            <option value="pickup">{{ __('translation.pickup') }} - استلام</option>
                                            <option value="inProgress">{{ __('translation.inProgress') }} - تسليم
                                            </option>


                                        </select>
                                        @error('status')
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <fieldset class="form-group floating-label-form-group">
                                        <label for="email">{{__('translation.order.fees')}}</label>
                                        <input  type="text"
                                            wire:model.defer="order_fees" class="form-control" placeholder="">
                                        @error('order_fees') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </fieldset>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label for="title">{{__('translation.police.file')}}</label>
                                        <input id="police_file" type="file" wire:model.defer="police_file"
                                            class="form-control" placeholder="">
                                        @error('police_file') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </fieldset>
                                </div>
                             --}}

                            </div>
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-map-marker"></i>
                                    {{ __('translation.area.info') }}
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.sender.name') }}</label>
                                    <input type="text" wire:model.defer="sender_name" class="form-control"
                                        placeholder="">
                                    @error('sender_name')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.sender.phone.no') }}</label>
                                    <input type="text" wire:model.defer="sender_phone" class="form-control"
                                        placeholder="">
                                    @error('sender_phone')
                                        <span class="text-danger error">
                                            {{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            {{-- @dd($SenderSubArea) --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{-- @if ($service_id)
                                    @dd($areas)
                                    @endif --}}
                                    <label for="title">{{ __('translation.sender.area') }}</label>
                                    <select wire:model.defer="sender_area_id" wire:change='HandelCahnge()'
                                        class="select2 senderAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($SendingArea as $area)
                                            <option {{ $sender_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }} - ({{ $area->sub_areas_count }})</option>
                                        @endforeach
                                    </select>
                                    @error('sender_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.sender.sub.area') }}</label>
                                    <select wire:model.defer="sender_sub_area_id"
                                        class="select2 senderSubAreaSelect2 form-control" style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($SenderSubArea as $area)
                                            <option {{ $sender_sub_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sender_sub_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.sender.address') }}</label>
                                    <input type="text" wire:model.defer="sender_address" class="form-control"
                                        placeholder="">
                                    @error('sender_address')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.receiver.name') }}</label>
                                    <input type="text" wire:model.defer="receiver_name" class="form-control"
                                        placeholder="">
                                    @error('receiver_name')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.receiver.phone.no') }}</label>
                                    <input type="text" wire:model.defer="receiver_phone_no" class="form-control"
                                        placeholder="">
                                    @error('receiver_phone_no')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.receiver.area') }}</label>
                                    <select wire:model.defer="receiver_area_id"
                                        class="select2 receiverAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($ResevingArea as $area)
                                            <option {{ $receiver_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }} - ({{ $area->sub_areas_count }})</option>
                                        @endforeach
                                    </select>
                                    @error('receiver_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- @dd($ResevierSubArea); --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.receiver.sub.area') }}</label>
                                    <select wire:model.defer="receiver_sub_area_id"
                                        class="select2 receiverSubAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($ResevierSubArea as $area)
                                            <option {{ $receiver_sub_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('receiver_sub_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.receiver.address') }}</label>
                                    <input type="text" wire:model.defer="receiver_address" class="form-control"
                                        placeholder="">
                                    @error('receiver_address')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            {{-- <div class="col-md-3">
                                <fieldset class="form-group mt-3">
                                    <input type="checkbox" wire:model.defer="is_payment_on_delivery" class=""
                                        placeholder="">
                                    <label for="title">{{__('translation.payment.on.delivery')}}</label>
                                    @error('is_payment_on_delivery') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </fieldset>
                            </div> --}}
                        </div>
                        <div class="row">


                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.order.fees') }}</label>
                                    <input type="text" wire:model.defer="order_value" class="form-control"
                                        value="0" placeholder="" {{ $showCODPrice ? '' : 'disabled' }}>
                                    @error('order_value')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>


                            <div class='col-md-3'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.number_of_paces') }}</label>
                                    <input type="text" wire:model.defer="number_of_pieces" class="form-control"
                                        placeholder="" value="1">
                                    @error('number_of_pieces')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class='col-md-3'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.order_weight') }}</label>
                                    <input type="text" wire:model.defer="order_weight" class="form-control"
                                        placeholder="" value="5">
                                    @error('order_weight')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class='col-md-3'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.order_value_in_resved') }}</label>
                                    <input type="text" wire:model.defer="order_fees" value="100"
                                        class="form-control" placeholder="">
                                    @error('order_fees')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class='col-md-3'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.note') }}</label>
                                    <input type="text" wire:model.defer="orede_Note" class="form-control"
                                        placeholder="">
                                    @error('orede_Note')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                            value="{{ __('translation.cancel') }}">
                        <input type="submit" class="btn btn-outline-info btn-lg"
                            value="{{ __('translation.add') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="updateModal" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h3 class="modal-title white" id="myModalLabel35"> {{ __('translation.order.edit') }}
                        ({{ $order_id }})
                    </h3>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update()">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-pencil-square-o"></i>
                                    {{ __('translation.service.info') }}
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.service') }}</label>
                                    <select wire:model="service_id" class="select2 servicesSelect form-control"
                                        style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($services as $service)
                                            <option {{ $service_id == $service->id ? 'selected' : '' }}
                                                value="{{ $service->id }}">
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.client') }}</label>
                                    <select wire:model.defer="client_id" class="select2 clientSelect2 form-control "
                                        style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($clients as $client)
                                            <option {{ $client_id == $client->id ? 'selected' : '' }}
                                                value="{{ $client->id }}">
                                                {{ $client->fullname }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-map-marker"></i>
                                    {{ __('translation.area.info') }}
                                </h4>
                            </div>

                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.sender.name') }}</label>
                                    <input type="text" wire:model.defer="sender_name" class="form-control"
                                        placeholder="">
                                    @error('sender_name')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.sender.phone.no') }}</label>
                                    <input type="text" wire:model.defer="sender_phone" class="form-control"
                                        placeholder="">
                                    @error('sender_phone')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.sender.area') }}</label>
                                    <select wire:model.defer="sender_area_id"
                                        class="select2 senderAreaSelect2 form-control" style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($SendingArea as $area)
                                            <option {{ $sender_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }} - ({{ getSubAreaCountByAreaId($area->id) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sender_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.sender.sub.area') }}</label>
                                    <select wire:model.defer="sender_sub_area_id"
                                        class="select2 senderSubAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($sub_areas as $area)
                                            <option {{ $sender_sub_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sender_sub_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.sender.address') }}</label>
                                    <input type="text" wire:model.defer="sender_address" class="form-control"
                                        placeholder="">
                                    @error('sender_address')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.receiver.name') }}</label>
                                    <input type="text" wire:model.defer="receiver_name" class="form-control"
                                        placeholder="">
                                    @error('receiver_name')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-2">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.receiver.phone.no') }}</label>
                                    <input type="text" wire:model.defer="receiver_phone_no" class="form-control"
                                        placeholder="">
                                    @error('receiver_phone_no')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="col-md-2">
                                {{-- @dd($ResevingArea) --}}
                                <div class="form-group">
                                    <label for="title">{{ __('translation.receiver.area') }}</label>
                                    <select wire:model.defer="receiver_area_id"
                                        class="select2 receiverAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($ResevingArea as $area)
                                            <option {{ $receiver_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }} - ({{ getSubAreaCountByAreaId($area->id) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('receiver_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.receiver.sub.area') }}</label>
                                    <select wire:model.defer="receiver_sub_area_id"
                                        class="select2 receiverSubAreaSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($sub_areas as $area)
                                            <option {{ $receiver_sub_area_id == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">
                                                {{ $area->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('receiver_sub_area_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.receiver.address') }}</label>
                                    <input type="text" wire:model.defer="receiver_address" class="form-control"
                                        placeholder="">
                                    @error('receiver_address')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <h4 class="form-section"><i class="la la-pencil-square-o"></i>
                                    {{ __('translation.management.info') }}
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">{{ __('translation.representative') }}</label>
                                    <select wire:model.defer="representative_id"
                                        class="select2 representativeSelect2 form-control " style="width:100%">
                                        <option value="">----</option>
                                        @foreach ($representatives as $representative)
                                            <option {{ $representative_id == $representative->id ? 'selected' : '' }}
                                                value="{{ $representative->id }}">{{ $representative->fullname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('representative_id')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.order.fees') }}</label>
                                    <input type="text" wire:model.defer="order_value" class="form-control"
                                        {{ $showCODPrice ? '' : 'disabled' }} placeholder="">
                                    @error('order_value')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.delivery_fees') }}</label>
                                    <input type="text" wire:model.defer="delivery_fees" class="form-control"
                                        placeholder="">
                                    @error('delivery_fees')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>


                        </div>
                        <div class="row">
                            <div class='col-md-4'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.number_of_paces') }}</label>
                                    <input type="text" wire:model.defer="number_of_pieces" class="form-control"
                                        placeholder="">
                                    @error('number_of_pieces')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class='col-md-4'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.order_weight') }}</label>
                                    <input type="text" wire:model.defer="order_weight" class="form-control"
                                        placeholder="">
                                    @error('order_weight')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class='col-md-4'>
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="email">{{ __('translation.order_value_in_resved') }}</label>
                                    <input type="text" wire:model.defer="order_fees" class="form-control"
                                        placeholder="">
                                    @error('order_fees')
                                        <span class="text-danger error">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input wire:click.prevent="cancel()" type="reset" class="btn btn-outline-secondary btn-lg"
                            data-dismiss="modal" value="{{ __('translation.cancel') }}">
                        <input type="submit" class="btn btn-outline-info btn-lg"
                            value="{{ __('translation.edit') }}">
                    </div>
                </form>
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
</div>


@push('scripts')
    <script type="text/javascript">
        //delete order
        document.addEventListener('DOMContentLoaded', function() {

            window.livewire.on('hidemodel', () => {
                $('#exampleModal').modal('hide');
                $('#ChaneRep').modal('hide');
            });

            Livewire.on('triggerOrderDelete', order_id => {
                console.log('tregered!');
                Swal.fire({
                    title: '{{ __('translation.delete.confirmation.message') }}',
                    text: '{{ __('translation.delete.confirmation.text') }}',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: '{{ __('translation.delete') }}'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        Livewire.emit('orderDelete', order_id)
                        // success response
                        // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                    } else {
                        Swal.fire({
                            title: '{{ __('translation.operation.canceled') }}',
                            icon: 'success'
                        });
                    }
                });
            });

            window.livewire.on('storedError', () => {
                $('#AddArea').modal('hide');
            });

            window.livewire.on('stored', () => {
                //$('#AddArea').modal('hide');

                Swal.fire({
                    title: '{{ __('translation.item.created.successfully') }}',
                    icon: 'success'
                });
            });


            window.livewire.on('updated', () => {
                $('#updateModal').modal('hide');
            });

            window.Livewire.on('select2', function() {
                $('.select2').select2();
            });

            function showPass($num) {
                $('.iconLeft3').attr('type', 'text');
            }


            $('#cleintfilter').select2();
            $('#cleintfilter').on('change', function(e) {

                @this.set('cleint_filter', e.target.value);
            });

            $('.servicesSelect').select2();

            $('.servicesSelect').on('change', function(e) {

                @this.set('service_id', e.target.value);
            });



            $('.clientSelect2').select2();
            $('.clientSelect2').on('change', function(e) {
                @this.set('client_id', e.target.value);
            });
            // receiverAreaSelect2
            $('.receiverAreaSelect2').select2();
            $('.receiverAreaSelect2').on('change', function(e) {
                @this.set('receiver_area_id', e.target.value);
            });

            // Sending area -------------------------
            // $('.receiverAreaSelect2').select2();
            // $('.receiverAreaSelect2').on('change', function (e) {
            // @this.set('receiver_area_id', e.target.value);
            // });
            // sending are ---------------------
            // receiverSubAreaSelect2
            $('.receiverSubAreaSelect2').select2();
            $('.receiverSubAreaSelect2').on('change', function(e) {
                @this.set('receiver_sub_area_id', e.target.value);
            });
            // senderAreaSelect2
            $('.senderAreaSelect2').select2();
            $('.senderAreaSelect2').on('change', function(e) {
                @this.set('sender_area_id', e.target.value);
                console.log(e.target.value);
            });
            // senderSubAreaSelect2
            $('.senderSubAreaSelect2').select2();
            $('.senderSubAreaSelect2').on('change', function(e) {
                @this.set('sender_sub_area_id', e.target.value);
            });
            // representativeSelect2
            $('.representativeSelect2').select2();
            $('.representativeSelect2').on('change', function(e) {
                @this.set('representative_id', e.target.value);
            });

            $('.status').select2();
            $('.representativeSelect2').on('change', function(e) {
                @this.set('representative_id', e.target.value);
            });
        })

        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && !(checkboxes[i].disabled)) {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }


        // TO CHANGE SELECT2 CLIENT_ID VALUE
        // $(document).ready(function() {
        //     // clientSelect2

        // });
    </script>
@endpush
