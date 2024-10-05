<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.management')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders.importCSV') }}
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
                                        <div class="col-3">
                                            <button class="btn btn-info "
                                                wire:click="sampleDownload">{{__('translation.sample.file.download')}}</button>
                                        </div>
                                        <div class="col-6">
                                            <fieldset class="form-group posision-relative">
                                                <input placeholder="{{__('translation.search')}}" wire:model="CSVFile"
                                                    type="file" class="form-control" id="search">
                                            </fieldset>
                                        </div>
                                        <div class="col-3">
                                            <button wire:click="preview"
                                                class="btn btn-primary">{{__('translation.preview')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @error('*.status')
                        <div>{{$message}}
                    </div>
                    @enderror --}}

                    @include('includes.dashboard.notifications')
                    @if(count($data) > 0)
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
                                @if ($errors->any())
                                <div class="alert bg-danger alert-icon-left alert-dismissible mb-2">
                                    <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <table
                                    class="table dataex-res-configuration collapsed dataTable table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 3px">{{__('translation.No')}}</th>
                                            <th>{{__('translation.service')}}</th>
                                            <th>{{__('translation.client')}}</th>
                                            <th>{{__('translation.representative')}}</th>
                                            <th>{{__('translation.sender.name')}}</th>
                                            <th>{{__('translation.sender.phone.no')}}</th>
                                            <th>{{__('translation.sender.area')}}</th>
                                            <th>{{__('translation.sender.sub.area')}}</th>
                                            <th>{{__('translation.sender.address')}}</th>
                                            <th>{{__('translation.receiver.name')}}</th>
                                            <th>{{__('translation.receiver.phone.no')}}</th>
                                            <th>{{__('translation.receiver.area')}}</th>
                                            <th>{{__('translation.receiver.sub.area')}}</th>
                                            <th>{{__('translation.receiver.address')}}</th>
                                            <th>{{__('translation.order.fees')}}</th>
                                            <th>{{__('translation.payment.method')}}</th>
                                            <th>{{__('translation.status')}}</th>
                                            <th>{{__('translation.order.date')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item['service number']}}</td>
                                            <td>{{$item['client number']}}</td>
                                            <td>{{$item['representative number']}}</td>
                                            <td>{{$item['sender name']}}</td>
                                            <td>{{$item['sender phone']}}</td>
                                            <td>{{$item['sender area number']}}</td>
                                            <td>{{$item['sender sub area number']}}</td>
                                            <td>{{$item['sender address']}}</td>
                                            <td>{{$item['receiver name']}}</td>
                                            <td>{{$item['receiver phone']}}</td>
                                            <td>{{$item['receiver area number']}}</td>
                                            <td>{{$item['receiver subarea number']}}</td>
                                            <td>{{$item['receiver address']}}</td>
                                            <td>{{$item['order fees']}}</td>
                                            <td>{{$item['payment method']}}</td>
                                            <td>{{$item['status']}}</td>
                                            <td>{{$item['order date']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 3px">{{__('translation.No')}}</th>
                                            <th>{{__('translation.service')}}</th>
                                            <th>{{__('translation.client')}}</th>
                                            <th>{{__('translation.representative')}}</th>
                                            <th>{{__('translation.sender.name')}}</th>
                                            <th>{{__('translation.sender.phone.no')}}</th>
                                            <th>{{__('translation.sender.area')}}</th>
                                            <th>{{__('translation.sender.sub.area')}}</th>
                                            <th>{{__('translation.sender.address')}}</th>
                                            <th>{{__('translation.receiver.name')}}</th>
                                            <th>{{__('translation.receiver.phone.no')}}</th>
                                            <th>{{__('translation.receiver.area')}}</th>
                                            <th>{{__('translation.receiver.sub.area')}}</th>
                                            <th>{{__('translation.receiver.address')}}</th>
                                            <th>{{__('translation.order.fees')}}</th>
                                            <th>{{__('translation.payment.method')}}</th>
                                            <th>{{__('translation.status')}}</th>
                                            <th>{{__('translation.order.date')}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="p-1">
                                    <input @if ($data_to_store==[]) disabled @endif type="button" wire:click="store"
                                        class="btn btn-block btn-success @if ($data_to_store == [])
                                            disabled
                                        @endif" value="{{__('translation.save')}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
        </div>
        {{-- {!! $data->links() !!} --}}
        </section>
        <!--/ Zero configuration table -->
    </div>
</div>
</div>


@push('scripts')
<script>
    window.livewire.on('dataTable', function(){
        $('.dataex-res-configuration').DataTable({
        responsive: true,
        searching: false,
        paging: false,
        info: false,
        });
    })
</script>
@endpush
