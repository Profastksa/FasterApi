<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.sub_areas')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('sub_areas', $area) }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <button data-toggle="modal" data-target="#AddArea" class="btn btn-round btn-info" type="button"><i
                            class="la la-plus la-sm"></i>
                        {{__('translation.add')}}</button>

                </div>
                <div class="btn-group">
                    <a href="{{route('areas.index')}}" class="btn btn-round btn-warning" type="button"><i
                            class="la la-arrow-up la-sm"></i>
                        {{__('translation.back')}}</a>
                </div>
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
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.dashboard.notifications')
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">{{__('translation.No')}}</th>
                                                <th>{{__('translation.name')}}</th>
                                                <th>{{__('translation.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($data) > 0)
                                            @foreach ($data as $key => $sub_area)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sub_area->name }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-icon btn-sm btn-info"
                                                        href="{{ route('sub_areas.index',$sub_area->id) }}"><i
                                                        class="la la-eye"></i></a> --}}
                                                    <button data-toggle="modal" data-target="#updateModal"
                                                        data-backdrop="static" data-keyboard="false"
                                                        wire:click="edit({{ $sub_area->id }})" class="btn btn-sm btn-icon
                                                        btn-primary"><i class="la la-edit"></i></button>
                                                    <button wire:click="$emit('triggerDelete',{{ $sub_area->id }})"
                                                        class="btn btn-icon btn-danger btn-sm"><i
                                                            class="la la-trash"></i></button>
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
            <!--/ Zero configuration table -->
        </div>
    </div>


    <div wire:ignore.self class="modal fade text-left" id="AddArea" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel35"> {{__('translation.area.add')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="store()">
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.name')}}</label>
                            <input type="text" wire:model.defer="name" class="form-control" id="email" placeholder="">
                            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>

                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                            value="{{__('translation.cancel')}}">
                        <input type="submit" class="btn btn-outline-primary btn-lg" value="{{__('translation.add')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade text-left" id="updateModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel35"> {{__('translation.area.add')}}</h3>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update()">
                    <div class="modal-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label for="email">{{__('translation.name')}}</label>
                            <input type="text" wire:model.defer="name" class="form-control" id="email" placeholder="">
                            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </fieldset>

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
