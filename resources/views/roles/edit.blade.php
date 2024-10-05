{{-- @extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Editrole</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
</div>
</div>
</div>


@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br />
            @foreach($permission as $value)
            <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br />
            @endforeach
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}


@endsection
<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p> --}}



@extends('layouts.master')



@section('content')

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.roles.management')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('roles.edit', $role) }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
            <div class="btn-group">
                <a href="{{ route('roles.index') }}" class="btn btn-round btn-info" type="button"><i
                        class="icon-cog3"></i>
                    {{__('translation.back')}}</a>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="row-separator-colored-controls">
                            {{__('translation.roles.management')}}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
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
                        <div class="card-body">
                            {!! Form::model($role, ['class' => 'form form-horizontal row-separator', 'method' =>
                            'PATCH','route' => ['roles.update', $role->id]]) !!}
                            {{-- <form class="form form-horizontal row-separator"> --}}
                            <div class="form-body">
                                <h4 class="form-section"><i
                                        class="la la-exclamation-circle"></i>{{__('translation.name')}}
                                </h4>
                                <div class="form-group row last">
                                    <label class="col-md-3 label-control"
                                        for="roleinput1">{{__('translation.name')}}</label>
                                    <div class="col-md-9">
                                        {{-- <input type="text" id="roleinput1" class="form-control"
                                                                                        placeholder="First Name" name="firstname"> --}}
                                        {!! Form::text('name', null, array('placeholder' => '','class'
                                        => 'form-control')) !!}
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h4 class="form-section"><i class="la la-clipboard"></i> {{__('translation.roles')}}
                                </h4>
                                <div class="form-group row last">
                                    {{-- <label class="col-md-3 lable-control">
                                        {{__('translation.roles')}}
                                    </label> --}}
                                    <div class="col-md-9">
                                        @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                            {{ $value->name }}</label>
                                        <br />
                                        @endforeach
                                    </div>
                                </div>



                            </div>




                            <div class="form-actions right">
                                <a href="{{route('roles.index')}}" type="button" class="btn btn-warning mr-1">
                                    <i class="la la-remove"></i> {{__('translation.cancel')}}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check"></i> {{__('translation.save')}}
                                </button>
                            </div>
                            {{-- </form> --}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
