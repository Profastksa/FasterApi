<div class="d-inline">
    <button data-toggle="modal" data-target="#areas{{ $representativeId }}" class="btn btn-sm btn-icon btn-warning"><i
            class="la la-map-marker"></i></button>

    <div wire:ignore.self class="modal fade text-left" id="areas{{ $representativeId }}" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel35"> {{__('translation.representative.subareas') }}
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        {{-- @php
                        print_r($selectedAreas) ;
                        @endphp --}}
                        @foreach ($AllAreas as $key => $area)
                        <div class="col-md-4">
                            <h6 class='mb-1'>{{$area->name}}</h6>
                            @foreach ($area->subAreas as $subarae)
                            <div class="col-12 ">
                                <fieldset>
                                    <input wire:model="selectedAreas.{{$subarae->id}}" value="{{$subarae->id}}" type="checkbox"
                                        class="form-checkbox h-6 w-6 text-green-500">
                                    <label for="input-15">{{$subarae->name}}</label>
                                </fieldset>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                        value="{{__('translation.cancel')}}">
                    <input type="submit" class="btn btn-outline-info btn-lg" wire:click="addAreas"
                        value="{{__('translation.save')}}">
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
     document.addEventListener('livewire:load', function () {
        window.livewire.on('representative_areas_saved', () => {
            console.log('event triger');
            $('#areas{{ $representativeId }}').modal('hide');
        });
    });
</script>
@endpush
