@extends('layouts.master')

@section('content')
@php
    $FilesType = ['driving_license' => 'badge-success' ,
    'bank_account_image'=> 'badge-success' ,
    'identify_image' => 'badge-info',
    'form_image'=> 'badge-light' ,
    'commercial_record' => 'badge-primary'
     ];

@endphp
<div class="content-wrapper">
    @if ($type == 'clients')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
            <div class="row breadcrumbs-top">
                {{-- <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('clients_approve') }}
                </div> --}}
                <h5 class="p-1 ">
                    <span>
                        <b>
                            {{__('translation.client.attachment')}} -
                        </b>
                    </span>
                    <span>
                        <b>
                            {{__('translation.client.name')}} -
                        </b>
                    </span>
                    {{$DynamicModel->fullname}}
                </h5>
            </div>
        </div>

    </div>
    @else
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
            <div class="row breadcrumbs-top">
                {{-- <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('clients_approve') }}
                </div> --}}
                <h5 class="p-1 ">
                    <span>
                        <b>
                            {{__('translation.rep.attachment')}} -
                        </b>
                    </span>
                    <span>
                        <b>
                            {{__('translation.rep.name')}} -
                        </b>
                    </span>
                    {{$DynamicModel->fullname}}
                </h5>
            </div>
        </div>
    </div>
    @endif
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
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped  ">
                                            <thead class="">
                                                <tr>
                                                    <th>{{__('translation.file')}}</th>
                                                    <th>{{__('translation.type')}}</th>
                                                    <th>{{__('translation.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($DynamicModel->Files as $item )
                                                <tr>
                                                    <td scope="row">
                                                        <img width="100" height="100" src="{{asset($item->file)}}" alt="">
                                                    </td>
                                                    <td>
                                                        <div class="" style="min-width:300px"></div>
                                                       <span class="badge {{$FilesType[$item->type]}}">
                                                        {{__('translation.' . $item->type)}}
                                                      </span> </td>
                                                    <td>
                                                        <a target="_blank" href="{{ route('ShowFileInBlank' , $item->id)}}" class="btn btn-sm btn-outline-info">
                                                            <span>
                                                                <svg style="width:15px;height:15px" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C12.36,19.5 12.72,19.5 13.08,19.45C13.03,19.13 13,18.82 13,18.5C13,17.94 13.08,17.38 13.24,16.84C12.83,16.94 12.42,17 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12C17,12.29 16.97,12.59 16.92,12.88C17.58,12.63 18.29,12.5 19,12.5C20.17,12.5 21.31,12.84 22.29,13.5C22.56,13 22.8,12.5 23,12C21.27,7.61 17,4.5 12,4.5M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M18,14.5V17.5H15V19.5H18V22.5H20V19.5H23V17.5H20V14.5H18Z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                       <a href="{{route('downloadClientFile', $item->id)}}" class="btn btn-sm btn-outline-success">
                                                            <span>
                                                                <svg style="width:15px;height:15px" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="12"> {{__('translation.no_Data_right_now_file')}}</td>
                                                </tr>
                                                @endforelse
                                    </div>
                                    </tbody>
                                    </table>
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
