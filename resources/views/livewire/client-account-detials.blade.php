<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.management')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('cient_orders') }}
                    </div>
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
                                            <fieldset wire:ignore.self class="form-group posision-relative">
                                                <label for="">{{__('translation.search')}}</label>
                                                  <select class="form-control select2"  id="clients-select">
                                                  </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group posision-relative">
                                              <label for="">{{ __('translation.status') }}</label>
                                              <select class="form-control " wire:model='status_filter' id="">
                                                <option>{{ __('translation.change_the_status') }}</option>
                                                @foreach (App\Models\Order::STATUS as $status)
                                                <option value='{{ $status }}'> {{  __('translation.' . $status) }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.from')}}</label>
                                                <input wire:model="from_date" placeholder="{{__('translation.from')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.to')}}</label>
                                                <input wire:model="to_date" placeholder="{{__('translation.to')}}"
                                                    type="date" class="form-control" id="date">
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
                                    <h5 class="mx-2">{{__('translation.orders')}}</h5>
                                </div>
                                @if (count($ids) > 0 )
                                <div>
                                    <form id='shiping_orders_form' action="{{route("preShiping")}}" method="GET" style="display: inline-block">
                                        <input type="hidden"  name='ids'
                                        wire:model='json_ids'/>

                                        <input type="hidden"  name='shiping_type'
                                        wire:model='shiping_type'/>

                                        <a href='#' data-toggle="modal" data-target="#showModal"   class="btn btn-round btn-light btn-sm" type="button">
                                            <i class="la  la-sync"></i>
                                            {{__('translation.sync_with_shipping_company')}} </button>
                                        </a>
                                        </form>
                                </div>
                                @endif
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>

                                                <td> <div class="form-group">
                                                    <input type="checkbox"
                                                      class="form-control" wire:change="uppendToids('all')"  id="" aria-describedby="helpId" placeholder="">
                                                  </div> </td>
                                                   <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.order.date')}}</th>
                                                <th>{{__('translation.service')}}</th>
                                                <th>{{__('translation.client')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $order)
                                            <tr>
                                                <td> <div class="form-group">
                                                  <input type="checkbox"
                                                    class="form-control" wire:change="uppendToids({{ $order->id }})" value='{{ $order->id }}' id="" aria-describedby="helpId" placeholder="">
                                                </div> </td>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>{{ $order->service->name }}</td>
                                                <td>{{ $order->client->fullname?? '--' }}</td>
                                                <td>{{ $order->representative ? $order->representative->fullname : '-'
                                                    }}
                                                </td>
                                                <td><span class="badge @switch($order->status)
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
                                                        @endswitch ">{{ __('translation.'.$order->status) }}</span>
                                                </td>
                                                <td>{{ $order->total_fees }}</td>
                                                <td>
                                                    <a href="{{route('print.invoice', $order->id)}}"
                                                        class="btn btn-sm btn-icon btn-warning"><i
                                                            class="la la-print"></i></a>
                                                    <a {{-- data-toggle="modal" data-target="#showModal --}}
                                                        href="{{ route('orders.show.details' , $order->id) }}"
                                                        class="btn btn-sm btn-icon
                                                        btn-info"><i class="la la-info"></i></a>
                                                    <button data-toggle="modal" data-target="#updateModal"
                                                        data-backdrop="static" data-keyboard="false"
                                                        wire:click="edit({{ $order->id }})" class="btn btn-sm btn-icon
                                                        btn-primary"><i class="la la-edit"></i></button>
                                                    <button data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{__('translation.delete')}}"
                                                        wire:click="$emit('triggerOrderDelete', {{$order->id}})"
                                                        class="btn btn-icon btn-danger btn-sm"><i
                                                            class="la la-trash"></i></button>
                                                    @if ($order->Shipping)
                                                    <a class='btn btn-sm btn-light' href='{{ route('print_shiping_invoice' , $order->id) }}'>{{ __('translation.print_shipping_invoice') }}</a>
                                                    @endif

                                                </td>
                                            </tr>

                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <div wire:ignore.self class="modal animated bounceInDown fade text-left"
                                        id="showModal" role="dialog"
                                        aria-labelledby="myModalLabel35" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h3 class="modal-title white" id="myModalLabel35">
                                                        {{__('translation.sync_with_shipping_company')}}
                                                    </h3>

                                                    <button type="button" wire:click.prevent="cancel()"
                                                        class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">{{ __('translation.chose_the_shiping_company') }}</label>
                                                        <select class="form-control"  wire:model='shiping_type' name="" id="">
                                                          <option  value='sama' selected> SMSA Company </option>
                                                          <option value='smsa2'> Smas Comany 2  </option>
                                                        </select>
                                                      </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input wire:click.prevent="cancel()" type="reset"
                                                        class="btn btn-outline-secondary "
                                                        data-dismiss="modal"
                                                        value="{{__('translation.cancel')}}">
                                                        <a class='btn btn-success text-white'
                                                        onclick="document.getElementById('shiping_orders_form').submit()"
                                                        > {{ __('translation.shipping') }}  </a>

                                                    </div>

                                                </div>
                                        </div>
                                    </div>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.order.date')}}</th>
                                                <th>{{__('translation.service')}}</th>
                                                <th>{{__('translation.client')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! $data->links() !!}
            </section>
@if($user_id)
{{-- @dd($->fullname); --}}
<div class="col-12">
                            <div class="card overflow-hidden">
                                <div class="card-content">
                                    <div class="card-body cleartfix ">
                                        <div class="row  align-center ">
                                            <div class="col-md-6 inprintOnly p-2">
                                                <div class="imgContinaer">
                                                    <h1> <b>{{ __('translation.name.of.company') }}</b> :
                                                        {{ $OrganizationProfile->name }} </h1>
                                                </div>
                                            </div>
                                            <div class="col-md-6  p-2 text-right inprintOnly">
                                                <div class="imgContinaer text-right inprintOnly">
                                                    <img src="{{ asset('uploads/' . $OrganizationProfile->logo) }}"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-1">
                                            <div class="d-flex justify-content-between">
                                                <h3 class="d-flex align-itmes-center">
                                                   <span>
                                                        {{-- {{ $select_client->fullname??'--' }} --}}
                                                    </span>
                                                </h3>
                                                <div class='d-none'>
                                                    {{-- <a href="#"
                                                        wire:click.prevent="ExportIssueToClient({{ $select_client->id }})"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('translation.issue') }}
                                                    </a> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table datatable table-striped table-bordered">
                                            <thead style="background:#d7e3bd">
                                                <tr>
                                                    <th class="text-center">
                                                    <div><h4  class="">Total</h4></div>
                                                    <div><h4  class="">{{ __('translation.service') }}</h4></div>
                                                    </th>
                                                    <th class="text-center">
                                                        <div><h4  class="">Qunitity</h4></div>
                                                        <div><h4  class="">{{ __('translation.qunitity') }}</h4></div>
                                                    </th>
                                                    <th class="text-center">
                                                        <div><h4  class="">Service Charges</h4></div>
                                                        <div><h4  class="">{{ __('translation.service_fees') }}</h4></div>
                                                    </th>
                                                    <th class="text-center">
                                                        <div><h4  class="">total</h4></div>
                                                        <div><h4  class="">{{ __('translation.total') }}</h4></div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalBlade = 0;
                                                    $DeliveryFess = [];
                                                    $totalOfService = 0;
                                                    $newOrder = $select_client->orders->groupBy('service_id');
                                                    $total_quntity = 0;
                                                    $total_of_fees = 0;
                                                @endphp
                                                {{-- @dd($newOrder); --}}
                                                @if (count($newOrder) > 0)
                                                    @foreach ($newOrder as $key => $newOrderCollection)
                                                        @if ($key == 1)
                                                        @php
                                                            $ServiceOne  = $newOrderCollection->filter(fn($item) => $item->order_value !=0);
                                                            $Cod  = $newOrderCollection->filter(fn($item) => $item->order_value ==0);
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
                                                                @if ($select_client->is_has_custom_price)
                                                                    @php
                                                                        $price = $select_client->ServicePrice->where('service_id', $key)->first()->price;
                                                                        echo $price;
                                                                    @endphp
                                                                @endif
                                                                @if (!$select_client->is_has_custom_price)
                                                                    @php
                                                                        $price = $Services->where('id', $key)->first()->price;
                                                                        echo $price;
                                                                    @endphp
                                                                @endif
                                                            </td>
                                                            <td> @php
                                                                $total_of_fees += count($ServiceOne) * $price;
                                                                echo count($ServiceOne) * $price ;
                                                                @endphp</td>
                                                        </tr>
                                                        @endif
                                                        @if (count($Cod) > 0)
                                                        <tr>
                                                            <td>{!!  $ServiceHeading[$Services->find($key)->id][1] !!}</td>
                                                            <td>
                                                                @php
                                                                    $total_quntity += count($Cod);
                                                                    echo count($Cod);
                                                                @endphp
                                                            </td>
                                                            <td>
                                                                @if ($select_client->is_has_custom_price)
                                                                    @php
                                                                        $price = $select_client->ServicePrice->where('service_id',$key) -> where('type','pickup')->first()->price;
                                                                        echo $price;
                                                                    @endphp
                                                                @endif
                                                                @if (!$select_client->is_has_custom_price)
                                                                    @php
                                                                        $price = $Services->where('id', $key)->first()->cod;
                                                                        echo $price;
                                                                    @endphp
                                                                @endif
                                                            </td>
                                                            <td> @php
                                                                $total_of_fees += count($Cod) * $price;
                                                                echo count($Cod) * $price ;
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
                                                                @if ($select_client->is_has_custom_price)
                                                                    @php
                                                                        $price = $select_client->ServicePrice->where('service_id', $key)->first()->price;
                                                                        echo $price;
                                                                    @endphp
                                                                @endif
                                                                @if (!$select_client->is_has_custom_price)
                                                                    @php
                                                                        $price = $Services->where('id', $key)->first()->price;
                                                                        echo $price;
                                                                    @endphp
                                                                @endif
                                                            </td>
                                                            <td> @php
                                                                $total_of_fees += count($newOrderCollection) * $price;
                                                                echo count($newOrderCollection) * $price ;
                                                                @endphp</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <h4>total </h4>
                                                            <h4>{{ __('translation.total')}} </h4>
                                                        </td>
                                                        <td>{{ $total_quntity }}</td>
                                                        <td> </td>
                                                        <td> {{ $total_of_fees}}</td>
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
                                                    <td><h4 >
                                                        {{ __('translation.s')}}</h4></td>
                                                    <td style="background:#d7e3bd"><h4>
                                                        {{-- @dd($Cod); --}}
                                                        {{ isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0}}
                                                    </h4></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <h4 class='text-right'>
                                                            Total Service Charges
                                                        </h4>
                                                    </td>
                                                    <td>
                                                        <h4>
                                                            {{ __('translation.total_fess_deserve')}}
                                                        </h4>
                                                    </td>
                                                    <td style='background:#d7e3bd'><h4>{{ $total_of_fees }}</h4></td>
                                                </tr>
                                                <tr>
                                                    {{-- <td colspan="2"></td> --}}
                                                    {{-- <td></td> --}}
                                                    {{-- @dd($Cod->sum('total_fees')); --}}
                                                    <td colspan="2"><h4 class='text-right'> net. Total </h4></td>
                                                    <td>
                                                        <h4>
                                                        {{ __('translation.free_total')}}
                                                        </h4>
                                                    </td>
                                                    <td style="background:#d7e3bd">
                                                    <h4>
                                                        {{ $total_of_fees - ( isset($ServiceOne) ? $ServiceOne->sum('order_value'): 0) }}
                                                    </h4>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                {{-- {!! $data->links() !!} --}}
            </section>
        </div>
        <button class="btn btn-primary d-none" wire:click='ExportIssueToClientWithCheckBoxs()'>
            {{ __('translation.issue') }}
        </button>
    @else
        <div class="card p-5">
            <div class="d-flex align-items-center justify-content-center ">
                <div>
                    <svg style="width:240px;height:240px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M20 17H22V15H20V17M20 7V13H22V7H20M11 9H16.5L11 3.5V9M4 2H12L18 8V20C18 21.11 17.11 22 16 22H4C2.89 22 2 21.1 2 20V4C2 2.89 2.89 2 4 2M13 18V16H4V18H13M16 14V12H4V14H16Z" />
                    </svg>
                    <h3>{{ __('translation.no_order_need_issue') }} !!</h3>
                </div>
            </div>
        </div>
    @endif
</div>
</div>
</div>
@push('scripts')
<script type="text/javascript">
    //delete order
document.addEventListener('DOMContentLoaded', function () {

    Livewire.hook('message.processed', (message, component) => {
        handelLivewireSelect();
})
    Livewire.on('triggerOrderDelete', order_id => {
        console.log('tregered!');
        Swal.fire({
            title: '{{__('translation.delete.confirmation.message')}}',
            text: '{{__('translation.delete.confirmation.text')}}',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: '{{__('translation.delete')}}'
        }).then((result) => {
            //if user clicks on delete
            if (result.value) {
                // calling destroy method to delete
                Livewire.emit('orderDelete', order_id)
                // success response
                // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            } else {
                Swal.fire({
                title: '{{__('translation.operation.canceled')}}',
                icon: 'success'
                });
            }
        });
    });



    window.livewire.on('stored', () => {
        $('#AddArea').modal('hide');
    });


    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });

    window.Livewire.on('select2', function(){
        $('.select2').select2();
    });

    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }


    $('.servicesSelect').select2();
    $('.servicesSelect').on('change', function (e) {
        console.log('jksa altignai osamn');
        @this.set('service_id', e.target.value);
    });



    $('.clientSelect2').select2();
        $('.clientSelect2').on('change', function (e) {
        @this.set('client_id', e.target.value);
        });
        // receiverAreaSelect2
        $('.receiverAreaSelect2').select2();
        $('.receiverAreaSelect2').on('change', function (e) {
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
        $('.receiverSubAreaSelect2').on('change', function (e) {
        @this.set('receiver_sub_area_id', e.target.value);
        });
        // senderAreaSelect2
        $('.senderAreaSelect2').select2();
        $('.senderAreaSelect2').on('change', function (e) {
        @this.set('sender_area_id', e.target.value);
             console.log(e.target.value);
        });
        // senderSubAreaSelect2
        $('.senderSubAreaSelect2').select2();
        $('.senderSubAreaSelect2').on('change', function (e) {
        @this.set('sender_sub_area_id', e.target.value);
        });
        // representativeSelect2
        $('.representativeSelect2').select2();
        $('.representativeSelect2').on('change', function (e) {
        @this.set('representative_id', e.target.value);
        });

        handelLivewireSelect();
        function handelLivewireSelect(){
            $( "#clients-select" ).select2({
  ajax: {
    url: "{{route('ClientAjaxSearch')}}",
    type: "get",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        search: params.term // search term
      };
    },
    processResults: function (response) {
      return {
        results: response
      };
    },
    cache: true
  }
});
        }

$( "#clients-select" ).on('change' , function(){
    // alert();
    @this.set('user_id' , $(this).val())
});
});

</script>
@endpush
