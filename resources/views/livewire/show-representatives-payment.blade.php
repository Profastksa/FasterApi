<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.representatives')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('representatives-fees-collection') }}
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
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div wire:ignore class="col-md-12">
                                            <select wire:model="representative_id"
                                                class="select2 representativeSelect2 form-control " style="width:100%">
                                                <option value="">--{{__('translation.select.representative')}}--
                                                </option>
                                                @foreach ($representatives as $representative)
                                                <option {{$representative_id == $representative->id ? 'selected' : ''}}
                                                    value="{{$representative->id}}">
                                                    {{$representative->fullname}} ({{$representative->orders_count}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($representative_deserves_calculation_method == "orders_per_day")
                        <div class="card">
                            <div class="card-header">
                                <p class="lead text-danger">{{__('translation.today.representative.payment.msg')}}</p>
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
                                                <th>{{__('translation.order.date')}}</th>
                                                <th>{{__('translation.orders.count')}}</th>
                                                <th>{{__('translation.deserve')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $row)
                                            <tr>
                                                <td>{{ $row->date }}</td>
                                                <td>{{ $row->orders_count }}</td>
                                                <td>{{ $row->deserve }}</td>
                                                <td>
                                                    <input type="checkbox" wire:model="checked_orders.{{$row->id}}"
                                                        class="">
                                                </td>
                                            </tr>

                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="5">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="1"></th>
                                                <th class="text-center">{{__('translation.total.fees')}}
                                                </th>
                                                <th>{{$total_fees}}</th>
                                                <th>
                                                    <button wire:click="collectCheckedOrders" class="btn btn-info">
                                                        {{__('translation.collect')}}
                                                    </button>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
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
                                                <th>{{__('translation.order.no')}}</th>
                                                <th>{{__('translation.order.total')}}</th>
                                                <th>{{__('translation.deserve')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $row)
                                            <tr>
                                                <td>{{ $row->order_id }}</td>
                                                <td>{{ $row->total_fees }}</td>
                                                <td>{{ $row->deserve }}</td>
                                                <td>
                                                    <input type="checkbox" wire:model="checked_orders.{{$row->id}}"
                                                        class="">
                                                </td>
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
                                                <th colspan="1"></th>
                                                <th class="text-center">{{__('translation.total.fees')}}
                                                </th>
                                                <th>{{$total_fees}}</th>
                                                <th>
                                                    <button wire:click="collectCheckedOrders" class="btn btn-info">
                                                        {{__('translation.pay')}}
                                                    </button>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                {!! $data->links() !!}
            </section>
        </div>
    </div>



</div>
</div>


@push('scripts')
<script type="text/javascript">
    window.livewire.on('stored', () => {
        $('#AddModal').modal('hide');
    });
    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });
    // representativeSelect2
    $('.representativeSelect2').select2();
    $('.representativeSelect2').on('change', function (e) {
    @this.set('representative_id', e.target.value);
    });

    window.Livewire.on('select2', function(){
        $('.select2').select2();
    })
    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }
</script>
@endpush
