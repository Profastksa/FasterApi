@extends('layouts.master')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">{{__('translation.representatives')}}</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                {{ Breadcrumbs::render('representatives_approve') }}
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
                {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body card-dashboard">
            @include('includes.dashboard.notifications')
            {{-- @dd(GetModelItemCount('Client')) --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3px">{{__('translation.No')}}</th>
                            <th>{{__('translation.name')}}</th>
                            <th>{{__('translation.email')}}</th>
                               <th>الرمز</th>
                            <th>{{__('translation.address')}}</th>
                            <th>{{__('translation.phone')}}</th>
                            <th>{{__('translation.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($Representatives) > 0)
                        @foreach ($Representatives as $key => $Representative)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $Representative->fullname }}</td>
                              <td>GIZ-{{ $Representative->id }}</td>
                            <td>{{ $Representative->email }}</td>
                            <td>{{ $Representative->address }}</td>
                             <td>{{ $Representative->phone }}</td>
                            <td>

                                <div style="max-width:100px; min-width:100px;"></div>
                                @if ($Representative->Files->Count() > 0)
                                <a href='{{ route('attachments', ['clientId' => $Representative->id , 'type' => 'Representative ']) }}'
                                    class="btn btn-sm btn-icon
                                    btn-outline-info"><i class="la la-eye"></i>
                                    {{__('translation.show_files')}}
                                </a>
                                @endif
                                <a href='{{ route('approvement', ['id' => $Representative->id , 'type' => 'representative']) }}'
                                    class="btn btn-sm btn-icon
                                    btn-outline-success"><i class="la la-check"></i>
                                    {{__('translation.approve')}}
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
                            <th>{{__('translation.address')}}</th>
                            <th>{{__('translation.phone')}}</th>
                            <th>{{__('translation.action')}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {!! $Representatives->links() !!}
        </div>
    </div>
</div>
</div>
</div>
jsa
</section>
<!--/ Zero configuration table -->
</div>
</div>

@endsection
