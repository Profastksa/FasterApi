@extends('layouts.master')
@push('links')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style id='inline_style'>
    h4 {
        font-weight: bold;
    }

    h2 {
        margin-top: 50px;
    }

    .breaker {
        page-break-before: always;
    }
</style>
@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('translation.clients.management') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('clients') }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
        </div>
    </div>
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
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
                        <div class="card-body">
                            <ul class="HiddenInPrint nav nav-tabs nav-linetriangle no-hover-bg"
                                style="border-bottom-color:#1e9ff2">
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab41" data-toggle="tab" aria-controls="tab41"
                                        href="#tab41" aria-expanded="true">{{ __('translation.data.issue') }}</a>
                                </li>

                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="tab41" aria-expanded="true"
                                    aria-labelledby="base-tab41">
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard" id='card-dashboard'>
                                            @if(isset($Orders) && isset($ServicePrice) && isset($ClientStatementIsues) && isset($ServiceHeading)   && isset($Services) && isset($client))
                                                @include('clients.billDesignPreview', [
                                                    'Orders' => $Orders,
                                                    'ServicePrice' => $ServicePrice,
                                                    'ClientStatementIsues' => $ClientStatementIsues,
                                                    'ServiceHeading' => $ServiceHeading,
                                                    'Services' => $Services,
                                                    'client' => $client
                                                ])
                                            @else
                                                <p>{{ __('No data available for preview') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
@endsection
