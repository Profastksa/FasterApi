<div>
    <div class="row">
        <div id="recent-transactions" class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('translation.orders.list')}}</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a wire:click.prevent="getOrders('pending')"
                                    class="btn btn-sm btn-warning box-shadow-2 round btn-min-width pull-right" href="#"
                                    target="_blank">{{__('translation.pending')}}</a></li>
                            <li><a wire:click.prevent="getOrders('pickup')"
                                    class="btn btn-sm btn-light box-shadow-2 round btn-min-width pull-right" href="#"
                                    target="_blank">{{__('translation.pickup')}}</a>
                            </li>
                            <li><a wire:click.prevent="getOrders('inProgress')"
                                class="btn btn-sm btn-primary box-shadow-2 round btn-min-width pull-right" href="#"
                                target="_blank">{{__('translation.inProgress')}}</a>
                        </li>
                            <li><a wire:click.prevent="getOrders('delivered')"
                                    class="btn btn-sm btn-info box-shadow-2 round btn-min-width pull-right" href="#"
                                    target="_blank">{{__('translation.delivered')}}</a></li>
                            <li><a wire:click.prevent="getOrders('completed')"
                                    class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="#"
                                    target="_blank">{{__('translation.completed')}}</a></li>
                            <li><a wire:click.prevent="getOrders('canceled')"
                                    class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="#"
                                    target="_blank">{{__('translation.canceled')}}</a></li>
                            <li><a wire:click.prevent="getOrders(false)"
                                    class="btn btn-sm btn-secondary box-shadow-2 round btn-min-width pull-right"
                                    href="#" target="_blank">{{__('translation.all.orders')}}</a></li>

                        </ul>
                    </div>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 3px">{{__('translation.No')}}</th>
                                    <th>{{__('translation.order.date')}}</th>
                                    <th>{{__('translation.service')}}</th>
                                    <th>{{__('translation.client')}}</th>
                                    <th>{{__('translation.representative')}}</th>
                                    <th>{{__('translation.status')}}</th>
                                    <th>{{__('translation.total.fees')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data) > 0)
                                @foreach ($data as $key => $order)
                                <tr>
                                    <td>{{ $order->tracking_number }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->client->fullname?? '--' }}</td>
                                    <td>{{ $order->representative ? $order->representative->fullname : '-' }}</td>
                                    <td>{{ __('translation.'.$order->status) }}</td>
                                    <td>{{ $order->order_value .' '. __('translation.real.sign') }}</td>
                                    <td></td>
                                </tr>

                                @endforeach
                                @else
                                <tr class="text-center">
                                    <td colspan="10">{{__('translation.table.empty')}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
