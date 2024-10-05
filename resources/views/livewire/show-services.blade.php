<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.services')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('services') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">

            </div>
        </div>
        <div class="content-body">
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
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.price')}}</th>
                                                <th>{{__('translation.descr')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.photo')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->price }}</td>
                                                <td>{{ $service->descr }}</td>
                                                <td>
                                                    <fieldset>
                                                        <livewire:toggle-button :model="$service" field="is_active"
                                                            key="{{'toggle-button'. $service->id }}" />
                                                    </fieldset>

                                                </td>
                                                <td><img style="width: 50px; height:50px"
                                                        src="{{ asset('uploads/'.$service->photo) }}" alt=""></td>
                                                <td>

                                                    <button data-toggle="modal" data-target="#updateModal"
                                                        data-backdrop="static" data-keyboard="false"
                                                        wire:click="edit({{ $service->id }})" class="btn btn-sm btn-icon
                                                        btn-primary"><i class="la la-edit"></i></button>
                                                    <livewire:components.notes-modal :model="$service"
                                                        key="{{'delete-button'. $service->id }}" />
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="4">{{__('translation.table.empty')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="width: 10px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.price')}}</th>
                                                <th>{{__('translation.descr')}}</th>
                                                <th>{{__('translation.status')}}</th>
                                                <th>{{__('translation.photo')}}</th>
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




    <div wire:ignore.self class="modal fade text-left" id="updateModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel35"> {{__('translation.service.edit')}}</h3>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update()">
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="name">{{__('translation.name')}}</label>
                            <input type="text" wire:model.defer="name" class="form-control" id="name" placeholder="">
                            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                        @if ($showCODField)
                        <fieldset class="form-group floating-label-form-group">
                            <label for="name">{{__('translation.service_1_translation')}}</label>
                            <input type="number" wire:model.defer="price" class="form-control" id="price" placeholder="">
                            @error('Price') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="name">{{__('translation.service_11_translation')}}</label>
                            <input type="number" wire:model.defer="cod" class="form-control" id="cod" placeholder="">
                            @error('cod') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                        @else
                            <fieldset class="form-group floating-label-form-group">
                                <label for="name">{{__('translation.price')}}</label>
                                <input type="text" wire:model.defer="price" class="form-control" id="price" placeholder="">
                                @error('Price') <span class="text-danger error">{{ $message }}</span>@enderror
                            </fieldset>
                        @endif


                        <fieldset class="form-group floating-label-form-group">
                            <label for="descr">{{__('translation.descr')}}</label>
                            <input type="text" wire:model.defer="descr" class="form-control" id="descr" placeholder="">
                            @error('descr') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="photo">{{__('translation.photo')}}</label>
                            <input type="file" wire:model.defer="photo" class="form-control" id="photo" placeholder="">
                            @error('photo') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>
                        {{-- <fieldset>
                        <label for="switch1">{{__('translation.status')}}</label>
                        <div class="">
                            <input type="checkbox" wire:model.defer="is_active"
                                data-on-label="{{__('translation.active')}}"
                                data-off-label="{{__('translation.inactive')}}" class="switch" id="switch1"
                                {{$is_active ? 'checked':''}} />
                        </div>
                        @error('is_active') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset> --}}


                    </div>
                    <div class="modal-footer">
                        <input wire:click.prevent="cancel()" type="reset" class="btn btn-outline-secondary btn-lg"
                            data-dismiss="modal" value="{{__('translation.cancel')}}">
                        <input type="submit" class="btn btn-outline-primary btn-lg" value="{{__('translation.edit')}}">
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- //notes --}}
</div>


@push('scripts')

<script type="text/javascript">
    window.livewire.on('areaStore', () => {
        $('#AddArea').modal('hide');
    });
    window.livewire.on('areaUpdate', () => {
        $('#updateModal').modal('hide');
    });
</script>

{{-- DELETE CONFIRMATION SWEETALERT --}}
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        @this.on('triggerDelete', sub_area_id => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Area record will be deleted!',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Delete!'
            }).then((result) => {
         //if user clicks on delete
                if (result.value) {
             // calling destroy method to delete
                    @this.call('delete',sub_area_id)
             // success response
                    // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                } else {
                    Swal.fire({
                        title: 'Operation Cancelled!',
                        icon: 'success'
                    });
                }
            });
        });
    })
</script>
@endpush
