@extends('layouts.master')

@section('content')
<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.order.show_details')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-6">

            </div>
        </div>
        <div class="content-body">
            <!-- Zero configuration table -->
            <section id="configuration">
                <div class="row">
                    <div class="col-8">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card overflow-hidden">
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4 class="form-section"><i
                                                                    class="la la-pencil-square-o"></i>
                                                                {{__('translation.service.info')}}
                                                            </h4>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.service')}} : </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->service->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.client')}} : </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->client->fullname?? '--'}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4 class="form-section"><i
                                                                    class="la la-pencil-square-o"></i>
                                                                {{__('translation.area.info')}}
                                                            </h4>
                                                        </div>
                                                   <div class="row col-12 m-1">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <b>{{__('translation.sender.name')}} : </b>
                                                            </div>
                                                            <div class="col-8">
                                                            @if($order->service_id == "5")
                                                              فاستر

                                                            @else
                                                                {{$order->sender_name}}

                                                           @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-7 p-0">
                                                                <b>{{__('translation.sender.phone.no')}} :
                                                                </b>

                                                            </div>
                                                            <div class="col-5 p-0">


                                                            @if($order->service_id == "5")
                                                              0559744223
                                                            @else
                                                            {{$order->sender_phone}}
                                                           @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                   </div>
                                                    <div class="row col-12 m-1">
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.sender.area')}} : </b>

                                                                </div>
                                                                <div class="col-4">



                                                            @if($order->service_id == "5")
                                                             جازان
                                                            @else
                                                            {{$order->senderArea->name}}
                                                           @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <b>{{__('translation.sender.sub.area')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                @if($order->service_id == "5")
                                                            صبيا
                                                            @else
                                                            {{$order->senderSubArea->name}}
                                                           @endif


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <b>{{__('translation.sender.address')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-6">

                                                                @if($order->service_id == "5")
                                                            ابوعريش
                                                            @else
                                                            {{$order->sender_address}}
                                                           @endif


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    @if($order->service_id == "5")
                                                        <div class="col-md-12">
                                                            <h4 class="form-section"><i
                                                                    class="la la-pencil-square-o"></i>
                                                             تفاصيل المستقبل
                                                            </h4>
                                                        </div>
                                                        <div class="row col-12 m-1">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                    <b>{{__('translation.receiver.name')}} :

                                                                   </b>

                                                                    </div>
                                                                    <div class="col-8">
                                                                    {{$order->sender_name}}

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-7 p-0">
                                                                    <b>{{__('translation.receiver.phone.no')}} :
                                                                        </b>
                                                                    </div>
                                                                    <div class="col-5 p-0">
                                                                    {{$order->sender_phone}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-1">

                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                <b>{{__('translation.receiver.area')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-4">
                                                                {{$order->senderArea->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                <b>{{__('translation.receiver.sub.area')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                {{$order->senderSubArea->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-4 p-0">
                                                                <b>{{__('translation.receiver.address')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-8">
                                                                {{$order->sender_address}}

                                                                </div>
                                                            </div>
                                                        </div>

                                                        </div>

                                                        <div class="col-md-12">
                                                            <h4 class="form-section"><i
                                                                    class="la la-pencil-square-o"></i>
                                                             تفاصيل العميل
                                                            </h4>
                                                        </div>


                                                       @endif






                                                    <div class="col-12">

                                                      </div>
                                                        <div class="row col-12 m-1">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <b>
                                                                        @if($order->service_id == "5")
                                                            اسم العميل
                                                            @else
                                                            {{__('translation.receiver.name')}} :
                                                           @endif
                                                                        </b>

                                                                    </div>
                                                                    <div class="col-8">
                                                                        {{$order->receiver_name}}

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-7 p-0">
                                                                        <b>


                                                                        @if($order->service_id == "5")
                                                            رقم العميل
                                                            @else
                                                            {{__('translation.receiver.phone.no')}} :
                                                           @endif
                                                                        </b>
                                                                    </div>
                                                                    <div class="col-5 p-0">
                                                                        {{$order->receiver_phone_no}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row col-12 m-1">

                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>
                                                                    @if($order->service_id == "5")
                                                            مدينة العميل
                                                            @else
                                                            {{__('translation.receiver.area')}} :
                                                           @endif


                                                                    </b>
                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->receiverArea->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>

                                                                    @if($order->service_id == "5")
                                                            محافظة العميل
                                                            @else
                                                            {{__('translation.receiver.sub.area')}} :
                                                           @endif

                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->receiverSubArea->name}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-4 p-0">
                                                                    <b>

                                                                    @if($order->service_id == "5")
                                                            عنوان العميل
                                                            @else
                                                            {{__('translation.receiver.address')}} :
                                                           @endif
                                                                    </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->receiver_address}}

                                                                </div>
                                                            </div>
                                                        </div>

                                                        </div>







                                                        <div class="col-md-12">
                                                            <h4 class="form-section"><i
                                                                    class="la la-pencil-square-o"></i>
                                                                {{__('translation.management.info')}}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.representative')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-8">
                                                                    {{$order->representative ?
                                                                    $order->representative->fullname : '-'}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.status')}} : </b>

                                                                </div>
                                                                <div class="col-6">
                                                                    {{__('translation.'.$order->status)}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.delivery.fees')}} :
                                                                    </b>

                                                                </div>
                                                                <div class="col-4">
                                                                    {{$order->delivery_fees}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <b>{{__('translation.order.fees')}} : </b>

                                                                </div>
                                                                <div class="col-4">

                                                                    {{$order->order_fees}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <b>{{__('translation.total.fees')}} : </b>

                                                                </div>
                                                                <div class="col-7">
                                                                    {{$order->total_fees}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2"></div>

                                                        <div class="col-md-3 ">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <b>{{__('translation.order.date')}} : </b>
                                                                </div>
                                                                <div class="col-8">
                                                                    {{date('Y-m-d
                                                                    h:m:s',strtotime($order->order_date))}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.payment.method')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{__('translation.'.$order->payment_method)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.delivery.date')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$order->delivery_date ?
                                                                    $order->delivery_date : "-"}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <b>{{__('translation.police.file')}} :
                                                                    </b>
                                                                </div>
                                                                <div class="col-6">
                                                                    @if ($order->police_file)
                                                                    <a href="{{asset('uploads/'.$order->police_file)}}">
                                                                        <i
                                                                            class="la la-link"></i>{{__('translation.police.file')}}
                                                                    </a>
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>











                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-4">
                    @if (count($data) > 0)
                    {{-- <section id="timeline" class="timeline-left timeline-wrapper   m-0 p-0">
                         <ul class="timeline">
                            <li class="timeline-line"></li>

                        </ul>
                        <ul class="timeline">
                            <li class="timeline-line"></li>

                            @foreach ($data as $timeline)
                            <li class="timeline-item">
                                <div class="timeline-badge">
                                    <span class="bg-red bg-lighten-1" data-toggle="tooltip" data-placement="right"
                                        title="{{$timeline["date"]}}"><i class="la la-check"></i></span>
                                </div>
                                <div class="timeline-card card border-grey border-lighten-2">
                                    <div class="card-header">
                                        <h4 class="card-title"><a href="#">{{$timeline["date"]}}</a></h4>

                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline pt-1">
                                                <li><a data-action="reload"><i class="ft-repeat"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            {{$timeline["note"]}}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach


                        </ul>
                    </section> --}}

                    <section id="timeline" class="timeline-left timeline-wrapper m-0 p-0">
                        <div class="timeline-container">
                            <div class="timeline-item">
                                <div class="timeline-card card border-grey border-lighten-2">
                                    <div class="card-header">
                                        <h4 class="card-title">مسار الطلب</h4>
                                        <div class="heading-elements">
                                            <ul class="list-inline pt-1">
                                                <li><a data-action="reload"><i class="ft-repeat"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>التاريخ</th>
                                                        <th>الحدث</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $timeline)
                                                    <tr>
                                                        <td>{{$timeline["date"]}}</td>
                                                        <td>{{$timeline["note"]}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>





                    @endif
                </div>
                </div>
        </div>
    </div>
</div>


@endsection
