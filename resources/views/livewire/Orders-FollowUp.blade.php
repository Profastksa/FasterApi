
<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.FollowUp')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
            </div>

        </div>
        <div class="content-body">
        </div>
        <div id="accordion">
            @foreach($clients as $client)
            @if( count($client->pendingOrders()) > 0 ||count($client->pickedUpOrders()) > 0||count($client->inProgressOrders()) > 0)
                  <div class="card">
                    <div class="card-header" id="heading{{ $client->id }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $client->id }}" aria-expanded="true" aria-controls="collapse{{ $client->id }}">
                                {{ $client->fullname }} &nbsp;&nbsp;&nbsp;&nbsp;

                                    <!-- Badge for pending orders -->
                                    <span class="badge bg-warning">{{ count($client->pendingOrders()) }}    {{ __('translation.pending') }}</span>
                                    <!-- Badge for picked up orders -->
                                    <span class="badge badge-success">{{ count($client->pickedUpOrders()) }}  {{ __('translation.pickup') }}</span>
                                    <!-- Badge for in progress orders -->
                                    <span class="badge bg-info">{{ count($client->inProgressOrders()) }}  {{ __('translation.inProgress') }}</span>

                            </button>

                        </h5>
                    </div>
                    <div id="collapse{{ $client->id }}" class="collapse" aria-labelledby="heading{{ $client->id }}" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <!-- Pending Orders -->
                                <div class="accordion col-4 " id="pendingAccordion{{ $client->id }}">
                                    <div class="card">
                                        <div class="card-header bg-warning" id="headingPending{{ $client->id }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapsePending{{ $client->id }}" aria-expanded="true" aria-controls="collapsePending{{ $client->id }}">
                                                     {{ __('translation.pending') }}
                                                     <span class="badge ">{{ count($client->pendingOrders()) }}   </span>

                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapsePending{{ $client->id }}" class="collapse  border" aria-labelledby="headingPending{{ $client->id }}" data-parent="#pendingAccordion{{ $client->id }}">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-striped table">
                                                    <!-- Table header -->
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('translation.invoice.no') }}</th>
                                                            <th>{{ __('translation.order.date') }}</th>
                                                            <th>{{ __('translation.service') }}</th>
                                                            <th>{{ __('translation.client') }}</th>
                                                            <th>الرمز</th>
                                                            <th>{{ __('translation.representative') }}</th>
                                                            <th>{{ __('translation.sender.name') }}</th>
                                                            <th>{{ __('translation.receiver.name') }}</th>
                                                            <th>الدفع عند الاستلام</th>

                                                            <th>{{ __('translation.service_fees') }}</th>
                                                            <th>{{ __('translation.status') }}</th>
                                                            <th>{{ __('translation.shipping') }}</th>
                                                             <!-- Add more table headers if needed -->
                                                        </tr>
                                                    </thead>
                                                    <!-- Table body -->
                                                    <tbody>
                                                        @foreach($client->pendingOrders() as $order)
                                                            <tr>
                                                                <tr>

                                                                    <td>{{ $order->tracking_number }}</td>
                                                                    <td>{{ $order->order_date }}</td>
                                                                    <td>{{ $order->service->name }}</td>
                                                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                                                    <td>GIZ-{{ $order->client->id ?? 0 }}</td>
                                                                    <td>{{ $order->representative ? $order->representative->fullname : '-' }}
                                                                    </td>
                                                                    <td>{{ $order->sender_name }}</td>
                                                                    <td>{{ $order->receiver_name }}</td>

                                                                    </td>
                                                                    @if ($order->order_value == null)
                                                                        <td>0</td>
                                                                    @else
                                                                        <td>{{ $order->order_value }}</td>
                                                                    @endif


                                                                    <td>{{ $order->delivery_fees }}</td>



                                                                    <td><span
                                                                            class="badge @switch($order->status)
                                                                    @case('pending')
                                                                        badge-warning
                                                                        @break
                                                                    @case('pickup')
                                                                        badge-secondary
                                                                        @break
                                                                    @case('inProgress')
                                                                        badge-primary
                                                                        @break
                                                                    @case('delivered')
                                                                        badge-info
                                                                        @break
                                                                    @case('completed')
                                                                        badge-success
                                                                        @break
                                                                    @case('canceled')
                                                                        badge-danger
                                                                        @break
                                                                    @default
                                                                @endswitch ">{{ __('translation.' . $order->status) }}</span>
                                                                    </td>

                                                                    <td>


                                                                        @if ($order->Shipping)
                                                                            {{ $order->Shipping->refrence_id }}
                                                                            <br />
                                                                            <a class='btn btn-round btn-warning btn-sm'
                                                                                target="_blank"
                                                                                href='{{ route('print_shiping_invoice', $order->id) }}'>
                                                                                <i class="la la-print"></i>
                                                                                {{ __('translation.print_shipping_invoice') }}
                                                                            </a>
                                                                        @elseif(!$order->Shipping)
                                                                            <form action="{{ route('preShiping') }}"
                                                                                method="GET" style="display: inline-block">

                                                                                <input type="hidden" name='ids'
                                                                                    value="{{ encrypt([$order->id]) }}" />

                                                                                <input type="hidden" name='shiping_type'
                                                                                    wire:model='shiping_type' />

                                                                                <button class="btn btn-round btn-light btn-sm"
                                                                                    type="submit">
                                                                                    <i class="la  la-sync"></i>
                                                                                    {{ __('translation.sync_with_shipping_company') }}
                                                                                </button>

                                                                            </form>
                                                                        @endif

                                                                    </td>


                                                                <!-- Add more table data if needed -->
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Picked Up Orders -->
                                <div class="accordion col-4" id="pickedAccordion{{ $client->id }}">
                                    <div class="card">
                                        <div class="card-header bg-success" id="headingPicked{{ $client->id }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePicked{{ $client->id }}" aria-expanded="false" aria-controls="collapsePicked{{ $client->id }}">
                                                    {{ __('translation.pickup') }}
                                                    <span class="badge ">{{ count($client->pickedUpOrders()) }}   </span>

                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapsePicked{{ $client->id }}" class="collapse border" aria-labelledby="headingPicked{{ $client->id }}" data-parent="#pickedAccordion{{ $client->id }}">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-striped table">
                                                    <!-- Table header -->
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('translation.invoice.no') }}</th>
                                                            <th>{{ __('translation.order.date') }}</th>
                                                            <th>{{ __('translation.service') }}</th>
                                                            <th>{{ __('translation.client') }}</th>
                                                            <th>الرمز</th>
                                                            <th>{{ __('translation.representative') }}</th>
                                                            <th>{{ __('translation.sender.name') }}</th>
                                                            <th>{{ __('translation.receiver.name') }}</th>
                                                            <th>الدفع عند الاستلام</th>

                                                            <th>{{ __('translation.service_fees') }}</th>
                                                            <th>{{ __('translation.status') }}</th>
                                                            <th>{{ __('translation.shipping') }}</th>
                                                             <!-- Add more table headers if needed -->
                                                        </tr>
                                                    </thead>
                                                    <!-- Table body -->
                                                    <tbody>
                                                        @foreach($client->pickedUpOrders() as $order)
                                                            <tr>
                                                                <tr>

                                                                    <td>{{ $order->tracking_number }}</td>
                                                                    <td>{{ $order->order_date }}</td>
                                                                    <td>{{ $order->service->name }}</td>
                                                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                                                    <td>GIZ-{{ $order->client->id ?? 0 }}</td>
                                                                    <td>{{ $order->representative ? $order->representative->fullname : '-' }}
                                                                    </td>
                                                                    <td>{{ $order->sender_name }}</td>
                                                                    <td>{{ $order->receiver_name }}</td>

                                                                    </td>
                                                                    @if ($order->order_value == null)
                                                                        <td>0</td>
                                                                    @else
                                                                        <td>{{ $order->order_value }}</td>
                                                                    @endif


                                                                    <td>{{ $order->delivery_fees }}</td>



                                                                    <td><span
                                                                            class="badge @switch($order->status)
                                                                    @case('pending')
                                                                        badge-warning
                                                                        @break
                                                                    @case('pickup')
                                                                        badge-secondary
                                                                        @break
                                                                    @case('inProgress')
                                                                        badge-primary
                                                                        @break
                                                                    @case('delivered')
                                                                        badge-info
                                                                        @break
                                                                    @case('completed')
                                                                        badge-success
                                                                        @break
                                                                    @case('canceled')
                                                                        badge-danger
                                                                        @break
                                                                    @default
                                                                @endswitch ">{{ __('translation.' . $order->status) }}</span>
                                                                    </td>

                                                                    <td>


                                                                        @if ($order->Shipping)
                                                                            {{ $order->Shipping->refrence_id }}
                                                                            <br />
                                                                            <a class='btn btn-round btn-warning btn-sm'
                                                                                target="_blank"
                                                                                href='{{ route('print_shiping_invoice', $order->id) }}'>
                                                                                <i class="la la-print"></i>
                                                                                {{ __('translation.print_shipping_invoice') }}
                                                                            </a>
                                                                        @elseif(!$order->Shipping)
                                                                            <form action="{{ route('preShiping') }}"
                                                                                method="GET" style="display: inline-block">

                                                                                <input type="hidden" name='ids'
                                                                                    value="{{ encrypt([$order->id]) }}" />

                                                                                <input type="hidden" name='shiping_type'
                                                                                    wire:model='shiping_type' />

                                                                                <button class="btn btn-round btn-light btn-sm"
                                                                                    type="submit">
                                                                                    <i class="la  la-sync"></i>
                                                                                    {{ __('translation.sync_with_shipping_company') }}
                                                                                </button>

                                                                            </form>
                                                                        @endif

                                                                    </td>


                                                                <!-- Add more table data if needed -->
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- In Progress Orders -->
                                <div class="accordion col-4" id="progressAccordion{{ $client->id }}">
                                    <div class="card">
                                        <div class="card-header bg-info" id="headingProgress{{ $client->id }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseProgress{{ $client->id }}" aria-expanded="false" aria-controls="collapseProgress{{ $client->id }}">
                                                    {{ __('translation.inProgress') }}
                                                    <span class="badge ">{{ count($client->inProgressOrders()) }}   </span>

                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseProgress{{ $client->id }}" class="collapse border" aria-labelledby="headingProgress{{ $client->id }}" data-parent="#progressAccordion{{ $client->id }}">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-striped table">
                                                    <!-- Table header -->
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('translation.invoice.no') }}</th>
                                                            <th>{{ __('translation.order.date') }}</th>
                                                            <th>{{ __('translation.service') }}</th>
                                                            <th>{{ __('translation.client') }}</th>
                                                            <th>الرمز</th>
                                                            <th>{{ __('translation.representative') }}</th>
                                                            <th>{{ __('translation.sender.name') }}</th>
                                                            <th>{{ __('translation.receiver.name') }}</th>
                                                            <th>الدفع عند الاستلام</th>

                                                            <th>{{ __('translation.service_fees') }}</th>
                                                            <th>{{ __('translation.status') }}</th>
                                                            <th>{{ __('translation.shipping') }}</th>
                                                             <!-- Add more table headers if needed -->
                                                        </tr>
                                                    </thead>
                                                    <!-- Table body -->
                                                    <tbody>
                                                        @foreach($client->inProgressOrders() as $order)
                                                            <tr>
                                                                <tr>

                                                                    <td>{{ $order->tracking_number }}</td>
                                                                    <td>{{ $order->order_date }}</td>
                                                                    <td>{{ $order->service->name }}</td>
                                                                    <td>{{ $order->client->fullname ?? '--' }}</td>
                                                                    <td>GIZ-{{ $order->client->id ?? 0 }}</td>
                                                                    <td>{{ $order->representative ? $order->representative->fullname : '-' }}
                                                                    </td>
                                                                    <td>{{ $order->sender_name }}</td>
                                                                    <td>{{ $order->receiver_name }}</td>

                                                                    </td>
                                                                    @if ($order->order_value == null)
                                                                        <td>0</td>
                                                                    @else
                                                                        <td>{{ $order->order_value }}</td>
                                                                    @endif


                                                                    <td>{{ $order->delivery_fees }}</td>



                                                                    <td><span
                                                                            class="badge @switch($order->status)
                                                                    @case('pending')
                                                                        badge-warning
                                                                        @break
                                                                    @case('pickup')
                                                                        badge-secondary
                                                                        @break
                                                                    @case('inProgress')
                                                                        badge-primary
                                                                        @break
                                                                    @case('delivered')
                                                                        badge-info
                                                                        @break
                                                                    @case('completed')
                                                                        badge-success
                                                                        @break
                                                                    @case('canceled')
                                                                        badge-danger
                                                                        @break
                                                                    @default
                                                                @endswitch ">{{ __('translation.' . $order->status) }}</span>
                                                                    </td>

                                                                    <td>


                                                                        @if ($order->Shipping)
                                                                            {{ $order->Shipping->refrence_id }}
                                                                            <br />
                                                                            <a class='btn btn-round btn-warning btn-sm'
                                                                                target="_blank"
                                                                                href='{{ route('print_shiping_invoice', $order->id) }}'>
                                                                                <i class="la la-print"></i>
                                                                                {{ __('translation.print_shipping_invoice') }}
                                                                            </a>
                                                                        @elseif(!$order->Shipping)
                                                                            <form action="{{ route('preShiping') }}"
                                                                                method="GET" style="display: inline-block">

                                                                                <input type="hidden" name='ids'
                                                                                    value="{{ encrypt([$order->id]) }}" />

                                                                                <input type="hidden" name='shiping_type'
                                                                                    wire:model='shiping_type' />

                                                                                <button class="btn btn-round btn-light btn-sm"
                                                                                    type="submit">
                                                                                    <i class="la  la-sync"></i>
                                                                                    {{ __('translation.sync_with_shipping_company') }}
                                                                                </button>

                                                                            </form>
                                                                        @endif

                                                                    </td>


                                                                <!-- Add more table data if needed -->
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @endforeach
        </div>











