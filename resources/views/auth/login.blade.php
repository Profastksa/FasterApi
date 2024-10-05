@extends('layouts.login-layout')

@section('title' , 'Login Page')
@section('content')

<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <section class="flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-md-4 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-header border-0">
                            <div class="card-title text-center">
                                <div class="p-1">
                                <img src="{{asset('uploads/' . $OrganizationProfile?->logo)}}" style="width: 200px"
                                        alt="branding logo">
                                </div>
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                <span>{{__('translation.login')}}</span>
                            </h6>
                        </div>
                        <div class="card-content">
                            @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                <span>{{ $errors->first('email') }}</span>
                            </div>
                            @endif
                            @if ($errors->has('password'))
                            <div class="alert alert-danger">
                                <span>{{ $errors->first('password') }}</span>
                            </div>
                            @endif
                            <div class="card-body">
                                <form class="form-horizontal form-simple" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <input {{ $errors->has('email') ? ' is-invalid' : '' }} name=email
                                            value="{{ old('email') }}" type="text"
                                            class="form-control form-control-lg input-lg" id="user-name"
                                            placeholder="{{trans('translation.email')}}" required>
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                    </fieldset>
                                    {{-- @if ($errors->has('email'))
                                    <span class="form-text text-danger">
                                        <small>{{ $errors->first('email') }}</small>
                                    </span>
                                    @endif --}}
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input name="password" {{ $errors->has('password') ? ' is-invalid' : '' }}
                                            type="password" class="form-control form-control-lg input-lg"
                                            id="user-password" placeholder="{{__('translation.password')}}" required>
                                        <div class="form-control-position">
                                            <i class="la la-key"></i>
                                        </div>
                                    </fieldset>
                                    {{-- @if ($errors->has('password'))
                                    <span class="form-text text-danger">
                                        <small>{{ $errors->first('password') }}</small>
                                    </span>
                                    @endif --}}
                                    <div class="form-group row">
                                        <div class="col-md-6 col-12 text-center text-md-left">
                                            <fieldset>
                                                <input name="remember" type="checkbox" id="remember"
                                                    class="chk-remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label for="remember-me"> {{__('translation.remember.me')}}</label>
                                            </fieldset>

                                        </div>
                                        @if (Route::has('password.request'))
                                        <div class="col-md-6 col-12 text-center text-md-right"><a
                                                href="{{ route('password.request') }}"
                                                class="card-link">{{__('translation.forgot.password')}}</a></div>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg btn-block"><i
                                            class="ft-unlock"></i> {{__('translation.login')}}</button>
                                </form>
                            </div>
                        </div>
                        {{-- <div class="card-footer">
                            <div class="">
                                <p class="float-sm-left text-center m-0"><a href="recover-password.html"
                                        class="card-link">Recover password</a></p>
                                <p class="float-sm-right text-center m-0">New to Moden Admin? <a
                                        href="register-simple.html" class="card-link">Sign Up</a></p>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
