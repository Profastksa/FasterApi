<div>
    @push('links')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/pages/project.css')}}">
    @endpush
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.organization.profile')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('organization.profile') }}
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
                            <div id="project-info" class="card-body row">
                                <div class="project-info-count col-sm-12">
                                    {{-- <div class="project-info-icon"> --}}
                                    <div style="width: 250px; height:250px; margin: auto">
                                        <img src="{{asset('uploads/' . $data->logo)}}" alt=""
                                            style="width: 100%; height: 100%">
                                    </div>
                                    {{-- <div wire:click="" class="project-info-sub-icon">
                                            <span class="la la-edit"></span>
                                        </div> --}}
                                    {{-- </div> --}}
                                    <div class="project-info-text pt-1">
                                        <h5>{{__('translation.logo.image')}}</h5>
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
                                                    <label for="">{{__('translation.logo.image')}}</label>
                                                    <input wire:model="logo" type="file" class="form-control"
                                                        size="60" />
                                                    @error('logo')
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
                                        <div class="col-lg-6 col-md-12">
                                            <div class="insights px-2">
                                                <fieldset>
                                                    <label for="">{{__('translation.address')}}</label>
                                                    <input wire:model="address" type="text" class="form-control">
                                                    @error('address')
                                                    <small class="text-danger">
                                                        {{$message}}
                                                    </small>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-2">
                                            <div class="row " style="padding:13px">
                                                <div class="col-lg-4 col-md-12 ">
                                                    <div class="insights">
                                                        <fieldset>
                                                            <label for="">{{__('translation.phone')}}</label>
                                                            <input wire:model="phone_no" type="text" class="form-control">
                                                            @error('phone_no')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="insights">
                                                        <fieldset>
                                                            <label for="">{{__('translation.whatsapp_no')}}</label>
                                                            <input wire:model="whatsapp_no" type="text" class="form-control">
                                                            @error('whatsapp_no')
                                                            <small class="text-danger">
                                                                {{$message}}
                                                            </small>
                                                            @enderror
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <fieldset>
                                                        <label for="">{{__('translation.country_key')}}</label>
                                                        <input wire:model="countery_key" type="text" class="form-control">
                                                        @error('countery_key')
                                                        <small class="text-danger">
                                                            {{$message}}
                                                        </small>
                                                        @enderror
                                                    </fieldset>
                                                </div>
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
