@extends('layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('clients_approve') }}
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
                    </div>

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
                                @include('includes.dashboard.notifications')
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.email')}}</th>
                                                <th>{{__('translation.area')}}</th>
                                                <th>{{__('translation.sub_areas')}}</th>
                                                <th>{{__('translation.phone')}}</th>
                                                <th>{{__('translation.client_type')}}</th>
                                                {{-- <th>{{__('translation.activity')}}</th> --}}
                                                {{-- <th>{{__('translation.bank')}}</th>
                                                <th>{{__('translation.bank_acount_owwner')}}</th>
                                                <th>{{__('translation.bank_acount_nummber')}}</th> --}}
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($Clients) > 0)
                                            @foreach ($Clients as $key => $client)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $client->fullname }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->Area->name ?? ' - ' }}</td>
                                                <td>{{ $client->subArea->name }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td>{{ __('translation.'.$client->client_type) }}</td>
                                                {{-- <td>{{ $client->bank }}</td>
                                                <td>{{ $client->bank_account_owner }}</td>
                                                <td>{{ $client->bank_account_number }}</td> --}}
                                                <td>
                                                    <div style="max-width:100px; min-width:100px;"></div>
                                                    @if ($client->Files->Count() > 0)
                                                    <a href='{{ route('attachments', ['clientId' => $client->id , 'type' => 'clients']) }}'
                                                        class="btn btn-sm btn-icon
                                                        btn-outline-info"><i class="la la-eye"></i>
                                                        {{__('translation.show_files')}}
                                                    </a>
                                                    @endif
                                                    <a href='{{ route('approvement', ['id' => $client->id , 'type' => 'client']) }}'
                                                        class="btn btn-sm btn-icon
                                                        btn-outline-success"><i class="la la-check"></i>
                                                        {{__('translation.approve')}}
                                                    </a>
                                                    <a href='{{ route('Delete', ['id' => $client->id , 'type' => 'client']) }}'
                                                        class="btn btn-sm btn-icon
                                                        btn-outline-danger"><i class="la la-trash"></i>
                                                        {{__('translation.delete')}}
                                                    </a>
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
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.email')}}</th>
                                                <th>{{__('translation.area')}}</th>
                                                <th>{{__('translation.sub_areas')}}</th>
                                                <th>{{__('translation.phone')}}</th>
                                                <th>{{__('translation.client_type')}}</th>
                                                {{-- <th>{{__('translation.activity')}}</th> --}}
                                                {{-- <th>{{__('translation.bank')}}</th>
                                                <th>{{__('translation.bank_acount_owwner')}}</th>
                                                <th>{{__('translation.bank_acount_nummber')}}</th> --}}
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! $Clients->links() !!}
        </section>
        <!--/ Zero configuration table -->
    </div>
</div>
@endsection
