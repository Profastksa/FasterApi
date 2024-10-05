{{-- @extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
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


{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control'))
            !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}


<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection --}}


@extends('layouts.master')


@section('content')

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.users.management')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('users.edit', $user) }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
            <div class="btn-group">
                <a href="{{ route('users.index') }}" class="btn btn-round btn-info" type="button"><i
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
                        <h4 class="card-title" id="row-separator-colored-controls">{{__('translation.user.info')}}</h4>
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
                            {!! Form::model($user, ['class' => 'form form-horizontal row-separator', 'method' =>
                            'PATCH','route' => ['users.update', $user->id]]) !!}
                            {{-- <form class="form form-horizontal row-separator"> --}}
                            <div class="form-body">
                                <h4 class="form-section"><i
                                        class="la la-exclamation-circle"></i>{{__('translation.personal.info')}}
                                </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control"
                                                for="userinput1">{{__('translation.name')}}</label>
                                            <div class="col-md-9">
                                                {{-- <input type="text" id="userinput1" class="form-control"
                                                        placeholder="First Name" name="firstname"> --}}
                                                {!! Form::text('name', null, array('placeholder' => '','class'
                                                => 'form-control')) !!}
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control"
                                                for="userinput2">{{__('translation.email')}}</label>
                                            <div class="col-md-9">
                                                {{-- <input type="text" id="userinput2" class="form-control  "
                                                    placeholder="Last Name" name="lastname"> --}}
                                                {!! Form::text('email', null, array('placeholder' => 'Email','class' =>
                                                'form-control')) !!}
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row last">
                                            <label class="col-md-3 label-control"
                                                for="userinput3">{{__('translation.password')}}</label>
                                            <div class="col-md-9">
                                                {{-- <input type="text" id="userinput3" class="form-control  "
                                                    placeholder="Username" name="username"> --}}
                                                {!! Form::password('password', array('placeholder' => '','class'
                                                => 'form-control')) !!}
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row last">
                                            <label class="col-md-3 label-control"
                                                for="userinput4">{{__('translation.confirm.password')}}</label>
                                            <div class="col-md-9">
                                                {{-- <input type="text" id="userinput4" class="form-control  "
                                                    placeholder="Nick Name" name="nickname"> --}}
                                                {!! Form::password('confirm-password', array('placeholder' => '','class'
                                                => 'form-control'))
                                                !!}
                                                @error('confirm-password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="form-section"><i class="la la-lock"></i>
                                    {{__('translation.roles.management')}}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row last">
                                            <label class="col-md-3 label-control"
                                                for="userinput5">{{__('translation.roles')}}</label>
                                            <div class="col-md-9">
                                                {{-- <input class="form-control  " type="email" placeholder="email"
                                                    id="userinput5"> --}}
                                                {!! Form::select('roles[]', $roles,$userRole, array('class' =>
                                                'form-control','multiple')) !!}
                                                @error('roles')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput6">Website</label>
                                            <div class="col-md-9">
                                                <input class="form-control  " type="url" placeholder="http://"
                                                    id="userinput6">
                                            </div>
                                        </div>
                                        <div class="form-group row last">
                                            <label class="col-md-3 label-control">Contact Number</label>
                                            <div class="col-md-9">
                                                <input class="form-control  " type="tel" placeholder="Contact Number"
                                                    id="userinput7">
                                            </div>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group row last">
                                            <label class="col-md-3 label-control" for="userinput8">Bio</label>
                                            <div class="col-md-9">
                                                <textarea id="userinput8" rows="6" class="form-control  " name="bio"
                                                    placeholder="Bio"></textarea>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="form-actions right">
                                <a href="{{route('users.index')}}" type="button" class="btn btn-warning mr-1">
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
