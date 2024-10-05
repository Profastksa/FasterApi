<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('clients') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <button data-toggle="modal" data-target="#AddArea" class="btn btn-round btn-info" type="button"><i
                            class="la la-plus la-sm"></i>
                        {{__('translation.add')}}</button>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
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
                                        {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
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
                                                    <th>{{__('translation.code')}}</th>

                                                    <th>{{__('translation.name')}}</th>
                                                    <th>{{__('translation.email')}}</th>
                                                    <th>{{__('translation.area')}}</th>
                                                    <th>{{__('translation.sub_areas')}}</th>
                                                    <th>{{__('translation.phone')}}</th>
                                                    <th>{{__('translation.address')}}</th>
                                                    {{-- <th>{{__('translation.discount.rate')}}</th> --}}
                                                    <th>{{__('translation.account.balance')}}</th>
                                                    <th>{{__('translation.status')}}</th>

                                                    <th>{{__('translation.client_type')}}</th>
                                                    {{-- <th>{{__('translation.activity')}}</th> --}}
                                                    <th>{{__('translation.bank')}}</th>
                                                    <th>{{__('translation.bank_acount_owwner')}}</th>
                                                    <th>{{__('translation.bank_acount_nummber')}}</th>
                                                    <th>{{__('translation.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($data) > 0)
                                                @foreach ($data as $key => $client)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>GIZ-{{ $client->id }}</td>
                                                    <td>{{ $client->fullname }}</td>
                                                    <td>{{ $client->email }}</td>
                                                    <td>{{ $client->Area->name ?? ' - ' }}</td>
                                                    <td>{{ $client->subArea->name }}</td>
                                                    <td><div style="min-width: 150px"></div>
                                                        {{ $client->phone }}
                                                        {{-- @php
                                                        $PhoneArray = explode(' ', trim($client->phone));
                                                        @endphp
                                                        <span>{{$PhoneArray[1] ?? ' '}}</span>
                                                        <span>{{substr($PhoneArray[0], 1)   ?? ' '}}</span>
                                                        <span>+</span> --}}
                                                    </td>
                                                    <td>{{ $client->address }}</td>
                                                    <td>
                                                        <span data-toggle="tooltip" data-placement="top"
                                                            data-original-title="{{__('translation.discount.rate')}}"
                                                            class="badge badge-primary">
                                                            {{ $client->discount_rate }}%</span>
                                                        <span data-toggle="tooltip" data-placement="top"
                                                            data-original-title="{{__('translation.account.balance')}}"
                                                            class="badge badge-primary">
                                                            {{ $client->account_balance .' '.
                                                            __('translation.real.sign')
                                                            }}</span>

                                                    </td>
                                                    {{-- <td>{{ $client->account_balance }}</td> --}}
                                                    <td>@livewire('toggle-button', ['model'=> $client, 'field'
                                                        =>
                                                        'is_active'], key('toggle-button'.$client->id))</td>
                                                    <td>{{ $client->client_type ? __('translation.'.$client->client_type) : ' ' }}</td>
                                                    <td>{{ $client->bank }}</td>
                                                    <td>{{ $client->bank_account_owner }}</td>
                                                    <td>{{ $client->bank_account_number }}</td>
                                                    <td>
                                                        <div style="max-width:200px; min-width:200px;"></div>
                                                        <a href='{{ route('attachments', ['clientId' => $client->id , 'type' => 'clients']) }}'
                                                            class="btn btn-sm btn-icon
                                                            btn-outline-info"><i class="la la-file"></i>
                                                        </a>
                                                        <button data-toggle="modal" data-target="#updateModal"
                                                            data-backdrop="static" data-keyboard="false"
                                                            wire:click="edit({{ $client->id }})" class="btn btn-sm btn-icon
                                                            btn-primary"><i class="la la-edit"></i></button>
                                                        <button wire:click='assginClient({{$client->id}})'
                                                            data-toggle="modal" data-target="#GnarateKeys"
                                                            data-backdrop="static" data-keyboard="false" class="btn btn-sm btn-icon
                                                            "><i class="la la-key"></i>
                                                        </button>
                                                        <livewire:components.delete-button :model="$client"
                                                            :wire:key="'delete-button'.$client->id" />
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
                                                    <th>{{__('translation.code')}}</th>
                                                    <th>{{__('translation.name')}}</th>
                                                    <th>{{__('translation.email')}}</th>
                                                    <th>{{__('translation.area')}}</th>
                                                    <th>{{__('translation.sub_areas')}}</th>
                                                    <th>{{__('translation.phone')}}</th>
                                                    <th>{{__('translation.address')}}</th>
                                                    {{-- <th>{{__('translation.discount.rate')}}</th> --}}
                                                    <th>{{__('translation.account.balance')}}</th>
                                                    <th>{{__('translation.status')}}</th>
                                                    <th>{{__('translation.client_type')}}</th>
                                                    {{-- <th>{{__('translation.activity')}}</th> --}}
                                                    <th>{{__('translation.bank')}}</th>
                                                    <th>{{__('translation.bank_acount_owwner')}}</th>
                                                    <th>{{__('translation.bank_acount_nummber')}}</th>
                                                    <th>{{__('translation.action')}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! $data->links() !!}
            </section>
            <!--/ Zero configuration table -->
        </div>
    </div>


    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="AddArea" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
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
                                                    <div class="input-group-text">{{ $OrganizationProfile->countery_key }}</div>
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
                            </div>
                             <div class="col-md-6 ">
                                <div class="row">
                                    <div class="col-md-6  d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="email">{{__('translation.civil_registry')}}</label>
                                            <input type="text" wire:model.defer="civil_registry" class="form-control" id="email" value="0"
                                                placeholder="">
                                            @error('civil_registry') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="text">{{__('translation.client_type')}}</label>
                                            <select wire:model.defer="client_type" class="form-control" id="email">
                                                <option value="" selected>---</option>
                                                <option value="normal" selected>{{__('translation.normal')}}</option>
                                                <option value="company">{{__('translation.company')}}</option>
                                            </select>
                                            @error('client_type') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.bank_account_owner')}}</label>
                                            <input type="text" wire:model.defer="bank_account_owner" class="form-control" id="title"
                                                placeholder="">
                                            @error('bank_account_owner') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.bank')}}</label>
                                            <select wire:model.defer='bank' class="form-control" value="0">
                                                @foreach($Banks as $Bank)
                                                    <option value="{{$Bank}}">{{$Bank}}</option>
                                                @endforeach
                                        </select>
                                            @error('bank') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="email">{{__('translation.bank_account_number')}}</label>
                                            <input type="number" wire:model.defer="bank_account_number" class="form-control" id="email" value="0"
                                                placeholder="">
                                            @error('bank_account_number') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <hr />
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="number">{{__('translation.iban_number')}}</label>
                                            <input type="text" wire:model.defer="iban_number" class="form-control"
                                                id="email" placeholder="" value="0">
                                            @error('iban_number') <span class="text-danger error">{{ $message
                                                }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label for="title">{{__('translation.identify_image')}}</label>
                                            <input type="file" class="form-control" wire:model='identify_image'>
                                            @error('identify_image') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label for="title">{{__('translation.bank_account_image')}}</label>
                                            <input type="file" class="form-control"  wire:model='bank_account_image'>
                                            @error('bank_account_image') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="service_price" style="display: none">
                            <div class="row">
                                @foreach ($services as $service )
                                <div class="col-md-6">
                                    <fieldset class="form-group floating-label-form-group">
                                        <label for="title">{{ $ServicesName['service_' . $service->id]}}</label>
                                        <input type="number" wire:model.defer="serviec_{{$service->id}}"
                                            name="serviec_{{$service->id}}" class="form-control"
                                            id="serviec_{{$service->id}}" placeholder="">
                                        @error('serviec_{{$service->id}}') <span class="text-danger error">{{ $message
                                            }}</span>@enderror
                                    </fieldset>
                                </div>
                                @if ($service->id == 1)
                                <div class="col-md-6">
                                    <fieldset class="form-group floating-label-form-group">
                                        <label for="title">{{ $ServicesName['service_1' . $service->id]}}</label>
                                        <input type="number" wire:model.defer="serviec_1{{$service->id}}"
                                            name="serviec_1{{$service->id}}" class="form-control"
                                            id="serviec_1{{$service->id}}" placeholder="">
                                        @error('serviec_1{{$service->id}}') <span class="text-danger error">{{ $message
                                            }}</span>@enderror
                                    </fieldset>
                                </div>
                                @endif
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
    <div wire:ignore.self class="modal animated bounceInDown fade text-left" id="updateModal" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.client.edit')}}</h3>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="email">{{__('translation.name')}}</label>
                                            <input type="text" wire:model.defer="fullname" class="form-control" id="name"
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
                                            <input type="text" wire:model.defer="address" class="form-control" id="address"
                                                placeholder="">
                                            @error('address') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">{{__('translation.area')}}</label>
                                            <select wire:model.defer="sub_area_id" class="select2 form-control "
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
                                                {{-- <div class="input-group-prepend">
                                                    <div class="input-group-text">{{$OrganizationProfile->countery_key}}</div>
                                                </div> --}}
                                                @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.discount.rate')}}</label> (%)
                                            <input type="text" wire:model.defer="discount_rate" class="form-control"
                                                id="discount_rate" placeholder="">
                                            @error('discount_rate') <span class="text-danger error">{{ $message
                                                }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.account.balance')}}</label>
                                            <input disabled type="text" wire:model.defer="account_balance"
                                                class="disapled form-control" id="account_balance" placeholder="">
                                            @error('account_balance') <span class="text-danger error">{{ $message
                                                }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.is_has_custom_price')}}</label>
                                            <div>
                                                <input type="checkbox"
                                                    wire:click='ToggleUpdateModel("{{ $is_has_custom_price }}")' class="switch"
                                                    wire:model.defer="is_has_custom_price" class="form-control"
                                                    id="check_box_sercvies_edit" placeholder="">
                                                @error('is_has_custom_price') <span class="text-danger error">{{ $message
                                                    }}</span>@enderror
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="row">
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="email">{{__('translation.civil_registry')}}</label>
                                            <input type="text" wire:model.defer="civil_registry" class="form-control" id="email" value="a"
                                                placeholder="">
                                            @error('civil_registry') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 ">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="text">{{__('translation.client_type')}}</label>
                                            <select wire:model.defer="client_type" class="form-control" id="email">
                                                <option value="" selected>---</option>
                                                <option value="normal" selected>{{__('translation.normal')}}</option>
                                                <option value="company">{{__('translation.company')}}</option>
                                            </select>
                                            @error('client_type') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.bank_account_owner')}}</label>
                                            <input type="text" wire:model.defer="bank_account_owner" class="form-control" id="title" value="0"
                                                placeholder="">
                                            @error('bank_account_owner') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="title">{{__('translation.bank')}}</label>
                                            <select wire:model.defer='bank' class="form-control">
                                                @foreach($Banks as $Bank)
                                                    <option value="{{$Bank}}">{{$Bank}}</option>
                                                @endforeach
                                            </select>
                                            @error('bank') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="email">{{__('translation.bank_account_number')}}</label>
                                            <input type="number" wire:model.defer="bank_account_number" class="form-control" id="email" value="0"
                                                placeholder="">
                                            @error('bank_account_number') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </fieldset>
                                    </div>
                                    <hr />
                                    <div class="col-md-6 d-none">
                                        <fieldset class="form-group floating-label-form-group">
                                            <label for="number">{{__('translation.iban_number')}}</label>
                                            <input type="text" wire:model.defer="iban_number" class="form-control" value="0"
                                                id="email" placeholder="">
                                            @error('iban_number') <span class="text-danger error">{{ $message
                                                }}</span>@enderror
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row updating_area">
                            @foreach ($services as $service )
                            <div class="col-md-6">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="title">{{$ServicesName['service_' . $service->id]}}</label>
                                    <input type="text" wire:model.defer="serviec_{{$service->id}}"
                                        name="serviec_{{$service->id}}" class="form-control"
                                        id="serviec_{{$service->id}}" placeholder="" {{--
                                        value="{{ $ClientServices[$service->id] ? $ClientServices[$service->id]['price'] : null}}"
                                        --}} {{--
                                        value="{{ isset( $ClientServices[$service->id] )? $ClientServices[$service->id] != null ? $ClientServices[$service->id]['price'] :"" :"" }}"
                                        --}}>
                                    @error('serviec_{{$service->id}}') <span class="text-danger error">{{ $message
                                        }}</span>@enderror

                                </fieldset>
                            </div>
                            @if ($service->id == 1)
                                <div class="col-md-6">
                                    <fieldset class="form-group floating-label-form-group">
                                        <label for="title">{{ $ServicesName['service_1' . $service->id]}}</label>
                                        <input type="text" wire:model.defer="serviec_1{{$service->id}}"
                                            name="serviec_1{{$service->id}}" class="form-control"
                                            id="serviec_1{{$service->id}}" placeholder="">
                                        @error('serviec_1{{$service->id}}') <span class="text-danger error">{{ $message
                                            }}</span>@enderror
                                    </fieldset>
                                </div>
                            @endif
                            @endforeach
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
    <div wire:ignore.self class="modal fade" id="GnarateKeys" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('translation.ClientKes')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('translation.APIKEY')}}</label>
                        <input type="text" class="form-control" name="" wire:model='APIKey' disabled id=""
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('translation.ApiSecretKey')}}</label>
                        <input type="text" class="form-control" name="" wire:model='APISecretKey' disabled id=""
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{
                        __('translation.cancel')}}</button>
                    <button type="button" class="btn btn-primary"
                        wire:click='GenrateKeys()'>{{__('translation.genarate')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('scripts')
<script type="text/javascript">
    document.addEventListener('livewire:load', function () {
        var toogelForm = false;
        var toogelFormUpdate = true;
        // console.log(toogelForm);
        // $('#check_box_sercvies_edit').click(function(){
        //     console.log('edit');
        //     console.log($(this).val());
        // if(!toogelFormUpdate){
        //     $('.updating_area').show();
        //     toogelFormUpdate = true;
        // }else{
        //     $('.updating_area').hide();
        //     toogelFormUpdate = false;
        // }
        // });
        $('#check_box_sercvies').click(function(){
        console.log($(this).val());
        if(!toogelForm){
            $('.service_price').show();
            toogelForm = true;
        }else{
            $('.service_price').hide();
            toogelForm = false;
        }
        });
        window.livewire.on('has_custom' , (val)=>{
            console.log(val);
            if(val){
                $('.updating_area').show();
            }else{
                $('.updating_area').hide();
            }
        })

        $('.AreaSelect').change((e)=> {
            // console.log( e.target.value)
            @this.set('area_id' , e.target.value)
        })
    window.livewire.on('stored', () => {
        console.log('stored');
        $('#AddArea').modal('hide');
    });

    window.livewire.on('updating_Area_show' , ()=>{


        $('.updating_area').show();

    });

    $('.select2').select2();

    window.livewire.on('GenrateDone', ()=>{
        $('#GnarateKeys').hide();
        $('.modal-backdrop').hide();
    });

    window.livewire.on('updating_Area_hidden' , ()=>{
        $('.updating_area').hide();
    });


    // window.livewire.on('')
    window.livewire.on('updated', () => {
        $('#updateModal').modal('hide');
    });
    $('.select2').select2();
    function showPass($num){
        $('.iconLeft3').attr('type', 'text');
    }
       });


</script>
@endpush
