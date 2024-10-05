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
                                        <div class="col-sm-4">
                                            <fieldset class="form-group posision-relative">
                                                <label for="">{{__('translation.representative')}}</label>
                                                <select wire:model="representative_id" class="select2 form-control">
                                                    <option value=""> -- {{__('translation.representatives')}} --
                                                    </option>
                                                    @foreach ($representatives as $representative)
                                                    <option value="{{$representative->id}}">
                                                        {{$representative->fullname}}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
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
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.representative')}}</th>
                                                <th>{{__('translation.total.orders.number')}}</th>
                                                <th>{{__('translation.total.completed')}}</th>
                                                <th>{{__('translation.total.uncompleted')}}</th>
                                                <th>{{__('translation.total.canceled')}}</th>
                                                <th>{{__('translation.total.deserves')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->fullname }}</td>
                                                <td>{{ $order->total_orders_number }}</td>
                                                <td>{{ $order->total_completed }}</td>
                                                <td>{{ $order->total_uncompleted }}</td>
                                                <td>{{ $order->total_canceled }}</td>
                                                <td>{{ $order->total_deserves }}</td>
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
                                                <th colspan="5"></th>
                                                <th>{{__('translation.total.fees')}}</th>
                                                <th>{{$overall_total}}</th>
                                                {{--<th>{{$company_total}}</th>
                                                <th>{{$order_fees_total}}</th>
                                                <th>{{$total_fees_total}}</th> --}}
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
        $('.select2').select2();
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
        $('.select2').select2();
        // change select2 value
        $('.select2').on('change', function (e) {
        @this.set('representative_id', e.target.value);
        });
</script>
@endpush
