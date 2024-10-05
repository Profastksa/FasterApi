<div>


    @push('links')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/pages/project.css')}}">
    @endpush

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.edit profile')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('user.profile') }}
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <!-- project-info -->
                            <div id="project-info" class="card-body row">

                                <div class="project-info-count col-sm-12">
                                    <div style="width: 250px; height:250px; margin: auto">

                                        <img src="{{asset('uploads/' . $data->photo)}}" alt=""
                                            style="width: 100%; height: 100%">
                                    </div>
                                    <div class="project-info-text pt-1">
                                        <h5>{{__('translation.photo')}}</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- project-info -->
                            <div class="card-body">
                                <div class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                    {{-- <span>Egal's Eye View Of Project Status</span> --}}
                                </div>
                                @include('includes.dashboard.notifications')
                                <form wire:submit.prevent="update">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="insights px-2 ">
                                                <fieldset>
                                                    <label for="">{{__('translation.photo')}}</label>
                                                    <input wire:model="photo" type="file" class="form-control"
                                                        size="60" />
                                                    @error('photo')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6 col-md-12">
                                            <div class="insights px-2">
                                                <fieldset>
                                                    <label for="">{{__('translation.name')}}</label>
                                                    <input wire:model="name" type="text" class="form-control">
                                                    @error('name')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="insights px-2">
                                                <fieldset>
                                                    <label for="">{{__('translation.email')}}</label>
                                                    <input wire:model="email" type="text" class="form-control">
                                                    @error('email')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="insights px-2">
                                                <fieldset>
                                                    <label for="">{{__('translation.current.password')}}</label>
                                                    <b class="text-danger"> *</b>
                                                    <input wire:model="current_password" type="password"
                                                        class="form-control">
                                                    @error('current_password')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="insights px-2">
                                                <fieldset>
                                                    <label for="">{{__('translation.new.password')}}</label>
                                                    <input wire:model="password" type="password" class="form-control">
                                                    @error('password')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="insights px-2">
                                                <fieldset>
                                                    <label for="">{{__('translation.confirm.password')}}</label>
                                                    <input wire:model="password_confirmation" type="password"
                                                        class="form-control">
                                                    @error('password_confirmation')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mt-2 col-12 px-2">
                                                <input type="submit" class="btn btn-block btn-info"
                                                    value="{{__('translation.save')}}">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
