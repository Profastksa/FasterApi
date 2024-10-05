  <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/vendors.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/daterange/daterangepicker.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/app.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/custom-rtl.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/plugins/forms/wizard.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/plugins/pickers/daterange/daterange.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="../../../assets/css/style-rtl.css">
  <!-- END Custom CSS-->
</head>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.orders.management')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('add_order') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
                <div class="btn-group">
                    <a href='{{ route('orders') }}'  class="btn btn-round btn-info" type="button"><i
                            class="la la-undo la-sm"></i>
                        {{__('translation.back')}}</a>
                </div>
            </div>
        </div>
      <div class="content-body">
        <section id="icon-tabs">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">{{ __('translation.enter_the_order_info') }}</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                    <form action="{{ route('SaveOrder') }}" id='add_order' method='post' class="icons-tab-steps wizard-circle">
                      <!-- Step 1 -->
                      @csrf
                      <h6><i class="step-icon la la-home"></i> {{ __('translation.service.info') }}</h6>
                      <fieldset wire:ignore.self>
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{__('translation.service')}}</label>
                                    <select wire:model.defer="service_id" name="service_id" id='service_id' onchange="validateInput('#service_id')" class="select2 servicesSelect form-control "
                                    style="width:100%">
                                        <option value="">----</option>

                                        <option value="1">توصيل الطلبات للمتاجر</option>
                                        <option value="2">شحن الطلبات للمتاجر</option>
                                        <option value="3">الشحن الدولي</option>

                                    </select>
                                    @error('service_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{__('translation.representative')}}</label>
                                    <select wire:model.defer="representative_id" name="representative_id"
                                    id="representative_id"
                                    onchange="validateInput('#representative_id')"
                                    class="select2 representative_id representativeSelect2 Select2 form-control "
                                        style="width:100%">
                                        <option value="">----</option>
                                    </select>
                                    @error('representative_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>



                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{__('translation.client')}}</label>
                                    <select wire:model.defer="client_id" name="client_id"
                                    id="client_id"
                                    onchange="validateInput('#client_id')"
                                    class="select2 clientSelect2 form-control "
                                        style="width:100%">
                                        <option value="">----</option>
                                    </select>
                                    @error('client_id') <span class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">{{__('translation.status')}}</label>
                                    <select wire:model.defer="status"
                                        class="  form-control " style="width:100%">
                                        <option value="">----</option>
                                        <option value="pending">{{__('translation.pending')}} </option>
                                        <option value="pickup">{{__('translation.pickup')}} - استلام</option>
                                        <option value="inProgress">{{__('translation.inProgress')}}  - تسليم</option>


                                    </select>
                                    @error('status') <span class="text-danger error">{{ $message
                                        }}</span>@enderror
                                </div>
                            </div>

{{--
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label for="title">{{__('translation.police.file')}}</label>
                                    <input
                                    name="police_file"
                                    id="police_file" type="file" wire:model.defer="police_file"
                                        class="form-control" placeholder="">
                                    @error('police_file') <span class="text-danger error">{{ $message }}</span>@enderror
                                </fieldset>
                          </div> --}}
                        </div>
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><i class="step-icon la la-pencil"></i>{{ __('translation.sender_data') }}</h6>
                      <fieldset wire:ignore.self>
                      <div class="row">
                        <div class="col-md-6">
                          <fieldset class="form-group floating-label-form-group">
                              <label for="email">{{__('translation.sender.name')}}</label>
                              <input type="text" wire:model="sender_name"
                               name="sender_name"
                               id="sender_name"
                               onchange="validateInput('#sender_name')"

                               class="form-control"
                                  placeholder="">
                              @error('sender_name') <span class="text-danger error">{{ $message }}</span>@enderror
                          </fieldset>
                      </div>
                      <div class="col-md-6">
                          <fieldset class="form-group floating-label-form-group">
                              <label for="email">{{__('translation.sender.phone.no')}}</label>
                              <input type="text"  name="sender_phone"

                              id="sender_phone"
                              onchange="validateInput('#sender_phone')"
                              wire:model.defer="sender_phone" class="form-control"
                                  placeholder="">
                              @error('sender_phone') <span class="text-danger error">
                                  {{ $message }}</span>@enderror
                          </fieldset>
                      </div>
                      {{-- @dd($SenderSubArea) --}}
                      <div class="col-md-6">
                          <div class="form-group">
                              {{-- @if ($service_id)
                              @dd($areas)
                              @endif --}}
                              <label for="title">{{__('translation.sender.area')}}</label>
                              <select name="sender_area_id"
                              id="sender_area_id"
                              onchange="validateInput('#sender_area_id')"
                              wire:change='HandelCahnge()'
                              data-element='senderSubAreaSelect2'
                              class="select2 senderAreaSelect2 form-control " style="width:100%">
                                  <option value="">----</option>
                                  @foreach ($SendingArea as $area)
                                  <option {{$sender_area_id==$area->id ? 'selected' : ''}}
                                      value="{{$area->id}}">
                                      {{$area->name}} - ({{$area->sub_areas_count}})</option>
                                  @endforeach
                              </select>
                              @error('sender_area_id') <span class="text-danger error">{{ $message
                                  }}</span>@enderror
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="title">{{__('translation.sender.sub.area')}}</label>
                              <select  name="sender_sub_area_id"
                              id="sender_sub_area_id"
                              onchange="validateInput('#sender_sub_area_id')"

                                  class="select2 senderSubAreaSelect2 form-control" style="width:100%">
                                  <option value="">----</option>
                                  @foreach ($SenderSubArea as $area)
                                  <option {{$sender_sub_area_id==$area->id ? 'selected' : ''}}
                                      value="{{$area->id}}">
                                      {{$area->name}}</option>
                                  @endforeach
                              </select>
                              @error('sender_sub_area_id') <span class="text-danger error">{{ $message
                                  }}</span>@enderror
                          </div>
                      </div>
                      <div class="col-md-6">
                          <fieldset class="form-group floating-label-form-group">
                              <label for="email">{{__('translation.sender.address')}}</label>
                              <input type="text" wire:model.defer="sender_address"
                              id="sender_address"
                              onchange="validateInput('#sender_address')"
                              name="sender_address"class="form-control"
                                  placeholder="">
                              @error('sender_address') <span class="text-danger error">{{ $message
                                  }}</span>@enderror
                          </fieldset>
                      </div>
                        </div>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon la la-tv"></i>{{ __('translation.reciver_data') }}</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">{{__('translation.receiver.name')}}</label>
                                <input type="text"
                                id="receiver_name"
                                onchange="validateInput('#receiver_name')"
                                  wire:model="receiver_name"  name="receiver_name"  id='receiver_name' class="form-control"
                                    placeholder="">
                                @error('receiver_name') <span class="text-danger error">{{ $message
                                    }}</span>@enderror
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">{{__('translation.receiver.phone.no')}}</label>
                                <input type="text"
                                id="receiver_phone_no"
                                onchange="validateInput('#receiver_phone_no')"
                                name='receiver_phone_no' wire:model.defer="receiver_name" class="form-control"
                                    placeholder="">
                                @error('receiver_phone_no') <span class="text-danger error">{{ $message
                                    }}</span>@enderror
                            </fieldset>
                        </div>

                        {{-- @dd($SenderSubArea) --}}
                      <div class="col-md-6">
                          <div class="form-group">
                              {{-- @if ($service_id)
                              @dd($areas)
                              @endif --}}
                              <label for="title">{{__('translation.receiver.area')}}</label>
                              <select   wire:model.defer="receiver_area_id"
                                name="receiver_area_id"
                                id="receiver_area_id"
                              onchange="validateInput('#receiver_area_id')"
                              wire:change='HandelCahnge()'
                              data-element='senderSubAreaSelect1'
                              class="select1 senderAreaSelect1 form-control " style="width:100%">
                                  <option value="">----</option>
                                  @foreach ($ResevingArea as $area)
                                  <option {{$receiver_area_id==$area->id ? 'selected' : ''}}
                                      value="{{$area->id}}">
                                      {{$area->name}} - ({{$area->sub_areas_count}})</option>
                                  @endforeach
                              </select>
                              @error('receiver_area_id') <span class="text-danger error">{{ $message
                                  }}</span>@enderror
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="title">{{__('translation.receiver.sub.area')}}</label>
                              <select wire:model.defer="receiver_sub_area_id"
                                name="receiver_sub_area_id"
                                id="receiver_sub_area_id"
                              onchange="validateInput('#receiver_sub_area_id')"

                                  class="select1 senderSubAreaSelect1 form-control" style="width:100%">
                                  <option value="">----</option>
                                  @foreach ($ResevierSubArea as $area)
                                  <option {{$receiver_sub_area_id==$area->id ? 'selected' : ''}}
                                      value="{{$area->id}}">
                                      {{$area->name}}</option>
                                  @endforeach
                              </select>
                              @error('receiver_sub_area_id') <span class="text-danger error">{{ $message
                                  }}</span>@enderror
                          </div>
                      </div>

                        <div class="col-md-6">
                            <fieldset class="form-group floating-label-form-group">
                                <label for="email">{{__('translation.receiver.address')}}</label>
                                <input type="text"
                                id="receiver_address"
                                onchange="validateInput('#receiver_address')"
                                name="receiver_address" wire:model.defer="receiver_address" class="form-control"
                                    placeholder="">
                                @error('receiver_address') <span class="text-danger error">{{ $message
                                    }}</span>@enderror
                            </fieldset>
                        </div>
                        </div>
                      </fieldset>
                      <!-- Step 4 -->
                      <h6><i class="step-icon la la-image"></i>{{ __('translation.order_details') }}</h6>
                       <fieldset class="form-group floating-label-form-group">
                        <div class="row">



                              <div class="col-md-6" id="order_fees_Div">
                                  <fieldset class="form-group floating-label-form-group" >
                                      <label for="email">{{__('translation.order.fees')}}</label>
                                      <input  type="text"

                                                name="order_value"
                                          id="order_value" value="0"
                                          onkeyup="validateInput('#order_value')"
                                                wire:model.defer="order_value" class="form-control" placeholder="">
                                            @error('order_value') <span class="text-danger error">{{ $message }}</span>@enderror

                                  </fieldset>
                              </div>

                              <div class='col-md-6'>
                                      <fieldset class="form-group floating-label-form-group">
                                          <label for="email">{{__('translation.number_of_paces')}}</label>
                                          <input
                                          id="number_of_pieces"
                                          onkeyup="validateInput('#number_of_pieces')"

                                          type="text" wire:model.defer="number_of_pieces"
                                              class="form-control"
                                              name='number_of_pieces' value="1"
                                              placeholder="">
                                          @error('number_of_pieces') <span class="text-danger error">{{
                                              $message }}</span>@enderror
                                      </fieldset>
                                  </div>
                                  <div class='col-md-6'>
                                      <fieldset class="form-group floating-label-form-group">
                                          <label for="email">{{__('translation.order_weight')}}</label>
                                          <input type="text"
                                          name='order_weight'
                                          id="order_weight"
                                          onkeyup="validateInput('#order_weight')"
                                          wire:model.defer="order_weight" value="5"
                                              class="form-control" placeholder="">
                                          @error('order_weight') <span class="text-danger error">{{ $message
                                              }}</span>@enderror
                                      </fieldset>
                                  </div>
                                  {{-- <div class='col-md-6'>
                                      <fieldset class="form-group floating-label-form-group">
                                          <label

                                               <label for="email">{{__('translation.order.fees')}}</label>
                                          <input type="text" value ="0"
                                          id="order_value"
                                          onkeyup="validateInput('#order_value')"
                                          wire:model.defer="order_value"
                                          name="order_value"
                                              class="form-control" placeholder="">
                                          @error('order_value') <span class="text-danger error">{{ $message
                                              }}</span>@enderror
                                      </fieldset>
                                  </div> --}}
                                  <div class="col-md-6">
                                        <fieldset class="form-group floating-label-form-group">
                                             <for="email">{{__('translation.order_value_in_resved')}}</label>

                                      <input type="text"
                                      id="order_fees"
                                      onkeyup="validateInput('#order_fees')"
                                      name='order_fees' wire:model.defer="order_fees" value="100" class="form-control"
                                          placeholder="">
                                      @error('order_fees') <span class="text-danger error">{{ $message
                                          }}</span>@enderror
                                        </fieldset>
                                    </div>
                                   <div class='col-md-6'>
                                      <fieldset class="form-group floating-label-form-group">
                                          <label
                                              for="email">{{__('translation.note')}}</label>
                                          <input type="text"
                                           wire:model.defer="orede_Note"
                                           name='orede_Note'
                                           id="orede_Note"
                                           onkeyup="validateInput('#orede_Note')"

                                              class="form-control" placeholder="">
                                          @error('orede_Note') <span class="text-danger error">{{ $message
                                              }}</span>@enderror

                                    </fieldset>



                                  </div>
                          </div>
                          <button  class="btn btn-success" onclick="DestoryValidtor()">
                            {{ __('translation.add') }}
                        </button>
                      </fieldset>
                      <div class="btn-group px-1">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <hr>

            <div>
          </div>
        </section>
      </div>
    </div>
</div>

  <!-- ////////////////////////////////////////////////////////////////////////////-->

  <!-- BEGIN VENDOR JS-->
  <script src="../../../app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="../../../app-assets/vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>
  <script src="../../../app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"
  type="text/javascript"></script>
  <script src="../../../app-assets/vendors/js/pickers/daterange/daterangepicker.js"
  type="text/javascript"></script>
  <script src="../../../app-assets/vendors/js/forms/validation/jquery.validate.min.js"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="../../../app-assets/js/core/app-menu.js" type="text/javascript"></script>
  <script src="../../../app-assets/js/core/app.js" type="text/javascript"></script>
  <script src="../../../app-assets/js/scripts/customizer.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="../../../app-assets/js/scripts/forms/wizard-steps.js" type="text/javascript"></script>

  <!-- END PAGE LEVEL JS-->
<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>

  @push('scripts')
<script>


    const validator = new JustValidate('#add_order');
    function  DestoryValidtor() {
        validator.destroy();
        console.log('Destroy All');
    }
    function validateInput(input_id){
        validator.addField(input_id, [
        {
        rule: 'required',
        },
    ]);
    validator.revalidateField(input_id).then(isValid => {});
    }
    // .showErrors({ '#service_id': 'The email is invalid' })







    $('.senderAreaSelect2').on('change',function(){
        let select_class = '.' + $(this).data().element;
        $.get('/settings/getSubAreas/' + $(this).val(),  // url
      function (data, textStatus, jqXHR) {  // success callback
        console.log(data, textStatus);
        let  subareas = data.subareas;
            // console.log(subareas);
            let options = '';
            subareas.forEach(element => {
              options += `<option value='${element.id}'>${ element.name }</option>`;
            });
            $(select_class).html(options);
        });
    });
    $('.senderAreaSelect2').on('change',function(){
        let select_class = '.' + $(this).data().element;
        $.get('/settings/getSubAreas/' + $(this).val(),  // url
      function (data, textStatus, jqXHR) {  // success callback
        console.log(data, textStatus);
        let  subareas = data.subareas;
            // console.log(subareas);
            let options = '';
            subareas.forEach(element => {
              options += `<option value='${element.id}'>${ element.name }</option>`;
            });
            $(select_class).html(options);
        });
    });

    $('.senderAreaSelect1').on('change',function(){
        let select_class = '.' + $(this).data().element;
        $.get('/settings/getSubAreas/' + $(this).val(),  // url
      function (data, textStatus, jqXHR) {  // success callback
        console.log(data, textStatus);
        let  subareas = data.subareas;
            // console.log(subareas);
            let options = '';
            subareas.forEach(element => {
              options += `<option value='${element.id}'>${ element.name }</option>`;
            });
            $(select_class).html(options);
        });
    });
    $('.senderAreaSelect1').on('change',function(){
        let select_class = '.' + $(this).data().element;
        $.get('/settings/getSubAreas/' + $(this).val(),  // url
      function (data, textStatus, jqXHR) {  // success callback
        console.log(data, textStatus);
        let  subareas = data.subareas;
            // console.log(subareas);
            let options = '';
            subareas.forEach(element => {
              options += `<option value='${element.id}'>${ element.name }</option>`;
            });
            $(select_class).html(options);
        });
    });


    $('.servicesSelect').on('change', function (e) {

        var serviceId = e.target.value;
        @this.set('service_id', serviceId);
        console.log('serviceID: '+ serviceId)
       if(serviceId==1){

       }else{
        $('#order_fees').hide();
       }

            $.get('/settings/getAreasForServices/' + serviceId+'/1',  // url
                function (data, textStatus, jqXHR) {  // success callback
                    console.log(data, textStatus);
                    let  subareas = data.Areas;
                    console.log(data.Areas);
                    let options = '';
                    subareas.forEach(element => {
                    options += `<option value='${element.id}'>${ element.name }</option>`;
                    });

                    $('#sender_area_id').html(options);
                    if(data.Areas.length > 0 ){
                                    $.get('/settings/getSubAreas/' +data.Areas[0].id,  // url
                                    function (data, textStatus, jqXHR) {  // success callback
                                            console.log(data, textStatus);
                                            let  subareas = data.subareas;
                                                // console.log(subareas);
                                                let options = '';
                                                subareas.forEach(element => {
                                                options += `<option value='${element.id}'>${ element.name }</option>`;
                                                });
                                                $('#sender_sub_area_id').html(options);
                                    });

                }
            });

            $.get('/settings/getAreasForServices/' + serviceId+'/0',  // url
                function (data, textStatus, jqXHR) {  // success callback
                    console.log(data, textStatus);
                    let  subareas = data.Areas;
                    console.log(data.Areas);
                    let options = '';
                    subareas.forEach(element => {
                    options += `<option value='${element.id}'>${ element.name }</option>`;
                    });

                    $('#receiver_area_id').html(options);
                    if(data.Areas.length > 0 ){
                                    $.get('/settings/getSubAreas/' +data.Areas[0].id,  // url
                                    function (data, textStatus, jqXHR) {  // success callback
                                            console.log(data, textStatus);
                                            let  subareas = data.subareas;
                                                // console.log(subareas);
                                                let options = '';
                                                subareas.forEach(element => {
                                                options += `<option value='${element.id}'>${ element.name }</option>`;
                                                });
                                                $('#receiver_sub_area_id').html(options);
                                    });

                }
            });


        });




</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

Livewire.hook('message.processed', (message, component) => {
    handelLivewireSelect();
});




         handelLivewireSelect();
        function handelLivewireSelect(){
            $( ".representativeSelect2" ).select2({
  ajax: {
    url: "{{route('RepresetiveAjaxSearch')}}",
    type: "get",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        search: params.term // search term
      };
    },
    processResults: function (response) {
      return {
        results: response
      };
    },
    cache: true
  }
});