</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>



    document.addEventListener('DOMContentLoaded', function() {


        $('#cleintfilter').select2();
            $('#cleintfilter').on('change', function(e) {

                @this.set('cleint_filter', e.target.value);
            });

        window.Livewire.on('select2', function() {
            $('.select2').select2();
        });
        Livewire.on('triggerOrderDelete', order_id => {
            console.log('tregered!');
            Swal.fire({
                title: '{{ __('translation.delete.confirmation.message') }}',
                text: '{{ __('translation.delete.confirmation.text') }}',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: '{{ __('translation.delete') }}'
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                    // calling destroy method to delete
                    Livewire.emit('orderDelete', order_id)
                    // success response
                    // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                    Swal.fire({
                        title: '{{ __('translation.item.deleted.successfully') }}',
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        title: '{{ __('translation.operation.canceled') }}',
                        icon: 'success'
                    });
                }
            });
        });

    });

    function setTrackingNumber(event) {
        // Prevent the default link behavior
        event.preventDefault();

        // Find the nearest parent 'a' tag that has an 'href' attribute
        var linkElement = event.target.closest('a');

        // If a valid 'a' tag is found
        if (linkElement && linkElement.getAttribute('href')) {
            // Extract the tracking number from the link's href attribute
            var trackingNumber = linkElement.getAttribute('href').split('?').pop();

            // Set the tracking number in the session using AJAX
            fetch('/set-tracking-number', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        trackingNumber: trackingNumber
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Redirect the user to the 'returend-order' route
                   //     window.location.href = '';
                    } else {
                        console.error('Failed to set tracking number.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            console.error('No valid link found.');
        }
    }


</script> --}}

