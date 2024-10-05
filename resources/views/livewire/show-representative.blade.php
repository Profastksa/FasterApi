<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.representatives')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('representatives') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <button data-toggle="modal" data-target="#AddModal" class="btn btn-round btn-info" type="button"><i
                            class="la la-plus la-sm"></i>
                        {{__('translation.add')}}</button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <fieldset class="form-group posision-relative">
                                        <input placeholder="{{__('translation.search')}}" wire:model="searchTerm"
                                            type="search" class="form-control" id="search">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                   <th>الرمز</th>
                                                <th>{{__('translation.email')}}</th>
                                                <th>{{__('translation.area')}}</th>
                                                <th>{{__('translation.address')}}</th>
                                                <th>{{__('translation.phone')}}</th>
                                                <th>{{__('translation.representative.balance')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $representative)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $representative->fullname }}</td>
                                                 <td>GIZ-{{ $representative->id }}</td>
                                                <td>{{ $representative->email }}</td>
                                                <td>
                                                    {{ $representative->Area->name }}
                                                </td>
                                                <td>{{ $representative->address }}</td>
                                                <td><div style="min-width: 150px"></div>
                                                    @php
                                                    $PhoneArray = explode(' ' , trim($representative->phone));
                                                    @endphp
                                                    <span>{{$PhoneArray[1] ?? ' '}}</span>
                                                    <span>{{substr($PhoneArray[0], 1) ?? ' '}}</span>
                                                    <span>+</span>
                                                </td>
                                                <td>
                                                    <span data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{__('translation.representative.balance')}}"
                                                        class="badge badge-primary">
                                                        {{ $representative->account_balance .' '.
                                                        __('translation.real.sign') }}</span>
                                                </td>
                                                <td>@livewire('toggle-button', ['model'=> $representative, 'field'
                                                    =>
                                                    'is_active'], key('toggle-button'.$representative->id))</td>
                                                <td>
                                                    <div class="" style="min-width:200px"></div>
                                                    <a href='{{ route('attachments', ['clientId' => $representative->id , 'type' => 'representative']) }}'
                                                        class="btn btn-sm btn-icon
                                                        btn-outline-info"><i class="la la-file"></i>
                                                    </a>
                                                    <livewire:components.representative-areas
                                                        :representativeId="$representative->id"
                                                        :wire:key="'representative-areas'.$representative->id" />
                                                    <button data-toggle="modal" data-target="#updateModal"
                                                        data-backdrop="static" data-keyboard="false"
                                                        wire:click="edit({{ $representative->id }})" class="btn btn-sm btn-icon
                                                        btn-primary"><i class="la la-edit"></i></button>
                                                    {{--
                                                    <livewire:components.representative-and-client-payment
                                                        :model="$representative" isClient="false"
                                                        paymentFlag="is_representative_payment"
                                                        :key="'representative-and-client-payment'.$representative->id" />
                                                    --}}
                                                    <livewire:components.delete-button :model="$representative"
                                                        :wire:key="'delete-button'.$representative->id" />
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="10">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="width: 3px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.email')}}</th>
                                                <th>{{__('translation.area')}}</th>
                                                <th>{{__('translation.address')}}</th>
                                                <th>{{__('translation.phone')}}</th>
                                                <th>{{__('translation.representative.balance')}}</th>
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
                {!! $data->links() !!}
            </section>
        </div>
    </div>


    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="AddModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.add.representive')}}</h3>
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
                                    <input type="text" wire:model.defer="passwordConfirm" class="form-control" id="email"
                                        placeholder="">
                                    @error('passwordConfirm') <span class="text-danger error">{{ $message }}</span>@enderror
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
                                    <select wire:model="area_id" class="select2 AreaSelect form-control "
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
                            <div class="col-md-6 text-center">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="title">{{__('translation.phone')}}</label>
                                    <div class="input-group mb-2 text-left" >
                                    <input type="number" wire:model.defer="phone" class="form-control" id="title"
                                        placeholder="" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{$OrganizationProfile->countery_key}}</div>
                                    </div>
                                    @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                                </fieldset>
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

    <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="updateModal" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.representive.edit')}}</h3>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update()">
                    <div class="modal-body">
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
                                        <label for="email">{{__('translation.address')}}</label>
                                        <input type="text" wire:model.defer="address" class="form-control" id="email"
                                            placeholder="">
                                        @error('address') <span class="text-danger error">{{ $message }}</span>@enderror
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{__('translation.area')}}</label>
                                        <select wire:model="area_id" class="select2 AreaSelect form-control "
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
                                <div class="col-md-6 text-center">
                                    <fieldset class="form-group floating-label-form-group">
                                        <label for="title">{{__('translation.phone')}}</label>
                                        <div class="input-group mb-2 text-left" >
                                        <input type="number" wire:model.defer="phone" class="form-control" id="title"
                                            placeholder="">
                                        @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{ $OrganizationProfile->countery_key }}</div>
                                        </div>
                                    </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <input wire:click.prevent="cancel()" type="reset" class="btn btn-outline-secondary btn-lg"
                                data-dismiss="modal" value="{{__('translation.cancel')}}">
                            <input type="submit" class="btn btn-outline-info btn-lg" value="{{__('translation.edit')}}">
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>


@push('scripts')
<script type="text/javascript">
    document.addEventListener('livewire:load', function () {
        window.livewire.on('stored', () => {
        console.log('jksaaltignai');
        $('#AddModal').modal('hide');
        $('#AddModal').hide();
        $('.modal-backdrop').hide();
    });
    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });
    // $('.select2').select2();
    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }


    });
</script>
@endpush
