@extends('layouts.master')


{{-- @section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
            @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>


{!! $data->render() !!}


<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection --}}

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.users.management')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('users') }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
            <div class="btn-group">
                <a href="{{ route('users.create') }}" class="btn btn-round btn-info" type="button"><i
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
                                            <th>{{__('translation.email')}}</th>
                                            <th>{{__('translation.roles')}}</th>
                                            <th>{{__('translation.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <a class="btn btn-icon btn-info"
                                                    href="{{ route('users.show',$user->id) }}"><i
                                                        class="la la-eye"></i></a> --}}
                                                <a class="btn btn-sm btn-icon btn-primary"
                                                    href="{{ route('users.edit',$user->id) }}"><i
                                                        class="la la-edit"></i></a>
                                                {!! Form::open(['id' => 'deleteform'.$loop->iteration, 'method' =>
                                                'DELETE','route' => ['users.destroy',
                                                $user->id],'style'=>'display:inline']) !!}
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
                                            <th>{{__('translation.email')}}</th>
                                            <th>{{__('translation.roles')}}</th>
                                            <th>{{__('translation.action')}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! $data->render() !!}
        </section>
        <!--/ Zero configuration table -->
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
