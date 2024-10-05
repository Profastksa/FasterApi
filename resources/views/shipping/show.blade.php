@extends('layouts.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.sync_with_shipping_company') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('sync_with_shipment_company') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <a href="{{ route('orders') }}" class="btn btn-round btn-info" type="button"><i class="icon-cog3"></i>
                        {{ __('translation.back') }}</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="row-separator-colored-controls">
                                {{ __('translation.sync_with_shipping_company') }}
                            </h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
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
                            <div class="card-body">
                                {!! Form::open(['route' => 'syncShipingWithOrder', 'method' => 'POST']) !!}
                                {!! Form::hidden('ids', request()->ids) !!}
                                {!! Form::hidden('type', request()->shiping_type) !!}


                                @if (request()->shiping_type == 'smsaWithOneSenderEdite')
                                <!-- Shipper Information -->
                                <h4 class="form-section"><i
                                    class="la la-paper-plane"></i> بيانات المرسل
                            </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                            for="shipper_name">{{ __('translation.shipper_name') }}</label>
                                        <div class="col-md-9">
                                            {!! Form::text('shipper_name', 'FASTER', [
                                                'placeholder' => __('translation.shipper_name'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('shipper_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                            for="shipper_contact_name">{{ __('translation.shipper_contact_name') }}</label>
                                        <div class="col-md-9">
                                            {!! Form::text('shipper_contact_name', 'FASTER', [
                                                'placeholder' => __('translation.shipper_contact_name'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('shipper_contact_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                            for="shipper_address_line1">{{ __('translation.shipper_address_line1') }}</label>
                                        <div class="col-md-9">
                                            {!! Form::text('shipper_address_line1', '999 GIZAN', [
                                                'placeholder' => __('translation.shipper_address_line1'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('shipper_address_line1')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                            for="shipper_city">{{ __('translation.shipper_city') }}</label>
                                        <div class="col-md-9">
                                            {!! Form::text('shipper_city', 'Jazan', [
                                                'placeholder' => __('translation.shipper_city'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('shipper_city' )
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                            for="shipper_country">{{ __('translation.shipper_country') }}</label>
                                        <div class="col-md-9">
                                            {!! Form::text('shipper_country', 'SA', [
                                                'placeholder' => __('translation.shipper_country'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('shipper_country' )
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"
                                            for="shipper_phone">{{ __('translation.shipper_phone') }}</label>
                                        <div class="col-md-9">
                                            {!! Form::text('shipper_phone', '+966533486562', [
                                                'placeholder' => __('translation.shipper_phone'),
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('shipper_phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- Add other Shipper fields here -->
                            @endif

                                @foreach ($orders as $order)
                                    <div class="form-body">
                                        <h4 class="form-section"><i
                                                class="la la-exclamation-circle"></i>{{ __('translation.order_info_fo_number') . ' - ' . $order->id }}
                                        </h4>
                                        <div class="row">

                                            @if (request()->shiping_type == 'smsaWithSenderEdite')
                                                <!-- Shipper Information -->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control"
                                                            for="shipper_name">{{ __('translation.shipper_name') }}</label>
                                                        <div class="col-md-9">
                                                            {!! Form::text('shipper_name[' . $order->id . ']', 'FASTER', [
                                                                'placeholder' => __('translation.shipper_name'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            @error('shipper_name.' . $order->id)
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control"
                                                            for="shipper_contact_name">{{ __('translation.shipper_contact_name') }}</label>
                                                        <div class="col-md-9">
                                                            {!! Form::text('shipper_contact_name[' . $order->id . ']', 'FASTER', [
                                                                'placeholder' => __('translation.shipper_contact_name'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            @error('shipper_contact_name.' . $order->id)
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control"
                                                            for="shipper_address_line1">{{ __('translation.shipper_address_line1') }}</label>
                                                        <div class="col-md-9">
                                                            {!! Form::text('shipper_address_line1[' . $order->id . ']', '999 GIZAN', [
                                                                'placeholder' => __('translation.shipper_address_line1'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            @error('shipper_address_line1.' . $order->id)
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control"
                                                            for="shipper_city">{{ __('translation.shipper_city') }}</label>
                                                        <div class="col-md-9">
                                                            {!! Form::text('shipper_city[' . $order->id . ']', 'Jazan', [
                                                                'placeholder' => __('translation.shipper_city'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            @error('shipper_city.' . $order->id)
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control"
                                                            for="shipper_country">{{ __('translation.shipper_country') }}</label>
                                                        <div class="col-md-9">
                                                            {!! Form::text('shipper_country[' . $order->id . ']', 'SA', [
                                                                'placeholder' => __('translation.shipper_country'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            @error('shipper_country.' . $order->id)
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control"
                                                            for="shipper_phone">{{ __('translation.shipper_phone') }}</label>
                                                        <div class="col-md-9">
                                                            {!! Form::text('shipper_phone[' . $order->id . ']', '+966533486562', [
                                                                'placeholder' => __('translation.shipper_phone'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            @error('shipper_phone.' . $order->id)
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add other Shipper fields here -->
                                            @endif



                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput1">{{ __('translation.name') }}</label>
                                                    <div class="col-md-9">
                                                        {!! Form::text('name[' . $order->id . ']', $order->receiver_name, [
                                                            'placeholder' => '',
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                        @if ($errors->has('name.' . $order->id))
                                                            <div class="text-danger">
                                                                {{ $errors->first('name.' . $order->id) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput2">{{ __('translation.phone') }}</label>
                                                    <div class="col-md-9">
                                                        {{-- <input type="text" id="userinput2" class="form-control  "
                                                placeholder="Last Name" name="lastname"> --}}
                                                        {!! Form::text('phone[' . $order->id . ']', $order->receiver_phone_no, [
                                                            'placeholder' => 'Email',
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                        @error('phone')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                        @if ($errors->has('phone.' . $order->id))
                                                            <div class="text-danger">
                                                                {{ $errors->first('phone.' . $order->id) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput3">{{ __('translation.address') }}</label>
                                                    <div class="col-md-9">
                                                        {{-- <input type="text" id="userinput3" class="form-control  "
                                                placeholder="Username" name="username"> --}}
                                                        {!! Form::text('address[' . $order->id . ']', $order->receiver_address, [
                                                            'placeholder' => '',
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                        @if ($errors->has('address.' . $order->id))
                                                            <div class="text-danger">
                                                                {{ $errors->first('address.' . $order->id) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control"
                                                        for="country">{{ __('translation.country') }}</label>
                                                    <div class="col-md-9">
                                                        {!! Form::text('country[' . $order->id . ']', $order->receiverArea->country_code, [
                                                            'placeholder' => __('translation.select_country'),
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                        {!! Form::hidden('ref[' . $order->id . ']', $order->tracking_number, ['class' => 'form-control']) !!}
                                                        {!! Form::hidden('ClinetName[' . $order->id . ']', $order->client->fullname, ['class' => 'form-control']) !!}

                                                        @if ($errors->has('country.' . $order->id))
                                                            <div class="text-danger">
                                                                {{ $errors->first('country.' . $order->id) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput4">{{ __('translation.city') }}</label>
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            {{-- <select class="form-control" name="city[{{ $order->id }}]"
                                                                id="">
                                                                <option selected
                                                                    value=" {{ $order->receiverSubArea->name ?? '---' }}">
                                                                    {{ $order->receiverSubArea->name ?? '---' }}</option>
                                                            </select> --}}
                                                            {!! Form::text('city[' . $order->id . ']', $order->receiverSubArea->name ?? '---', [
                                                                'placeholder' => __('translation.select_country'),
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                        @if ($errors->has('city.' . $order->id))
                                                            <div class="text-danger">
                                                                {{ $errors->first('city.' . $order->id) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput4">{{ __('translation.postalcode') }}</label>
                                                    <div class="col-md-9">
                                                        {{-- <input type="text" id="userinput4" class="form-control  "
                                                placeholder="Nick Name" name="nickname"> --}}
                                                        {!! Form::text('postalcode[' . $order->id . ']', $order->code, ['placeholder' => '', 'class' => 'form-control']) !!}
                                                        @error('postalcode')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput4">{{ __('translation.order_weight') }}</label>
                                                    <div class="col-md-9">
                                                        {{-- <input type="text" id="userinput4" class="form-control  "
                                                placeholder="Nick Name" name="nickname"> --}}
                                                        {!! Form::text('weight[' . $order->id . ']', $order->order_weight, [
                                                            'placeholder' => '',
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                        @error('wight')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control"
                                                        for="userinput4">{{ __('translation.number_of_peaces') }}</label>
                                                    <div class="col-md-9">
                                                        {{-- <input type="text" id="userinput4" class="form-control  "
                                                placeholder="Nick Name" name="nickname"> --}}
                                                        {!! Form::text('number_of_peaces[' . $order->id . ']', $order->number_of_pieces, [
                                                            'placeholder' => '',
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                        @error('number_of_peaces')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                <div class="form-actions right">
                                    <a href="{{ url()->previous() }}" type="button" class="btn btn-warning mr-1">
                                        <i class="la la-remove"></i> {{ __('translation.cancel') }}
                                    </a>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check"></i> {{ __('translation.confirm') }}
                                    </button>
                                </div>
                                {{-- </form> --}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
