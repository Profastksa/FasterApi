<form action="{{route('notification.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('translation.title')}}</label>
                <input type="text" class="form-control" name="title" id=""
                    aria-describedby="helpId" placeholder="">
                @error('title') <span class="text-danger error">{{ $message
                    }}</span>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('translation.type')}}</label>
                <br />
                <select class="form-control" name="to" wire:model='To' id="">
                    <option value="1"> {{__('translation.clients')}}</option>
                    <option value="2"> {{__('translation.representative')}}</option>
                </select>
                @error('to') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <label> {{__('translation.content')}}</label>
            <textarea name="content" id="" cols="30" rows="10"
                class="form-control"></textarea>
            @error('content') <span class="text-danger error">{{ $message }}</span>@enderror

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('translation.area')}}</label>
                <br />
                <select class="form-control" name="area_id" id="">
                    <option value="all">{{__('translation.all_area')}}</option>
                    @foreach ($Area as $area )
                    <option value="{{$area->id}}">{{$area->name}}</option>
                    @endforeach
                </select>
                @error('area_id') <span class="text-danger error">{{ $message
                    }}</span>@enderror
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{__('translation.notify_image')}}</label>
                        <input type="file"
                            class="form-control form-control-sm" name="photo" accept="image/*" placeholder="">
                        {{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                    <label for="ToSpiUser"> {{__('translation.to_spicfic_user')}} </label>
                        <input type="checkbox" class="form-control switch" wire:model='ToSpicficUser' name="ToSpicficUser" id=""
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>

                <div class="col-8">
                    <div class="form-group">
                        <label for="">{{ __('translation.users')}}</label>
                        <br />
                        <select class="form-control select2"  name="user_id" id="" {{ $Disabled ? "disabled" : null}}>
                            @if(count($Users))
                            <option value="">{{__('translation.change_user')}}</option>
                            @else
                            <option value="">{{__('translation.no_Data_right_now')}}</option>
                            @endif
                            @foreach ($Users as $User )
                            <option value="{{$User->id}}">{{$User->fullname}}</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-danger error">{{ $message
                            }}</span>@enderror
                </div>
            </div>
        </div>
    </div>
        </div>
        <div class="m-1 mt-3">
            <a href="{{route('notification.index')}}" type="button"
                class="btn btn-warning mr-1">
                <i class="la la-remove"></i> {{__('translation.cancel')}}
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="la la-check"></i> {{__('translation.send')}}
            </button>
        </div>
    </div>
</form>
@push('script')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.select2').select2();
            $('select').select2();
        });

    </script>
@endpush
