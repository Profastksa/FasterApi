@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.clients.management')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('clients') }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
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
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-linetriangle no-hover-bg" style="border-bottom-color:#1e9ff2">
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab41" data-toggle="tab" aria-controls="tab41"
                                        href="#tab41" aria-expanded="true">{{__('translation.data.issue')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="base-tab42" data-toggle="tab" aria-controls="tab42"
                                        href="#tab42" aria-expanded="false">{{ __('translation.file.issue')}}</a>
                                </li>

                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="tab41" aria-expanded="true"
                                    aria-labelledby="base-tab41">
                                    <p>
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info ">
                                                        <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.add.client')}}</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form wire:submit.prevent="store()">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="email">{{__('translation.name')}}</label>
                                                                        <input type="text" wire:model.defer="fullname" class="form-control" id="email"
                                                                            placeholder="">
                                                                        @error('fullname') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="title">{{__('translation.email')}}</label>
                                                                        <input type="email" wire:model.defer="email" class="form-control" id="title"
                                                                            placeholder="">
                                                                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="email">{{__('translation.password')}}</label>
                                                                        <input type="text" wire:model.defer="password" class="form-control" id="email"
                                                                            placeholder="">
                                                                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                    </fieldset>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="email">{{__('translation.passwordConfirm')}}</label>
                                                                        <input type="text" wire:model.defer="passwordConfirm" class="form-control"
                                                                            id="email" placeholder="">
                                                                        @error('passwordConfirm') <span class="text-danger error">{{ $message
                                                                            }}</span>@enderror
                                                                    </fieldset>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="email">{{__('translation.address')}}</label>
                                                                        <input type="text" wire:model.defer="address" class="form-control" id="email"
                                                                            placeholder="">
                                                                        @error('address') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="title">{{__('translation.area')}}</label>
                                                                        <select wire:model.defer="area_id" class="select2 AreaSelect form-control "
                                                                            style="width:100%">
                                                                            <option value="">----</option>
                                                                            @foreach ($areas as $area)
                                                                            <option value="{{$area->id}}">{{$area->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('area_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="title">{{__('translation.sub_areas')}}</label>
                                                                        <select wire:model.defer="sub_area_id" class="select2  form-control"
                                                                            style="width:100%">
                                                                            <option value="">----</option>
                                                                            @foreach ($sub_areas as $sub_area)
                                                                            <option value="{{$sub_area->id}}">{{$sub_area->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('sub_area_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="title">{{__('translation.phone')}}</label>
                                                                        <div class="input-group mb-2 text-left">
                                                                            <input type="number" wire:model.defer="phone" class="form-control" id="title"
                                                                                placeholder="">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text">249</div>
                                                                            </div>
                                                                            @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group floating-label-form-group">
                                                                        <label for="title">{{__('translation.is_has_custom_price')}}</label>
                                                                        <br>
                                                                        <input type="checkbox" class="switch" wire:model.defer="is_has_custom_price"
                                                                            class="form-control" id="check_box_sercvies" placeholder="">
                                                                        @error('is_has_custom_price') <span class="text-danger error">{{ $message
                                                                            }}</span>@enderror
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="service_price" style="display: none">
                                                                <div class="row">
                                                                    @foreach ($services as $service )
                                                                    <div class="col-md-6">
                                                                        <fieldset class="form-group floating-label-form-group">
                                                                            <label for="title">{{$service->name}}</label>
                                                                            <input type="number" wire:model.defer="serviec_{{$service->id}}"
                                                                                name="serviec_{{$service->id}}" class="form-control"
                                                                                id="serviec_{{$service->id}}" placeholder="">
                                                                            @error('serviec_{{$service->id}}') <span class="text-danger error">{{ $message
                                                                                }}</span>@enderror

                                                                        </fieldset>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                                                                value="{{__('translation.cancel')}}">
                                                            <input type="submit" class="btn btn-outline-info btn-lg" value="{{__('translation.add')}}">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </section>
    <!--/ Zero configuration table -->
</div>
</div>
@endsection

