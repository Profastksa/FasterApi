<div class="d-inline">
    <button data-toggle="modal" data-target="#payModal{{$model->id}}" class="btn btn-sm btn-icon btn-info"><i
            class="la la-money"></i></button>

    <div wire:ignore.self class="modal fade text-left animated bounceInDown" id="payModal{{$model->id}}" role="dialog"
        aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h3 class="modal-title white" id="myModalLabel35"> {{__('translation.fees.payment')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="pay()">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <fieldset class="form-group floating-label-form-group">
                                    <label for="title">{{__('translation.amount')}}</label>
                                    <input type="text" wire:model.defer="amountToPay" class="form-control" id="title"
                                        placeholder="">
                                    @error('amountToPay') <span class="text-danger error">{{ $message }}</span>@enderror
                                </fieldset>
                            </div>

                        </div>



                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                            value="{{__('translation.cancel')}}">
                        <input type="submit" class="btn btn-outline-info btn-lg" value="{{__('translation.transfer')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
