@push('links')
    <style>
        /* HTML: <div class="loader"></div> */
        .loader {
            width: 40px;
            height: 20px;
            background: #464855;
            position: relative;
            animation: l19-0 1.5s infinite linear;
        }

        .loader:before,
        .loader:after {
            content: "";
            position: absolute;
            background: inherit;
            bottom: 100%;
            width: 50%;
            height: 100%;
            animation: inherit;
            animation-name: l19-1;
        }

        .loader:before {
            left: 0;
            --s: -1, 1;
        }

        .loader:after {
            right: 0;
        }

        @keyframes l19-0 {

            0%,
            30% {
                transform: translateY(0) scaleY(1)
            }

            49.99% {
                transform: translateY(-50%) scaleY(1)
            }

            50% {
                transform: translateY(-50%) scaleY(-1)
            }

            70%,
            100% {
                transform: translateY(-100%) scaleY(-1)
            }
        }

        @keyframes l19-1 {

            0%,
            10%,
            90%,
            100% {
                transform: scale(var(--s, 1)) translate(0)
            }

            30%,
            70% {
                transform: scale(var(--s, 1)) translate(20px)
            }

            50% {
                transform: scale(var(--s, 1)) translate(20px, 20px)
            }
        }
    </style>
@endpush
<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.orders.management') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{-- {{ Breadcrumbs::render('orders') }} --}}
                    </div>
                </div>
            </div>

            <div class="content-header-right text-md-right col-md-6 col-12">

                <div class="btn-group">
                    <button data-toggle="modal" data-target="#AddArea" class="btn btn-round btn-info" type="button"><i
                            class="la la-plus la-sm"></i>
                        {{ __('translation.add') }}</button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-md-6">

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
                                    @if (count($errors_ids) > 0)
                                        <form action="{{ route('preShiping') }}" method="GET"
                                            style="display: inline-block">

                                            <input type="hidden" name='ids' value="{{ encrypt($errors_ids) }}" />

                                            <input type="hidden" name='shiping_type' wire:model='shiping_type' />

                                            <button class="btn btn-round btn-light-success btn-sm my-2" type="submit">
                                                <i class="la  la-sync"></i>
                                                {{ __('translation.retry_sync_orders') }}
                                            </button>

                                        </form>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>


                                                    {{-- <th style="width: 3px">{{ __('translation.No') }}</th> --}}
                                                    <th>{{ __('translation.invoice.no') }}</th>
                                                    <th>{{ __('translation.shiiping_number') }}</th>
                                                    <th>{{ __('translation.client.name') }}</th>
                                                    <th>{{ __('translation.shipping_date') }}</th>
                                                    <th>{{ __('translation.shipping_status') }}</th>
                                                    <th>{{ __('translation.action') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data) > 0)
                                                    @foreach ($data as $key => $order)
                                                        <tr>
                                                            {{-- <td align ="center">{{ $order->id }}</td> --}}
                                                            <td>{{ $order->tracking_number }}</td>
                                                            <td>{{ $order->Shipping->refrence_id ?? __('translation.not_found') }}
                                                            </td>
                                                            <td>{{ $order->client->fullname }}</td>
                                                            <td>{{ $order->Shipping->created_at ?? __('translation.not_found') }}
                                                            </td>
                                                            <td>
                                                                @if ($order->Shipping)
                                                                    <span class="badge badge-success">
                                                                        {{ __('translation.shipped_done') }}</span>
                                                                @else
                                                                    <span class="badge badge-danger">
                                                                        {{ __('translation.shipped_filed') }}</span>
                                                                    <br>
                                                                    @if ($details[$order->id]['status'] == 'SMSA_FAULT')
                                                                        <span class="badge badge-danger mt-1">
                                                                            {{ $details[$order->id]['message'] }}</span>
                                                                    @else
                                                                        <span class="badge badge-danger mt-1">
                                                                            {{ $details[$order->id]['status'] }}</span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (!$order->Shipping)
                                                                    <form action="{{ route('preShiping') }}"
                                                                        method="GET" style="display: inline-block">

                                                                        <input type="hidden" name='ids'
                                                                            value="{{ encrypt([$order->id]) }}" />

                                                                        <input type="hidden" name='shiping_type'
                                                                            wire:model='shiping_type' />

                                                                        <button class="btn btn-round btn-light btn-sm"
                                                                            type="submit">
                                                                            <i class="la  la-sync"></i>
                                                                            {{ __('translation.retry') }}
                                                                        </button>

                                                                    </form>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="18">{{ __('translation.table.empty') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

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
                            {{-- @dd(route("test",session()->get('file_path'))) --}}

                            <div id="iframe-container" style="display: flex; justify-content:center; align-items:center; min-height:300px">
                                <div class="loader"></div>
                            </div>

                            {{-- <iframe src="{{ route("test", session()->get('file_path')) }}"  height="600px" style=" margin:10px">
                                Your browser does not support iframes.
                            </iframe> --}}

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let intervalId = null;

            // Function to check the route status
            function checkRoute() {
                // The route URL you're checking
                let url = '{{ route('test', session()->get('file_path')) }}';

                // Send AJAX request to check if the route gives a 404
                fetch(url, {
                        method: 'HEAD'
                    }) // Use 'HEAD' method to avoid downloading full content
                    .then(response => {
                        console.log(response)
                        if (response.ok) {
                            // If the route does not return 404, render the iframe
                            renderIframe();
                            clearInterval(intervalId); // Stop checking the route
                        }
                    })
                    .catch(error => {
                        console.error('Error checking the route:', error);
                    });
            }

            // Function to render the iframe
            function renderIframe() {
                document.getElementById('iframe-container').innerHTML = `
                <iframe src="{{ route('test', session()->get('file_path')) }}" height="600px" style="margin:10px; width:100%">
                    Your browser does not support iframes.
                </iframe>
            `;
            }
            // Set interval to check the route every second (1000 ms)
            intervalId = setInterval(checkRoute, 1000);
        });
    </script>
@endpush
