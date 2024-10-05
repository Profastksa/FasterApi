
<div>
    <div class="content-wrapper">
        <div class="content-header row HiddenInPrint">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('client.transaction') }}
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body ">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix HiddenInPrint">
                                    <div class="row ">
                                        <div class="col-sm-3">
                                            <fieldset class="form-group posision-relative">
                                                <label for="">{{__('translation.client')}}</label>
                                                <div class="mx-1">
                                                    <select wire:model="client_id" class="select2 form-control" id="client_select">
                                                        <option value=""> -- {{__('translation.clients')}} --</option>
                                                        @foreach ($clients as $client)
                                                        <option value="{{$client->id}}">{{$client->fullname ?? ''}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.from')}}</label>
                                                <input wire:model="from_date" placeholder="{{__('translation.from')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-3">
                                            <fieldset class="form-group">
                                                <label for="">{{__('translation.to')}}</label>
                                                <input wire:model="to_date" placeholder="{{__('translation.to')}}"
                                                    type="date" class="form-control" id="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                              <label for="">{{__('translation.filter_by_status')}}</label>
                                              <select class="form-control" wire:model='status' id="">
                                                <option value="all"> {{__('translation.all_status')}}</option>
                                                <option value='paid'>{{__('translation.paid')}}  </option>
                                                <option value="unpaid">{{__('translation.unpaid')}}  </option>
                                              </select>
                                            </div>
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
                                    <div class="row  align-center ">
                                        <div class="col-md-6 inprintOnly p-2">
                                            <div class="imgContinaer">
                                               <h1> <b>{{__('translation.name.of.company')}}</b> : {{ $OrganizationProfile->name}} </h1>
                                            </div>
                                        </div>
                                       <div class="col-md-6  p-2 text-right inprintOnly">
                                           <div class="imgContinaer text-right inprintOnly">
                                               <img src="{{asset('uploads/' . $OrganizationProfile->logo)}}" alt="">
                                           </div>
                                       </div>
                                    </div>
                                    <div class="table-responsive">
                                    <table class="table datatable table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('translation.date')}}</th>
                                                <th>رقم الفاتورة</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{ __('translation.count_orders')}}</th>
                                                <th>{{__('translation.status')}}</th>

                                                <th> {{__('translation.total_fess_deserve')}}</th>
                                                   <th> {{__('translation.total_cod')}}</th>
                                                <th>{{__('translation.free_total')}}</th>
                                                <th>وتس اب</th>

                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{$item->Client->fullname ?? ' '}}</td>
                                                <td>{{count($item->orders_ids)}}</td>
                                                <td>
                                                    <span class="badge @switch($item->status)
                                                        @case('unpaid')
                                                            badge-warning
                                                            @break
                                                        @case('paid')
                                                            badge-success
                                                            @break
                                                        @default

                                                    @endswitch ">{{ __('translation.'.$item->status) }}</span>
                                            </td>
                                                {{-- </span> --}}
                                                </td>
                                                <td>{{ $item->total_service_charges}}</td>
                                                <td>{{ $item->total_cod_amount}}</td>
                                                <td>{{ $item->total_fess}}</td>
                                                <td>
                                                    @php
                                                    $phoneNumber = $item->Client->phone.'';
                                                           $phoneNumber = ltrim($phoneNumber, '+');
                                                           $phoneNumber = ltrim($phoneNumber, '0');
                                                           $phoneNumber = str_replace(' ', '', $phoneNumber);

                                                           if (substr($phoneNumber, 0, 3) == '966') {
                                                               $phoneNumber = substr($phoneNumber, 3);
                                                           }
                                                            $RECEIVER_NUMBER = '966'.$phoneNumber;

                                               @endphp
                                                        @if($item->whatsapp_sent)
                                                            <span class="text-success"><i class="fab fa-whatsapp"></i>  تم الإرسال |  {{$item->whatsapp_sent_at}}</span>
                                                        @else
                                                            <span class="text-danger"><i class="fab fa-whatsapp"></i> لم يتم الإرسال</span>
                                                        @endif
                                                        <br>
                                                        <button class="btn btn-{{ $item->whatsapp_sent?'success':'danger'}} btn-sm" wire:click="resendWhatsApp({{ $item->id }})">ارسال الى {{ $RECEIVER_NUMBER }}</button>



                                                </td>
                                                <td>
                                                    <a {{-- data-toggle="modal" data-target="#showModal{{$order->id}}" --}}
                                                        href="{{route('client.issue', $item->id)}}"
                                                        class="btn btn-sm btn-icon
                                                        btn-info"><i class="la la-info"></i></a>
                                                </td>

                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>{{__('translation.Date')}}</th>
                                                <th>{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{ __('translation.count_orders')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th> {{__('translation.total_cod')}}</th>
                                                <th> {{__('translation.total_fess_deserve')}}</th>
                                                <th>{{__('translation.free_total')}}</th>
                                                <th>وتس اب</th>

                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{ $data->links()  ?? '' }}
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
        document.addEventListener('livewire:load', function() {

            function initializePlugins() {
                console.log("init")
                // Initialize Select2 for your select element
                $('#client_select').select2();
                $('#client_select').on('change', function(e) {
                    @this.set('client_id', e.target.value);
                });
                // Alert to ensure the event is firing

                // Listen for change events on the Select2 dropdown
                $('.select2').on('change', function(e) {
                    // Pass the selected value to the Livewire component
                    Livewire.emit('setClientId', e.target.value);
                });

                // Initialize Select2 again if needed
                $('.select2').select2();


            }
            initializePlugins();

            // Reinitialize plugins when Livewire updates the DOM
            Livewire.hook('message.processed', (message, component) => {
                initializePlugins();
            });

        });
    </script>
@endpush
