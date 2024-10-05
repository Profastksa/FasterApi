<div class="d-inline">
    <button data-toggle="tooltip" data-placement="top" data-original-title="{{__('translation.delete')}}"
        wire:click="$emit('triggerDelete', {{$model->id}})" class="btn btn-icon btn-danger btn-sm"><i
            class="la la-trash"></i></button>
</div>
