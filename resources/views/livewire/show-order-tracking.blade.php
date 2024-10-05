<div>

    <div style="padding:2.2rem !important" class="content-wrapper mt-5">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12 d-flex align-items-start justify-content-center">
                    <div class="col-lg-6 col-10">
                        <img style="width: 200px !important" class="img-fluid mx-auto d-block pb-3 pt-4 width-65-per"
                            src="{{asset('uploads/' . $OrganizationProfile->logo)}}" alt="Modern Search">
                        <p class="lead">{{__('translation.order.tracking.welcome.msg')}}</p>
                        <fieldset class="form-group position-relative">
                            <input wire:model.defer="searchText" type="text"
                                class="form-control form-control-xl input-xl" id="iconLeft1"
                                placeholder="{{__('translation.order.track.placeholder')}}">
                            <div class="form-control-position">
                                <i class="ft-search font-medium-4"></i>
                            </div>
                        </fieldset>
                        <div class="row py-2">
                            <div class="col-12 text-center">
                                <button wire:click="search" class="btn btn-primary btn-md"><i class="ft-search"></i>
                                    {{__('translation.search')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            @include('includes.dashboard.notifications')
            @if (count($data) > 0)
            <section id="timeline" class="timeline-left timeline-wrapper w-50 m-auto">
                <h3 class="page-title text-center text-lg-left">{{__('translation.orders.details')}}</h3>
                <ul class="timeline">
                    <li class="timeline-line"></li>
                    {{-- <li class="timeline-group">
                        <a href="#" class="btn btn-primary"><i class="ft-calendar"></i> Today</a>
                    </li> --}}
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
                                {{-- <p class="card-subtitle text-muted pt-1">
                                    <span class="font-small-3">{{$timeline->date}}</span>
                                </p> --}}
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
            </section>
            @endif
        </div>
    </div>

</div>
