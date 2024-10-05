<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.per.month.reports')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders.month.reports') }}
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
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <select wire:model="year" class="form-control" id="year" name="year">
                                                <option>year</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2020</option>
                                                <option value="2031">2031</option>
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

                                    <table class="table datatable table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('translation.month')}}</th>
                                                <th>{{__('translation.total.completed')}}</th>
                                                <th>{{__('translation.total.uncompleted')}}</th>
                                                <th>{{__('translation.total.canceled')}}</th>
                                                <th>{{__('translation.total.orders.number')}}</th>
                                                <th>{{__('translation.order.fees')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.month.percentage')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $order)
                                            <tr class="text-center">
                                                <td style="font-weight: bold">{{ __('translation.'.$order->month) }}
                                                </td>
                                                <td>{{ $order->total_completed }}</td>
                                                <td>{{ $order->total_uncompleted }}</td>
                                                <td>{{ $order->total_canceled }}</td>
                                                <td>{{ $order->total_orders_number }}</td>
                                                <td>{{ $order->order_fees }}</td>
                                                <td>{{ $order->total_fees }}</td>
                                                <td>{{ round($order->month_percentage) }}%</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>{{__('translation.month')}}</th>
                                                <th>{{__('translation.total.completed')}}</th>
                                                <th>{{__('translation.total.uncompleted')}}</th>
                                                <th>{{__('translation.total.canceled')}}</th>
                                                <th>{{__('translation.total.orders.number')}}</th>
                                                <th>{{__('translation.order.fees')}}</th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{__('translation.month.percentage')}}</th>
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
</div>

@push('scripts')
<script>
    $('.datatable').DataTable( {
    dom: 'B',
    buttons: [
    'copyHtml5',
    'excelHtml5',
    'csvHtml5',
    'pdfHtml5',
    'print',
    ]
    } );
    window.livewire.on("init", function(){
        $('.datatable').DataTable( {
        dom: 'B',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
        'print',
        ]
        } );
        })
</script>
@endpush
