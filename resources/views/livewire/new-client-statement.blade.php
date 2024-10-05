@section('links')
    <style>
        h4 {
            font-weight: bold;
        }

        h2 {
            margin-top: 50px;
        }
    </style>
@endsection
<div>

    <div class="content-wrapper">
        <div class="content-header row HiddenInPrint">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.clients') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('client.transaction') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card overflow-hidden">
            <div class="card-content">
                <div class="card-body cleartfix HiddenInPrint">
                    <div class="row">
                        <div class="col-sm-4">
                            <fieldset class="form-group posision-relative">
                                <label for="">{{ __('translation.client') }}</label>
                                <select wire:model="client_id" class="select2 form-control" id="client_select">
                                    <option value=""> -- {{ __('translation.clients') }} --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->fullname ?? '' }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-sm-4">
                            <fieldset class="form-group">
                                <label for="">{{ __('translation.from') }}</label>
                                <input wire:model="from_date" placeholder="{{ __('translation.from') }}" type="date"
                                    class="form-control" id="date">
                            </fieldset>
                        </div>
                        <div class="col-sm-4">
                            <fieldset class="form-group">
                                <label for="">{{ __('translation.to') }}</label>
                                <input wire:model="to_date" placeholder="{{ __('translation.to') }}" type="date"
                                    class="form-control" id="date">
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($clients->count() > 0)
            <div class="content-body">
                @include('includes.dashboard.notifications')

                <section id="configuration">
                    <div class="row">
                        @foreach ($clients as $client)
                            @php
                                $clientData = $this->getClientData($client);
                            @endphp

                            <div class="col-12">
                                <div class="card overflow-hidden">
                                    <div class="card-content">
                                        <div class="card-body cleartfix HiddenInPrint">
                                            <div class="row align-center">
                                                <div class="col-md-6 inprintOnly p-2">
                                                    <div class="imgContainer">
                                                        <h1><b>{{ __('translation.name.of.company') }}</b>:
                                                            {{ $OrganizationProfile->name }}</h1>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 p-2 text-right inprintOnly">
                                                    <div class="imgContainer text-right inprintOnly">
                                                        <img src="{{ asset('uploads/' . $OrganizationProfile->logo) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-1">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="d-flex align-items-center">
                                                        <input type="checkbox" class="switch"
                                                            wire:model="checked_orders.{{ $client->id }}"
                                                            class="form-control" id="check_box_services"
                                                            value="{{ $client->id }}">
                                                        <span>{{ $client->fullname . ' GIZ-' . $client->id }}</span>
                                                    </h3>

                                                    <div>
                                                        <a href="#"
                                                            wire:click.prevent="previewClient({{ $client->id }})"
                                                            </a>


                                                            <a class="btn btn-sm btn-secondary"
                                                                href="{{ route('client.account.transactions.Preview', $client->id) }}"
                                                                target="_blank">
                                                                {{ __('translation.preview') }}
                                                            </a>


                                                            <a href="#"
                                                                wire:click.prevent="ExportIssueToClient({{ $client->id }})"
                                                                class="btn btn-sm btn-primary">
                                                                {{ __('translation.issue') }}
                                                            </a>
                                                    </div>

                                                </div>
                                            </div>
                                            <table class="table datatable table-striped table-bordered">
                                                <thead style="background:#d7e3bd">
                                                    <tr>
                                                        <th class="text-center">
                                                            <div>
                                                                <h4 class="">service</h4>
                                                            </div>
                                                            <div>
                                                                <h4 class="">{{ __('translation.service') }}</h4>
                                                            </div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div>
                                                                <h4 class="">Qunitity</h4>
                                                            </div>
                                                            <div>
                                                                <h4 class="">{{ __('translation.qunitity') }}
                                                                </h4>
                                                            </div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div>
                                                                <h4 class="">Service Charges</h4>
                                                            </div>
                                                            <div>
                                                                <h4 class="">{{ __('translation.service_fees') }}
                                                                </h4>
                                                            </div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div>
                                                                <h4 class=""> VAT</h4>
                                                            </div>
                                                            <div>
                                                                <h4 class="">{{ __('translation.tax') }}</h4>
                                                            </div>

                                                        </th>
                                                        <th class="text-center">
                                                            <div>
                                                                <h4 class="">COD</h4>
                                                            </div>
                                                            <div>
                                                                <h4 class="">الدفع عند التسليم</h4>
                                                            </div>

                                                        </th>
                                                        <th class="text-center">
                                                            <div>
                                                                <h4 class="">total</h4>
                                                            </div>
                                                            <div>
                                                                <h4 class="">{{ __('translation.total') }}</h4>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if ($clientData['totalQuantity'] != 0)
                                                        @foreach ($clientData['servicesData'] as $serviceData)
                                                            <tr>
                                                                <td>{!! $serviceData['service'] !!}</td>
                                                                <td>{{ $serviceData['quantity'] }}</td>
                                                                <td>{{ $serviceData['price'] }}</td>
                                                                <td>15%</td>

                                                                <td>
                                                                    @if (strpos($serviceData['service'], 'COD Orders') !== false)
                                                                        {{ $clientData['codTotalSum'] }}
                                                                    @else
                                                                        0
                                                                    @endif


                                                                </td>
                                                                <td>{{ $serviceData['fees'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td>
                                                                <h4>{{ __('translation.total') }}</h4>
                                                            </td>
                                                            <td>{{ $clientData['totalQuantity'] }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $clientData['totalFees'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4>{{ __('translation.number_order_count_out_the_clac') }}
                                                                </h4>
                                                            </td>
                                                            <td>{{ $clientData['outsideOrdersCount'] }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        {{-- <tr>
                                                    <td colspan="2" class="text-right">
                                                    </td>
                                                    <td><h4>{{ __('translation.cod_total_sum') }}</h4></td>
                                                    <td style="background:#d7e3bd"><h4></h4></td>
                                                </tr> --}}
                                                        {{-- <tr>
                                                    <td colspan="3" class="text-right">
                                                        <h4 class="text-right">{{ __('translation.number_order_count_out_the_clac') }}</h4>
                                                    </td>
                                                    <td><h4>{{ __('translation.number_order_count_out_the_clac') }}</h4></td>
                                                    <td style="background:#d7e3bd"><h4>{{ $clientData['outsideOrdersCount'] }}</h4></td>
                                                </tr> --}}
                                                        <tr>
                                                            <td colspan="3">
                                                            </td>
                                                            <td colspan="2">
                                                                <h4 class=''></h4>

                                                                <h4> {{ __('translation.total_fess_deserve') }} - Total
                                                                    Service Charges</h4>
                                                            </td>
                                                            <td style='background:#d7e3bd'>
                                                                <h4>{{ (float) $clientData['totalFees'] }}</h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="">
                                                            </td>
                                                            <td colspan="2">
                                                                <h4 class="">{{ __('translation.tax') }} - VAT
                                                                </h4>
                                                            </td>
                                                            <td style="background:#d7e3bd">
                                                                <h4>{{ (float) $clientData['totalFees'] * 0.15 }}</h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <h4></h4>
                                                            </td>
                                                            <td colspan="2">
                                                                <h4>الاجمالي - Toal</h4>
                                                            </td>
                                                            <td style="background:#d7e3bd">
                                                                {{-- <h4>{{ (float)$clientData['codTotalSum'] - (float)$clientData['totalFees'] }}</h4> --}}
                                                                <h4>{{ (float) $clientData['totalFees'] * 0.15 + (float) $clientData['totalFees'] }}
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6"
                                                                style="border: 0px; background:#d7e3bd; text-align: right;">
                                                                <h4 style="direction: rtl; display: inline-block;">
                                                                    المبلغ الصافي - NET </h4>
                                                                <h4 style="direction: rtl;display: inline-block;">
                                                                    {{ (float) $clientData['codTotalSum'] - (float) $clientData['totalFees'] - (float) $clientData['totalFees'] * 0.15 }}
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="10">
                                                                {{ __('translation.table.empty.pleaseCollect') }}</td>
                                                        </tr>
                                                    @endif


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <button class="btn btn-primary" wire:click='ExportIssueToClientWithCheckBoxs()'>
                {{ __('translation.issue') }}
            </button>
        @else
            <div class="card p-5">
                @include('includes.dashboard.notifications')
                <div class="d-flex align-items-center justify-content-center">
                    <div>
                        <svg style="width:240px;height:240px" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M20 17H22V15H20V17M20 7V13H22V7H20M11 9H16.5L11 3.5V9M4 2H12L18 8V20C18 21.11 17.11 22 16 22H4C2.89 22 2 21.1 2 20V4C2 2.89 2.89 2 4 2M13 18V16H4V18H13M16 14V12H4V14H16Z" />
                        </svg>
                        <h3>{{ __('translation.no_order_need_issue') }} !!</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">{{ __('translation.preview') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('translation.close') }}</button>
            </div>
        </div>
    </div>
</div>
{{-- @dd("jksa"); --}}
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
