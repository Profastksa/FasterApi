<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.orders.management') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
            </div>

        </div>
        <div class="content-body">
            <div>
                <div class="card overflow-hidden">
                    <div class="card-content">
                        <div class="card-body cleartfix">
                            <div class="row">
                                {{-- <div class="col-md-3">
                        <fieldset class="form-group posision-relative">
                            <label for="">{{ __('translation.search') }}</label>
                            <input placeholder="{{ __('translation.search.by.order.id') }}"
                                wire:model="searchTerm" type="search" class="form-control"
                                id="search">
                        </fieldset>
                    </div> --}}

                                <div class="col-md-3">
                                    <div class="form-group posision-relative">
                                        <label for="">{{ __('translation.client') }}</label>
                                        <select class="form-control select2" wire:model='cleint_filter'
                                            id="cleintfilter">
                                            <option value="">{{ __('translation.client') }}
                                            </option>
                                            @foreach ($clients as $client)
                                                <option value='{{ $client->id }}'>
                                                    {{ $client->fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group posision-relative">
                                        <label for="">{{ __('translation.status') }}</label>
                                        <select class="form-control " wire:model='status_filter' id="">
                                            <option value="">{{ __('translation.change_the_status') }}
                                            </option>
                                            @foreach (App\Models\Order::STATUS as $status)
                                                <option value='{{ $status }}'>
                                                    {{ __('translation.' . $status) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="title">{{ __('translation.service') }}</label>
                                        <select class="form-control " wire:model='status_filter1' id="">
                                            <option value="">----</option>
                                            @foreach ($services->where('is_active', 1) as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="title">خدمة العملاء</label>
                            <input placeholder="  رقم هاتف العميل او المرسل او المستلم"
                                wire:model="coustmer_service_Filter" type="search"
                                class="form-control" id="search">
                        </div>
                    </div> --}}



                                {{-- <div class="col-sm-3">
                        <fieldset class="form-group">
                            <label for="">{{ __('translation.from') }}</label>
                            <input wire:model="from_date"
                                placeholder="{{ __('translation.from') }}" type="date"
                                class="form-control" id="date">
                        </fieldset>
                    </div>
                    <div class="col-sm-3">
                        <fieldset class="form-group">
                            <label for="">{{ __('translation.to') }}</label>
                            <input wire:model="to_date" placeholder="{{ __('translation.to') }}"
                                type="date" class="form-control" id="date">
                        </fieldset>
                    </div> --}}
                                <div class="col-sm-3">
                                    <fieldset class="form-group">
                                        <label for="">عدد الطلبات للعرض </label>
                                        <input wire:model="paginatenum" type="txt" class="form-control"
                                            id="paginatenum">
                                    </fieldset>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- <div class="card card-info">
        <div class="card-header">
            <div class="card-title">
                كشف حساب
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card overflow-hidden">
                    <div class="card-content">
                        <div class="card-body cleartfix">


                            <table class="table table-striped table-bordered">
                                <thead>

                                    <tr>

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($data) > 0)
                                        @foreach ($data as $key => $order)
                                            <tr align="center">
                                                <th>
                                                    <div class="card">
                                                        <div class="card-body " style ="">
                                                            <h5 class="card-title" style ="color: DodgerBlue"> مجموع
                                                                مبلغ
                                                                الدفع عند الاستلام
                                                            </h5>
                                                            <p class="card-text  d-flex justify-content-center"
                                                                style ="color: Orange">{{ $order->transaction_amount }}
                                                            </p>

                                                        </div>
                                                    </div>
                                                </th>


                                                <th>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title"> عدد الطلبات جاري العمل علي توصيلها
                                                            </h5>
                                                            <p class="card-text d-flex justify-content-center"
                                                                style ="color: Orange">
                                                                {{ $pendingOrder->first()->id_count }}
                                                            </p>

                                                        </div>
                                                    </div>



                                                </th>


                                                <th>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title"> اجمالي الرسوم المستحقه </h5>
                                                            <p class="card-text  d-flex justify-content-center"
                                                                style ="color: Orange"> {{ $order->delivery_amount }}
                                                            </p>

                                                        </div>
                                                    </div>



                                                </th>




                                                <th>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style ="color: Orange">المبلغ الصافي
                                                            </h5>
                                                            <p class="card-text d-flex justify-content-center  "
                                                                style ="color: red">
                                                                {{ $order->transaction_amount - $order->delivery_amount }}
                                                            </p>

                                                        </div>
                                                    </div>


                                                </th>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="10">{{ __('translation.table.empty') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div> --}}

                {{-- <div class="card card-info">
        <div class="row px-3 py-2">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">بحث </label>
                    <input type="text" class="form-control" name="order_id" wire:model='order_id' id=""
                        aria-describedby="helpId" placeholder="ابحث برقم الفاتورة">
                    @error('order_date')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>




            <div class="col-md-3">
                <div class="form-group">
                    <label for="">{{ __('translation.start_date') }}</label>
                    <input type="date" class="form-control" name="order_date" wire:model='order_date' id=""
                        aria-describedby="helpId" placeholder="">
                    @error('order_date')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">{{ __('translation.end_date') }}</label>
                    <input type="date" class="form-control" name="order_date" wire:model='to_order_date'
                        id="" aria-describedby="helpId" placeholder="">
                    @error('order_date')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="">الخدمات</label>
                    <select class="form-control" name="Service" wire:model='Service' id="">
                        <option value="-1"---</option>

                        <option value="1">توصيل الطلبات للمتاجر</option>
                        <option value="2">شحن الطلبات للمتاجر</option>
                        <option value="3">الشحن الدولي</option>
                        <option value="4">استرجاع الطلبات من العميل</option>
                        <option value="5">استرجاع الطلبات بعد محاولة التسليم</option>

                    </select>
                </div>
            </div>

        </div>
    </div> --}}


                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">
                            ملخص الطلبات
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card overflow-hidden">
                                <div class="card-content">
                                    <div class="card-body cleartfix">

                                        <table class="table table-striped table-bordered">

                                            <tbody>
                                                @if (count($OrederanlyticaData) > 0)
                                                    <tr align="center">
                                                        <th>
                                                            <div class="card">
                                                                <div class="card-body " style ="">
                                                                    <h5 class="card-title" style ="color: DodgerBlue">
                                                                        توصيل الطلبات للمتاجر
                                                                    </h5>
                                                                    <p class="card-text  d-flex justify-content-center"
                                                                        style ="color: Orange">
                                                                        {{ $OrederanlyticaData->first()->{"توصيل الطلبات للمتاجر"} ?? 0 }}
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </th>


                                                        <th>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        شحن الطلبات للمتاجر </h5>
                                                                    <p class="card-text d-flex justify-content-center"
                                                                        style ="color: Orange">
                                                                        {{ $OrederanlyticaData->first()->{"شحن الطلبات للمتاجر"} ?? 0 }}
                                                                    </p>

                                                                </div>
                                                            </div>



                                                        </th>


                                                        <th>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        استرجاع الطلبات من العميل
                                                                    </h5>
                                                                    <p class="card-text  d-flex justify-content-center">
                                                                        {{ $OrederanlyticaData->first()->{"استرجاع الطلبات من العميل"} ?? 0 }}
                                                                    </p>

                                                                </div>
                                                            </div>



                                                        </th>

                                                        <th>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h6 class="card-title" style ="color: Orange">
                                                                        استرجاع الطلبات بعد محاولة التسليم
                                                                    </h6>
                                                                    <p class="card-text d-flex justify-content-center  "
                                                                        style ="color: red">
                                                                        {{ $OrederanlyticaData->first()->{"استرجاع الطلبات بعد محاولة التسليم"} ?? 0 }}
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </th>

                                                        <th>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title" style ="color: Orange">
                                                                        الشحن الدولي
                                                                    </h5>
                                                                    <p class="card-text d-flex justify-content-center  "
                                                                        style ="color: red">
                                                                        {{ $OrederanlyticaData->first()->{"الشحن الدولي"} ?? 0 }}
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="10">{{ __('translation.table.empty') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">
                            {{ __('translation.orders.list') }}
                        </div>
                    </div>


                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard table-responsive">

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 3px">{{ __('translation.No') }}</th>
                                        <th>رقم الفاتورة</th>
                                        <th>{{ __('translation.order.date') }}</th>

                                        <th>{{ __('translation.service') }}</th>
                                        <th>{{ __('translation.client') }}</th>
                                        <th>{{ __('translation.representative') }}</th>
                                        <th>{{ __('translation.status') }}</th>
                                        <th>الدفع عند الاستلام</th>
                                        <th>رسوم الخدمة</th>
                                        {{-- <th>صافي المبلغ</th> --}}
                                        {{-- <th>{{ __('translation.action') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($Orders) > 0)
                                        @foreach ($Orders as $key => $order)
                                            <tr>
                                                {{-- @dd($Orders) --}}
                                                {{-- @dd($key, $order) --}}
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->tracking_number }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>{{ $order->service->name }}</td>
                                                <td>{{ $order->client->fullname }}</td>
                                                <td>{{ $order->representative ? $order->representative->fullname : '-' }}
                                                </td>
                                                <td><span
                                                        class="badge @switch($order->status)
                                    @case('pending')
                                        badge-warning
                                        @break
                                    @case('pickup')
                                        badge-secondary
                                        @break
                                    @case('inProgress')
                                        badge-primary
                                        @break
                                    @case('delivered')
                                        badge-info
                                        @break
                                    @case('completed')
                                        badge-success
                                        @break
                                        @case('canceled')
                                        badge-danger
                                        @break
                                        @case('returned')
                                        badge-danger
                                        @break
                                    @default
                                @endswitch ">{{ __('translation.' . $order->status) }}</span>
                                                </td>
                                                @if ($order->order_value == null)
                                                    <td>0</td>
                                                @else
                                                    <td>{{ $order->order_value }}</td>
                                                @endif

                                                <td>{{ $order->delivery_fees }}</td>
                                                {{-- <td>{{ $order->order_value - $order->delivery_fees }}</td> --}}
                                                {{-- <td>
                                        <a href="{{ route('print.invoice', $order->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-warning"><i class="fa fa-print"></i>
                                        </a>

                                        <a class='btn btn-sm btn-light' target="_blank"
                                            href='{{ route('print.invoice', $order->id) }}'>
                                            <i class="fa fa-print"></i>
                                        </a>

                                        <a href='{{ route('orders.show.details', $order->id) }}'
                                            data-backdrop="static" data-keyboard="false"
                                            wire:click="edit({{ $order->id }})"
                                            class="btn btn-sm btn-outline-primary btn-icon">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if ($order->status == 'pending')
                                            <button data-toggle="tooltip" data-placement="top"
                                                data-original-title="{{ __('translation.delete') }}"
                                                wire:click="$emit('triggerOrderDelete', {{ $order->id }})"
                                                class="btn btn-icon btn-outline-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                        <button data-toggle="tooltip" data-placement="top"
                                            data-original-title="{{ __('translation.delete') }}"
                                            wire:click="$emit('triggerOrderDelete', {{ $order->id }})"
                                            class="btn btn-icon btn-outline-danger btn-sm">
                                            <i class="fa fa-trash"> استرجاع الطلب</i>
                                        </button>

                                        <a class='btn btn-sm btn-outline-danger'
                                            href='{{ route('ReturedOrder', $order->tracking_number) }}'
                                            onclick="setTrackingNumber(event)">
                                            <i class="fa fa-undo"> اصدار بوليسه استرجاع</i>
                                        </a>





                                    </td> --}}
                                            </tr>
                                            <div wire:ignore.self class="modal animated bounceInDown fade text-left"
                                                id="showModal{{ $order->id }}" role="dialog"
                                                aria-labelledby="myModalLabel35" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h3 class="modal-title white" id="myModalLabel35">
                                                                {{ __('translation.order.show') }}
                                                                ({{ $order->id }})
                                                            </h3>
                                                            <button type="button" wire:click.prevent="cancel()"
                                                                class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>

                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{ __('translation.service.info') }}
                                                                    </h4>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.service') }} : </b>

                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->service->name }}

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.client') }} : </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->client->fullname }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{ __('translation.area.info') }}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.sender.name') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->sender_name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-7 p-0">
                                                                            <b>{{ __('translation.sender.phone.no') }}
                                                                                :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-5 p-0">
                                                                            {{ $order->sender_phone }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{ __('translation.sender.area') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{ $order->senderArea->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{ __('translation.sender.sub.area') }}
                                                                                :
                                                                            </b>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{ $order->senderSubArea->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.sender.address') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->sender_address }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.receiver.name') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->receiver_name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-7 p-0">
                                                                            <b>{{ __('translation.receiver.phone.no') }}
                                                                                :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-5 p-0">
                                                                            {{ $order->receiver_phone_no }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{ __('translation.receiver.area') }} :
                                                                            </b>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{ $order->receiverArea?->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{ __('translation.receiver.sub.area') }}
                                                                                :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{ $order->receiverSubArea->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4 p-0">
                                                                            <b>{{ __('translation.receiver.address') }}
                                                                                :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->receiver_address }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h4 class="form-section"><i
                                                                            class="la la-pencil-square-o"></i>
                                                                        {{ __('translation.management.info') }}
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.representative') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->representative ? $order->representative->fullname : '-' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <b>{{ __('translation.status') }} : </b>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            {{ __('translation.' . $order->status) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{ __('translation.delivery.fees') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{ $order->delivery_fees }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <b>{{ __('translation.order.fees') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            {{ $order->order_fees }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-5">
                                                                            <b>{{ __('translation.total.fees') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-7">
                                                                            {{-- {{ $order->total_fees }} --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.order.date') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ date(
                                                                                'Y-m-d
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    h:m:s',
                                                                                strtotime($order->order_date),
                                                                            ) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <b>{{ __('translation.payment.method') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            {{ __('translation.' . $order->payment_method) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.delivery.date') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ $order->delivery_date ? $order->delivery_date : '-' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <b>{{ __('translation.police.file') }} :
                                                                            </b>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            @if ($order->police_file)
                                                                                <a
                                                                                    href="{{ asset('uploads/' . $order->police_file) }}">
                                                                                    <i
                                                                                        class="la la-link"></i>{{ __('translation.police.file') }}
                                                                                </a>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input wire:click.prevent="cancel()" type="reset"
                                                                class="btn btn-outline-secondary btn-lg"
                                                                data-dismiss="modal"
                                                                value="{{ __('translation.cancel') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="10">{{ __('translation.table.empty') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                            <div class="text-center">
                                {{-- $Orders->links() --}}
                            </div>
                            {{-- <livewire:clients.clients-add-order> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        $('#cleintfilter').select2();
        $('#cleintfilter').on('change', function(e) {

            @this.set('cleint_filter', e.target.value);
        });

        window.Livewire.on('select2', function() {
            $('.select2').select2();
        });
        Livewire.on('triggerOrderDelete', order_id => {
            console.log('tregered!');
            Swal.fire({
                title: '{{ __('translation.delete.confirmation.message') }}',
                text: '{{ __('translation.delete.confirmation.text') }}',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: '{{ __('translation.delete') }}'
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                    // calling destroy method to delete
                    Livewire.emit('orderDelete', order_id)
                    // success response
                    // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                    Swal.fire({
                        title: '{{ __('translation.item.deleted.successfully') }}',
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        title: '{{ __('translation.operation.canceled') }}',
                        icon: 'success'
                    });
                }
            });
        });

    });

    function setTrackingNumber(event) {
        // Prevent the default link behavior
        event.preventDefault();

        // Find the nearest parent 'a' tag that has an 'href' attribute
        var linkElement = event.target.closest('a');

        // If a valid 'a' tag is found
        if (linkElement && linkElement.getAttribute('href')) {
            // Extract the tracking number from the link's href attribute
            var trackingNumber = linkElement.getAttribute('href').split('?').pop();

            // Set the tracking number in the session using AJAX
            fetch('/set-tracking-number', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        trackingNumber: trackingNumber
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Redirect the user to the 'returend-order' route
                        //     window.location.href = '';
                    } else {
                        console.error('Failed to set tracking number.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            console.error('No valid link found.');
        }
    }
</script>