$( ".clientSelect2" ).select2({
  ajax: {
    url: "{{route('ClientAjaxSearch')}}",
    type: "get",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        search: params.term // search term
      };
    },
    processResults: function (response) {
      return {
        results: response
      };
    },
    cache: true
  }
});
        }

$( ".clientSelect2" ).on('change' , function(){
    // alert();
    @this.set('client_id' , $(this).val());
    $.get('/clients-management/getClient/' + $(this).val(),  // url
      function (data, textStatus, jqXHR) {  // success callback
       let  client = data.client;
        $("input[name='sender_name']").val(client.fullname);
        $("input[name='sender_phone']").val(client.phone);
        $("input[name='sender_address']").val(client.address);
        $("select[name='sender_sub_area_id']").val(client.sub_area_id);
        $("select[name='sender_area_id']").val(client.area_id);
        console.log(client);
    });
});

$( ".representativeSelect2" ).on('change' , function(){
    // alert();
    @this.set('representative_id' , $(this).val())
});
$('#service_id').on( 'change',function() {
//   alert('asd');
    if($(this).val() == 1){
      $('#payment_method').show();
    }else{
      $('#payment_method').hide();
    }
})

});
// alert('asd');

handelLivewireSelect();
function handelLivewireSelect()
        {




 }

    $( ".clientSelect1" ).on('change' , function(){
    // alert();
    @this.set('client_id' , $(this).val());
    $.get('/clients-management/getClient/' + $(this).val(),  // url
      function (data, textStatus, jqXHR) {  // success callback
       let  client = data.client;
        $("input[name='sender_name']").val(client.fullname);
        $("input[name='sender_phone']").val(client.phone);
        $("input[name='sender_address']").val(client.address);
        $("select[name='sender_sub_area_id']").val(client.sub_area_id);
        $("select[name='sender_area_id']").val(client.area_id);
        console.log(client);
    });
                                });

$( ".representativeSelect1" ).on('change' , function(){
    // alert();
    @this.set('representative_id' , $(this).val())
});
$('#service_id').on( 'change',function() {
//   alert('asd');
    if($(this).val() == 1){
      $('#payment_method').show();
    }else{
      $('#payment_method').hide();
    }
})





// alert('asd');
</script>

@endpush
