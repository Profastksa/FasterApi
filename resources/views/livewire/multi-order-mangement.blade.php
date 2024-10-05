<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.management')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
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
                                        <div class="col-md-12">
                                            <form wire:submit.prevent='AddIdToIds'>
                                                <fieldset class="form-group posision-relative">
                                                    <label for="">{{__('translation.add_order_by_id')}}</label>
                                                    <input placeholder="{{__('translation.search.by.order.id')}}"
                                               wire:model="AddedID" type="search" class="form-control"   id="search">
                                                </fieldset>
                                                @error('AddedID')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </form>
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
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')
                                    <div class="d-flex justify-content-between my-1">
                                        <div>
                                            <h5 class="mx-2">{{__('translation.orders')}}</h5>
                                        </div>
                                        @if (count($orders) > 0 )
                                        <div>
                                            <form action="{{route('print.invoices')}}" method="POST" style="display: inline-block">
                                                @csrf
                                                <input type="hidden"  name='ids'
                                                wire:model='ids'/>
                                                <button type='submit' class="btn btn-round btn-light btn-sm" type="button"><i
                                                        class="la la-print la-sm"></i>
                                                    {{__('translation.print.orders')}} </button>
                                            </form>
                                            <button data-toggle="modal" data-target="#ChaneRep"
                                                class="btn btn-round btn-info btn-sm" type="button"><i
                                                    class="la la-user la-sm"></i>
                                                {{__('translation.ChangeRepreSentive')}}</button>

                                                <button

                                                onclick="confirmRetrive()"

                                                class="btn btn-round btn-success btn-sm" type="button">
                                                <i class="la las la-retweet"></i>
                                               استرجاع الطلبات من العميل</button>

                                                <button
                                                wire:click="ReturnOrderAfterDeliveryfailld()"
                                                class="btn btn-round btn btn-secondary" type="button">

                                                استرجاع الطلبات بعد محاولة التسليم</button>



                                                <button data-toggle="modal" data-target="#exampleModal"
                                                class="btn btn-round btn-warning btn-sm" type="button">
                                                {{__('translation.status.change.orders')}}</button>


                                                <button
                                                wire:click="ChangeOrdersStatus2()"
                                                class=" btn btn-outline-danger" type="button">

                                                 سحب </button>

                                        </div>
                                        @endif
                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 3px">{{__('translation.No')}}</th>

                                                <th>{{__('translation.invoice.no')}}</th>
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
                                            @if(count($orders) > 0)
                                            @foreach ($orders as $key => $order)
                                            <tr>
                                            <td>{{ $order->id }}</td>
                                                <td>{{ $order->tracking_number }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>{{ $order->service->name }}</td>

                                                <td>{{ $order->client->fullname?? '--' }}</td>
                                                <td>{{ $order->representative ? $order->representative->fullname : '-' }}
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
                                                <td>{{ $order->order_value }}</td>
                                                <td>

                                                    <button href="{{route('print.invoice', $order->id)}}"
                                                        class="btn btn-sm btn-icon btn-warning"><i
                                                            class="la la-print"></i></button>

                                                    <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}"
                                                        --}} href="{{ route('orders.show.details' , $order->id) }}"
                                                        class="btn btn-sm btn-icon
                                                        btn-info"><i class="la la-info"></i></a>
                                                    <button data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{__('translation.delete')}}"
                                                        wire:click="removeFromOrder({{$order->id}})"
                                                        class="btn btn-icon btn-danger btn-sm"><i
                                                            class="la la-trash"></i></button>
                                                </td>
                                            </tr>
                                            <div wire:ignore.self class="modal animated bounceInDown fade text-left"
                                                id="showModal{{$order->id}}" role="dialog"
                                                aria-labelledby="myModalLabel35" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h3 class="modal-title white" id="myModalLabel35">
                                                                {{__('translation.order.show')}} ({{$order->tracking_number}})
                                                            </h3>
                                                            <button type="button" wire:click.prevent="cancel()"
                                                                class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{__('translation.service.info')}}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.service')}} : </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->service->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.client')}} : </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->client->fullname?? '--'}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{__('translation.area.info')}}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.sender.name')}} : </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->sender_name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-7 p-0">
                                                                            <b>{{__('translation.sender.phone.no')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-5 p-0">
                                                                            {{$order->sender_phone}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.sender.area')}} : </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->senderArea->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.sender.sub.area')}} :
                                                                            </b>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->senderSubArea->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.sender.address')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->sender_address}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.receiver.name')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->receiver_name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-7 p-0">
                                                                            <b>{{__('translation.receiver.phone.no')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-5 p-0">
                                                                            {{$order->receiver_phone_no}}

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.receiver.area')}} :
                                                                            </b>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->receiverArea->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.receiver.sub.area')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->receiverSubArea->name}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4 p-0">
                                                                            <b>{{__('translation.receiver.address')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->receiver_address}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{__('translation.management.info')}}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.representative')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">

                                                                            {{$order->representative ?
                                                                            $order->representative->fullname : '--'}}

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <b>{{__('translation.status')}} : </b>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            {{__('translation.'.$order->status)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.delivery.fees')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{$order->delivery_fees}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{__('translation.order.fees')}} : </b>

                                                                        </div>
                                                                        <div class="col-4">

                                                                            {{$order->order_fees}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-5">
                                                                            <b>{{__('translation.total.fees')}} : </b>

                                                                        </div>
                                                                        <div class="col-7">
                                                                            {{$order->total_fees}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.order.date')}} : </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{date('Y-m-d
                                                                            h:m:s',strtotime($order->order_date))}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <b>{{__('translation.payment.method')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            {{__('translation.'.$order->payment_method)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.delivery.date')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{$order->delivery_date ?
                                                                            $order->delivery_date : "-"}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{__('translation.police.file')}} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            @if ($order->police_file)
                                                                            <a
                                                                                href="{{asset('uploads/'.$order->police_file)}}">
                                                                                <i
                                                                                    class="la la-link"></i>{{__('translation.police.file')}}
                                                                            </a>
                                                                            @else
                                                                            -
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input wire:click.prevent="cancel()" type="reset"
                                                                class="btn btn-outline-secondary btn-lg"
                                                                data-dismiss="modal"
                                                                value="{{__('translation.cancel')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
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
            </section>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('translation.status.change.orders')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{__('translation.status.change.orders')}}</label>
                        <select name="status" wire:model='NewStatus' class="form-control">
                            @foreach ($Status as $status )
                            <option value="{{$status}}">{{__('translation.'.$status)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-dismiss="modal">{{__('translation.cancel')}}</button>
                    <button type="button" class="btn btn-sm btn-primary"
                        wire:click="ChangeOrdersStatus()">{{__('translation.status.change')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self id="ChaneRep" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('translation.ChangeRepreSentive')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{__('translation.ChangeRepreSentive')}}</label>
                        <select name="status" wire:model='NewRep' class="form-control">
                            <option value="">{{__('translation.without_rep')}}</option>
                            @foreach ($reps as $rep )
                            <option value="{{$rep->id}}">{{ $rep->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-dismiss="modal">{{__('translation.cancel')}}</button>
                    <button type="button" class="btn btn-sm btn-primary"
                        wire:click='ChangeRep()'>{{__('translation.ChangeRepreSentive')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@push('scripts')
<script type="text/javascript">
    //delete order

function confirmRetrive(){
    Swal.fire({
            title: '{{__('translation.delete.confirmation.message')}}',
            text: '{{__('translation.retrive_order_confirmation_text')}}',
            // icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#28d094',
            cancelButtonColor: '#aaa',
            cancelButtonText: '{{ __('translation.cancel') }}',
            confirmButtonText: '{{__('translation.retrieving_orders')}}'
        }).then((result) => {
            //if user clicks on delete
            if (result.value) {
                // calling destroy method to delete
                // Livewire.emit('orderDelete', order_id)
                Livewire.emit('OrdesRetrive');
                // success response
                // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            } else {
                Swal.fire({
                title: '{{__('translation.operation.canceled')}}',
                icon: 'success'
                });
            }
        });
}


function confirmRetrive1(){
    Swal.fire({
            title: '{{__('translation.delete.confirmation.message')}}',
            text: '{{__('translation.retrive_order_confirmation_text')}}',
            // icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#28d094',
            cancelButtonColor: '#aaa',
            cancelButtonText: '{{ __('translation.cancel') }}',
            confirmButtonText: '{{__('translation.retrieving_orders')}}'
        }).then((result) => {
            //if user clicks on delete
            if (result ="5") {
                // calling destroy method to delete
                // Livewire.emit('orderDelete', order_id)
                Livewire.emit('OrdesRetrive');
                // success response
                // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
            } else {
                Swal.fire({
                title: '{{__('translation.operation.canceled')}}',
                icon: 'success'
                });
            }
        });
}


document.addEventListener('DOMContentLoaded', function () {
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
    window.livewire.on('OrdersOprationSuccess' , () => {
        Swal.fire({
                title: '{{__('translation.orders_retive_sccuess')}}',
                icon: 'success'
                });
                livewire.emit('refreshComponent');
    })


    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });

    window.livewire.on('hidemodel', () => {
        $('#exampleModal').modal('hide');
        $('#ChaneRep').modal('hide');
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
})
</script>
@endpush
