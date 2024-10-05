<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('client.account.statement') }}
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
                                        <div class="col-sm-4">
                                            <fieldset class="form-group posision-relative">
                                                <label for="">{{__('translation.client')}}</label>
                                                <select wire:model="client_id" class="select2 form-control">
                                                    <option value=""> -- {{__('translation.clients')}} --</option>
                                                    @foreach ($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->fullname}}</option>
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
                                                <th>{{__('translation.transaction.no')}}</th>
                                                <th>{{__('translation.date')}}</th>
                                                <th>{{__('translation.plus')}}</th>
                                                <th>{{__('translation.minus')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $item->trans_sn }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{ $item->amountin}}</td>
                                                <td>{{ $item->amountout}}</td>
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
                                                <th colspan="1">{{__('translation.current.balance')}} :
                                                    {{$client_current_account_balance}}
                                                </th>
                                                <th class="text-center">{{__('translation.total.fees')}}
                                                </th>
                                                <th>{{$total_amount_in}}</th>
                                                <th>{{$total_amount_out}}</th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- {!! $data->links() !!} --}}
            </section>
        </div>
    </div>

</div>

@push('scripts')
<script>
    $('.select2').select2();
    // change select2 value
    $('.select2').on('change', function (e) {
    @this.set('client_id', e.target.value);
    });
    //reinitiate select2 on every request
    window.livewire.on("select2", function(){
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


</script>
@endpush
