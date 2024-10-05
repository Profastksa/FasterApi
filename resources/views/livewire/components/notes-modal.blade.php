<div class="d-inline">
    <button data-toggle="modal" data-target="#notes{{ $model->id }}" class="btn btn-sm btn-icon btn-warning"><i
            class="la la-sticky-note"></i> {{__('translation.service.notes')}}</button>

    <div wire:ignore.self class="modal fade text-left  " id="notes{{ $model->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel35"> {{__('translation.service.notes') }}
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-sm-9">
                            <textarea wire:model.defer="note" class="form-control" id="placeTextarea" rows="1"
                                placeholder=""></textarea>
                        </div>
                        <div class="col-sm-3">
                            <button wire:click="addNote()" class="btn btn-round btn-info" type="button"><i
                                    class="la la-plus la-sm"></i>
                                {{__('translation.add')}}</button>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">{{__('translation.No')}}</th>
                                <th>{{__('translation.note')}}</th>
                                <th>{{__('translation.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($notes) > 0)
                            @foreach ($notes as $key => $note)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $note->body }}</td>
                                <td>
                                    <livewire:components.delete-button :model="$note" key="{{$note->id}}" />
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
                                <th>{{__('translation.note')}}</th>
                                <th>{{__('translation.action')}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                        value="{{__('translation.cancel')}}">
                </div>
            </div>
        </div>
    </div>
</div>
