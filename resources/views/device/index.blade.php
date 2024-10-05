@extends('layouts.master')

@section('BreadCrumbs', 'Devices Mangement')
@section('content')
<div class="content-wrapper">
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

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.phone_number')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($devices) == 0)
                                                <tr>
                                                    <td colspan="5"> <div class="text-center">
                                                        {{ __('translation.no_device') }}
                                                    </div> </td>
                                                </tr>
                                            @endif
                                            @foreach ($devices as $key => $device)
                                            <tr>
                                                {{-- @dd(); --}}
                                                <td>{{ $device->id }}</td>
                                                <td>{{ $device->name }}</td>
                                                <td>{{ $device->phone }}</td>
                                                <td>
                                                    <span class="badge {{ $device->status == 'connected' ? 'badge-info' : 'badge-danger' }}">
                                                        {{__('translation.' .  $device->status)}}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- <a class="btn btn-icon btn-info"
                                                        href="{{ route('users.show',$user->id) }}"><i
                                                            class="la la-eye"></i></a> --}}
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                        href="{{ route('scanDevice',$device->id) }}">
                                                            <i class=" la las la-qrcode"></i>
                                                        </a>
                                                    {!! Form::open(['id' => 'deleteform'.$loop->iteration, 'method' =>
                                                    'DELETE','route' => ['Devices.delete',
                                                    $device->id],'style'=>'display:inline']) !!}
                                                    {{-- {!! Form::submit('Delete', ['class' => 'btn btn-icon btn-danger'])
                                                    !!} --}}
                                                    <button
                                                        onclick="event.preventDefault();deleteConfirmation({{$loop->iteration}})"
                                                        class="btn btn-sm btn-icon btn-danger" type="submit"
                                                        value="Delete"><i class="la la-trash"></i></button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.phone_number')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- {!! $data->render() !!} --}}
            </section>
            <!--/ Zero configuration table -->
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection



@push('scripts')

<script type="text/javascript">
    function deleteConfirmation(iteration) {
                swal.fire({
                            title: '{{__('translation.delete.confirmation.message')}}',
                            text: '{{__('translation.delete.confirmation.text')}}',
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#aaa',
                            confirmButtonText: '{{__('translation.delete')}}',
                            cancelButtonText : '{{__('translation.cancel')}}'
                }).then(function (e) {
                    if (e.value === true) {
                        $('#deleteform'+iteration).submit();
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
</script>

@endpush

