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
                @include('includes.dashboard.notifications')
                <div class="row">
                    <div class="col-12">
                        @if ($representative_deserves_calculation_method == 'percentage')
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="repeat-form">{{__('translation.representative.percentage')}}
                                </h4>

                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                wire:model="representative_percentage">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button wire:click="representativePercentageSave" class="btn btn-info">
                                        {{__('translation.save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="repeat-form">
                                    {{__('translation.representatives.orders.ranges')}}</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="repeater-default">
                                        <div data-repeater-list="car">
                                            @if(count($ranges) > 0)
                                            @foreach ($ranges as $key => $range)
                                            <div>
                                                <form class="form row">
                                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                                        <label
                                                            for="email-addr">{{__('translation.order.range.from')}}</label>
                                                        <br>
                                                        <input wire:model="form_data.{{$key}}.from" type="text"
                                                            class="form-control"
                                                            placeholder="{{__('translation.order.range.from')}}">
                                                        @error("form_data.$key.from")
                                                        <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                                        <label for="pass">{{__('translation.order.range.to')}}</label>
                                                        <br>
                                                        <input wire:model="form_data.{{$key}}.to" type="text"
                                                            class="form-control"
                                                            placeholder="{{__('translation.order.range.to')}}">
                                                        @error("form_data.$key.to")
                                                        <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                                        <label for="pass">{{__('translation.price')}}</label>
                                                        <br>
                                                        <input wire:model="form_data.{{$key}}.price" type="text"
                                                            class="form-control"
                                                            placeholder="{{__('translation.price')}}">
                                                        @error("form_data.$key.price")
                                                        <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                        <button type="button" wire:click="deleteRange({{$key}})"
                                                            class="btn btn-danger" data-repeater-delete=""> <i
                                                                class="ft-x"></i>
                                                            {{__('translation.delete')}}</button>
                                                    </div>
                                                </form>
                                                <hr>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="form-group overflow-hidden">
                                            <div class="col-12">
                                                <button wire:click="addRange" class="btn btn-primary">
                                                    <i class="ft-plus"></i>{{__('translation.add')}}
                                                </button>
                                                <button wire:click="submitRanges" class="btn btn-success">
                                                    <i class="ft-plus"></i> {{__('translation.save')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="repeat-form">
                                    {{__('translation.exceeding.order.ranges.bounce')}}
                                </h4>

                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                wire:model="exceeding_order_ranges_bounce">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button wire:click="exceedingOrderRangesBounce" class="btn btn-info">
                                        {{__('translation.save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="repeat-form">{{__('translation.order.return.price')}}
                                </h4>

                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" wire:model="order_return_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button wire:click="orderReturnPriceSave" class="btn btn-info">
                                        {{__('translation.save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="repeat-form">{{__('translation.tax_precntage')}}
                                </h4>

                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" wire:model="tax">
                                        </div>
                                        @error('tax')
                                                        <p class="text-danger">{{$message}}</p>
                                                        @enderror

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button wire:click="updateTaxValue" class="btn btn-info">
                                        {{__('translation.save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>



</div>



@push('scripts')
<script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script>
    (function(window, document, $) {
        'use strict';

        // Default
        $('.repeater-default').repeater();

        // Custom Show / Hide Configurations
        $('.file-repeater, .contact-repeater').repeater({
        show: function () {
        $(this).slideDown();
        },
        hide: function(remove) {
        if (confirm('Are you sure you want to remove this item?')) {
        $(this).slideUp(remove);
        }
        }
        });
    })(window, document, jQuery);
</script>

@endpush
