@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.shipping_orders')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('sync_with_shipment_company') }}
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{__('translation.No')}}</th>
                                            <th>{{__('translation.name')}}</th>
                                            <th>{{__('translation.phone')}}</th>
                                            <th>{{__('translation.type')}}</th>
                                            <th>{{__('translation.ref_number')}}</th>
                                            <th>{{__('translation.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $shiping)
                                        <tr>
                                            <td>{{ $shiping->id }}</td>
                                            <td>{{ $shiping->Order->receiver_name }}</td>
                                            <td>{{ $shiping->Order->receiver_phone_no }}</td>
                                            <td>{{ $shiping->shipping_type }}</td>
                                            <td>{{ $shiping->refrence_id }}</td>
                                            <td>
                                                    <a class='btn btn-sm btn-light' href='{{ route('print_shiping_invoice' , $shiping->order_id) }}'>{{ __('translation.print_shipping_invoice') }}</a>

                                                    <a {{-- data-toggle="modal" data-target="#showModal --}}
                                                    href="{{ route('orders.show.details' , $shiping->order_id) }}"
                                                    class="btn btn-sm btn-icon
                                                    btn-info"><i class="la la-info"></i>
                                                    {{ __('translation.order_info') }}
                                                </a>

                                                <button
                                                    data-toggle="modal" data-target="#showModal"
                                                    onclick="CancelOrderShiping( '{{ $shiping->order_id }}', '{{  $shiping->refrence_id }}' , '{{ $shiping->shipping_type }}')"
                                                    class="btn btn-icon btn-danger btn-sm"><i
                                                        class="la la-trash"></i>
                                                    {{ __('translation.cancel_shiping') }}
                                                    </button>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>{{__('translation.No')}}</th>
                                            <th>{{__('translation.name')}}</th>
                                            <th>{{__('translation.phone')}}</th>
                                            <th>{{__('translation.type')}}</th>
                                            <th>{{__('translation.ref_number')}}</th>
                                            <th>{{__('translation.action')}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div wire:ignore.self class="modal animated bounceInDown fade text-left"
                                        id="showModal" role="dialog"
                                        aria-labelledby="myModalLabel35" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h3 class="modal-title white" id="myModalLabel35">
                                                        {{__('translation.cancel_shiping')}}
                                                    </h3>

                                                    <button type="button" wire:click.prevent="cancel()"
                                                        class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>

                                                <div class="modal-body">
                                                    <form method='post' action='{{ route('cancel_shiping') }}'>
                                                        @csrf
                                                        <input type="hidden"
                                                        class="form-control" name="refrence_id" id="refrence_id" aria-describedby="helpId" placeholder="">


                                                        <input type="hidden"
                                                        class="form-control" name="order_id" id="order_id" aria-describedby="helpId" placeholder="">


                                                        <input type="hidden"
                                                        class="form-control" name="type" id="type" aria-describedby="helpId" placeholder="">

                                                    <div class="form-group">
                                                        <label for="">{{ __('translation.resone') }}</label>
                                                        <div class="form-group">
                                                          <input type="text"
                                                            class="form-control" name="reason" id="" aria-describedby="helpId" placeholder="">
                                                        </div>
                                                      </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input wire:click.prevent="cancel()" type="reset"
                                                        class="btn btn-outline-secondary "
                                                        data-dismiss="modal"
                                                        value="{{__('translation.cancel')}}">
                                                        <button class='btn btn-danger text-white'
                                                        > {{ __('translation.cancel_shiping') }}  </button>

                                                    </div>

                                                </div>
                                            </form>

                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- {!! $data->render() !!} --}}
        </section>
        <!--/ Zero configuration table -->
    </div>
</div>
@endsection



@push('scripts')

<script type="text/javascript">
  function CancelOrderShiping(order_id , refrence_id , type){
    // refrence_id
    // console.log(refrence_id, type);
    document.getElementById('order_id').value = order_id;
    document.getElementById('refrence_id').value = refrence_id;
    document.getElementById('type').value = type;

  }
</script>

@endpush
