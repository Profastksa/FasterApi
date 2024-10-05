@extends('layouts.master')

@section('BreadCrumbs', 'Devices Mangement')
@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.wahts_accouts')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('wahts_accouts') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <a href="{{ route('addDevice') }}" class="btn btn-round btn-info" type="button"><i
                            class="icon-cog3"></i>
                        {{__('translation.add')}}</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
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
                                        {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
            <form method='post' action=''>
                <div class='form-group d-flex align--item-center justify-content-center text-center' >
                    <div class="">
                        <img src="{{ $result }}" alt="" style="height:400px">
                    </div>
                </div>
        </div>
        </form>
    </div>
    <div class='panel-footer px-3 py-2'>
        <a class='btn btn-primary' href="{{ route('Devices') }}" value='Back'>{{ __('translation.back') }}</a>
        <a class='btn btn-success' href="" value='Back'>{{ __('translation.refresh') }}</a>
    </div>
    </div>
    <script>
        setTimeout(() => {
            document.reload();
        }, 2000);
    </script>
                    </div>
                </div>
@endsection
