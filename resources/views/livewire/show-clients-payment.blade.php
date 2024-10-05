<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('clients') }}
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
                                            <select wire:model="client_id" class="select2 clientSelect2 form-control "
                                                style="width:100%">
                                                <option value="">--{{__('translation.clients')}}--
                                                </option>
                                                @foreach ($clients as $client)
                                                <option {{$client_id == $client->id ? 'selected' : ''}}
                                                    value="{{$client->id}}">
                                                    {{$client->fullname}} ({{$client->orders_count}})
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
                                                <th>{{__('translation.order.no')}}</th>
                                                <th>{{__('translation.order.fees')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $row)
                                            <tr>
                                                <td>{{ $row->order_id }}</td>
                                                <td>{{ $row->deserve }}</td>
                                                <td>
                                                    <input type="checkbox"
                                                        wire:model="checked_orders.{{$row->order_id}}" class="">
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
                                                <th class="text-center">{{__('translation.total.fees')}}
                                                </th>
                                                <th>{{$order_value}}</th>
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
    // clientSelect2
    $('.clientSelect2').select2();
    $('.clientSelect2').on('change', function (e) {
    @this.set('client_id', e.target.value);
    });

    window.Livewire.on('select2', function(){
        $('.select2').select2();
    })
    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }
</script>
@endpush
