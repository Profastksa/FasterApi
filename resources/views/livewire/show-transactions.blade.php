<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.transactions')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('transactions') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">

            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.from')}}</label>
                                                <input wire:model="from_date" placeholder="{{__('translation.from')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-4">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.to')}}</label>
                                                <input wire:model="to_date" placeholder="{{__('translation.to')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">{{__('translation.transaction.type')}}</label>
                                            <select wire:model="transaction_type_id" class="form-control">
                                                <option value="">-- --</option>
                                                @foreach ($transactions_types as $transaction_type)
                                                <option value="{{$transaction_type->id}}">
                                                    {{__('translation.'.$transaction_type->type)}}
                                                </option>
                                                @endforeach
                                            </select>
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
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('translation.transaction.no')}}</th>
                                                <th>{{__('translation.date')}}</th>
                                                <th>{{__('translation.client')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.amount')}}</th>
                                                <th>{{__('translation.transaction.type')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $transaction)
                                            <tr>
                                                <td>{{ $transaction->trans_sn }}</td>
                                                <td>{{ $transaction->date }}</td>
                                                <td>{{ $transaction->client ? $transaction->client->fullname : ''}}</td>
                                                <td>{{$transaction->representative ? $transaction->representative->fullname : '' }}
                                                </td>
                                                <td>{{ $transaction->amount }}</td>
                                                <td>{{ __('translation.'.$transaction->transactionType->type) }}</td>
                                                <td>
                                                    @if ($transaction->transaction_type_id == 1)
                                                    {{-- // fees_collection --}}
                                                    <button wire:click="showFeesCollectionModal({{$transaction->id}})"
                                                        class="btn btn-info btn-sm btn-icon" data-toggle="modal"
                                                        data-target="#feesCollectionModel">
                                                        <i class="la la-list"></i>
                                                    </button>
                                                    @endif
                                                    @if ($transaction->transaction_type_id == 2)
                                                    {{-- representative_payment --}}
                                                    <button
                                                        wire:click="showRepresentativePaymentModal({{$transaction->id}})"
                                                        class="btn btn-info btn-sm btn-icon" data-toggle="modal"
                                                        data-target="#representativeModal">
                                                        <i class="la la-list"></i>
                                                    </button>
                                                    @endif
                                                    @if ($transaction->transaction_type_id == 3)
                                                    {{-- // client_payment --}}
                                                    <button wire:click="showClientPaymentModal({{$transaction->id}})"
                                                        class="btn btn-info btn-sm btn-icon" data-toggle="modal"
                                                        data-target="#clientModal">
                                                        <i class="la la-list"></i>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="6">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>{{__('translation.transaction.no')}}</th>
                                                <th>{{__('translation.date')}}</th>
                                                <th>{{__('translation.client')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.amount')}}</th>
                                                <th>{{__('translation.transaction.type')}}</th>
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
        </div>
    </div>


    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="feesCollectionModel" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.transaction.orders.details')}}
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <h1>
                                    {{__('translation.orders.details')}}
                                </h1>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('translation.order.no')}}</th>
                                        <th>{{__('translation.order.fees')}}</th>
                                        {{-- <th>{{__('translation.representative.deserves')}}</th>
                                        <th>{{__('translation.company.deserves')}}</th> --}}
                                        <th>{{__('translation.total.fees')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($transaction_orders) > 0)
                                    @foreach ($transaction_orders as $key => $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->order_fees }}</td>
                                        {{-- <td>{{ $order->representative_deserves }}</td>
                                        <td>{{ $order->company_deserves }}</td> --}}
                                        <td>{{ $order->total_fees }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                        <td colspan="6">{{__('translation.table.empty')}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('translation.order.no')}}</th>
                                        <th>{{__('translation.order.fees')}}</th>
                                        {{-- <th>{{__('translation.representative.deserves')}}</th>
                                        <th>{{__('translation.company.deserves')}}</th> --}}
                                        <th>{{__('translation.total.fees')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <h1>
                                    {{__('translation.deserves.details')}}
                                </h1>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('translation.name')}}</th>
                                        <th>{{__('translation.amount')}}</th>
                                        <th>{{__('translation.account.type')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($fees_collection_details) > 0)
                                    @foreach ($fees_collection_details as $key => $order)
                                    <tr>
                                        <td>
                                            @switch($order->fullname)
                                            @case("company")
                                            {{__('translation.company')}}
                                            @break
                                            @case("representative")
                                            {{__('translation.representative')}}
                                            @break
                                            @default
                                            {{ $order->fullname }}
                                            @endswitch</td>
                                        <td>{{ $order->client_fees }}</td>
                                        <td>@switch($order->fullname)
                                            @case("company")
                                            {{__('translation.company')}}
                                            @break
                                            @case("representative")
                                            {{__('translation.representative')}}
                                            @break
                                            @default
                                            {{__('translation.client')}}
                                            @endswitch </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                        <td colspan="6">{{__('translation.table.empty')}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('translation.name')}}</th>
                                        <th>{{__('translation.amount')}}</th>
                                        <th>{{__('translation.account.type')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                        value="{{__('translation.cancel')}}">
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="representativeModal" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.transaction.orders.details')}}
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h1>
                                    {{__('translation.deserves.details')}}
                                </h1>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('translation.amount')}}</th>
                                        <th>{{__('translation.deserve.date')}}</th>
                                        <th>{{__('translation.payment.date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($representative_payment_details) > 0)
                                    @foreach ($representative_payment_details as $key => $order)
                                    <tr>
                                        <td>{{ $order->deserve }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->payment_date }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                        <td colspan="6">{{__('translation.table.empty')}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('translation.amount')}}</th>
                                        <th>{{__('translation.deserve.date')}}</th>
                                        <th>{{__('translation.payment.date')}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                        value="{{__('translation.cancel')}}">
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="clientModal" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.transaction.orders.details')}}
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h1>
                                    {{__('translation.deserves.details')}}
                                </h1>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('translation.order.no')}}</th>
                                        <th>{{__('translation.amount')}}</th>
                                        {{-- <th>{{__('translation.date')}}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($client_payment_details) > 0)
                                    @foreach ($client_payment_details as $key => $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->order_fees }}</td>
                                        {{-- <td>{{ $order->date }}</td> --}}
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                        <td colspan="6">{{__('translation.table.empty')}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('translation.order.no')}}</th>
                                        <th>{{__('translation.amount')}}</th>
                                        {{-- <th>{{__('translation.date')}}</th> --}}
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                        value="{{__('translation.cancel')}}">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('.modal').on('hidden.bs.modal', function (e) {
    // do something...
        window.livewire.emit('close');
    })
</script>
@endpush
