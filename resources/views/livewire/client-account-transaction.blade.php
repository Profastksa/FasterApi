@section('links')
<style>
    h4{
        font-weight: bold;
    }
    h2{
        margin-top:50px;
    }
</style>
@endsection
<div>
    <div class="content-wrapper">
        <div class="content-header row HiddenInPrint">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{ __('translation.clients') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('client.transaction') }}
                    </div>
                </div>
            </div>

        </div>
        <div class="card overflow-hidden">
            <div class="card-content">
                <div class="card-body cleartfix HiddenInPrint">
                    <div class="row ">
                        <div class="col-sm-4">
                            <fieldset class="form-group posision-relative">
                                <label for="">{{ __('translation.client') }}</label>
                                <select wire:model="client_id" class="select2 form-control">
                                    <option value=""> -- {{ __('translation.clients') }} --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->fullname ?? '' }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-sm-4">
                            <fieldset class="form-group">
                                <label for="">{{ __('translation.from') }}</label>
                                <input wire:model="from_date" placeholder="{{ __('translation.from') }}" type="date"
                                    class="form-control" id="date">
                            </fieldset>
                        </div>
                        <div class="col-sm-4">
                            <fieldset class="form-group">
                                <label for="">{{ __('translation.to') }}</label>
                                <input wire:model="to_date" placeholder="{{ __('translation.to') }}" type="date"
                                    class="form-control" id="date">
                            </fieldset>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if (count($clients) > 0)
            <div class="content-body ">
                @include('includes.dashboard.notifications')

                <section id="configuration">
                    <div class="row">
                        {{-- @dd($Services); --}}
                        @foreach ($clients as $item)
                            <div class="col-12">
                                <div class="card overflow-hidden">
                                    <div class="card-content">
                                        <div class="card-body cleartfix HiddenInPrint">
                                            <div class="row  align-center ">
                                                <div class="col-md-6 inprintOnly p-2">
                                                    <div class="imgContinaer">
                                                        <h1> <b>{{ __('translation.name.of.company') }}</b> :
                                                            {{ $OrganizationProfile->name }} </h1>
                                                    </div>
                                                </div>
                                                <div class="col-md-6  p-2 text-right inprintOnly">
                                                    <div class="imgContinaer text-right inprintOnly">
                                                        <img src="{{ asset('uploads/' . $OrganizationProfile->logo) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-1">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="d-flex align-itmes-center">
                                                        <input type="checkbox" class="switch"
                                                            wire:model="checked_orders.{{ $item->id }}"
                                                            class="form-control" id="check_box_sercvies" placeholder=""
                                                            value="{{ $item->id }}">
                                                        <span>
                                                            {{ $item->fullname .' GIZ-'. $item->id }}
                                                        </span>
                                                    </h3>
                                                    <div>
                                                        <a href="#"
                                                            wire:click.prevent="ExportIssueToClient({{ $item->id }})"
                                                            class="btn btn-sm btn-primary">
                                                            {{ __('translation.issue') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table datatable table-striped table-bordered">
                                                <thead style="background:#d7e3bd">
                                                    <tr>
                                                        <th class="text-center">
                                                        <div><h4  class="">service</h4></div>
                                                        <div><h4  class="">{{ __('translation.service') }}</h4></div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div><h4  class="">Qunitity</h4></div>
                                                            <div><h4  class="">{{ __('translation.qunitity') }}</h4></div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div><h4  class="">Service Charges</h4></div>
                                                            <div><h4  class="">{{ __('translation.service_fees') }}</h4></div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div><h4  class="">total</h4></div>
                                                            <div><h4  class="">{{ __('translation.total') }}</h4></div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalBlade = 0;
                                                        $DeliveryFess = [];
                                                        $totalOfService = 0;
                                                       $newOrder = $item->Orders->groupBy('service_id');
                                                    // $newOrder = $Orders->groupBy('service_id');
                                                        $total_quntity = 0;
                                                        $total_of_fees = 0;
                                                    @endphp
                                                    @if (count($newOrder) > 0)
                                                        @foreach ($newOrder as $key => $newOrderCollection)
                                                            {{-- @if( $newOrderCo) --}}
                                                            @if ($key == 1)
                                                          @php
                                                                $ServiceOne  = $newOrderCollection->filter(fn($item) => $item->order_value !=0);
                                                                $Cod  = $newOrderCollection->filter(fn($item) => $item->order_value ==0);
                                                            @endphp
                                                            @if (count($ServiceOne) > 0)
                                                            <tr>
                                                                <td>{!! $ServiceHeading[$Services->find($key)->id][0] !!}</td>
                                                                <td>
                                                                    @php
                                                                        $total_quntity += count($ServiceOne);
                                                                        echo count($ServiceOne);
                                                                    @endphp
                                                                </td>
                                                                <td>
                                                                    @if ($item->is_has_custom_price)
                                                                        @php
                                                                            $price = $item->ServicePrice->where('service_id', $key)->first()->price;
                                                                            echo $price;
                                                                        @endphp
                                                                    @endif
                                                                    @if (!$item->is_has_custom_price)
                                                                        @php
                                                                            $price = $Services->where('id', $key)->first()->price;
                                                                            echo $price;
                                                                        @endphp
                                                                    @endif
                                                                </td>
                                                                <td> @php
                                                                    $total_of_fees += count($ServiceOne) * $price;
                                                                    echo count($ServiceOne) * $price ;
                                                                    @endphp</td>
                                                            </tr>
                                                            @endif
                                                            @if (count($Cod) > 0)
                                                            <tr>
                                                                <td>{!!  $ServiceHeading[$Services->find($key)->id][1] !!}</td>
                                                                <td>
                                                                    @php
                                                                        $total_quntity += count($Cod);
                                                                        echo count($Cod);
                                                                    @endphp
                                                                </td>
                                                                <td>
                                                                    @if ($item->is_has_custom_price)
                                                                        @php
                                                                            $price = $item->ServicePrice->where('service_id',$key) -> where('type','pickup')->first()->price;
                                                                            echo $price;
                                                                        @endphp
                                                                    @endif
                                                                    @if (!$item->is_has_custom_price)
                                                                        @php
                                                                            $price = $Services->where('id', $key)->first()->cod;
                                                                            echo $price;
                                                                        @endphp
                                                                    @endif
                                                                </td>
                                                                <td> @php
                                                                    $total_of_fees += count($Cod) * $price;
                                                                    echo count($Cod) * $price ;
                                                                    @endphp</td>
                                                            </tr>
                                                            @endif
                                                            @continue
                                                            @endif





                                                            <tr>
                                                                <td>{!! $ServiceHeading[$Services->find($key)->id] !!}</td>
                                                                <td>
                                                                    @php
                                                                        $total_quntity += count($newOrderCollection);
                                                                        echo count($newOrderCollection);
                                                                    @endphp
                                                                </td>
                                                                <td>
                                                                    @if ($item->is_has_custom_price)
                                                                        @php
                                                                            $price = $item->ServicePrice->where('service_id', $key)->first()->price;
                                                                            echo $price;
                                                                        @endphp
                                                                    @endif
                                                                    @if (!$item->is_has_custom_price)
                                                                        @php
                                                                            $price = $Services->where('id', $key)->first()->price;
                                                                            echo $price;
                                                                        @endphp
                                                                    @endif
                                                                </td>
                                                                <td> @php
                                                                    $total_of_fees += count($newOrderCollection) * $price;
                                                                    echo count($newOrderCollection) * $price ;
                                                                    @endphp</td>
                                                            </tr>





                                                        @endforeach
                                                        <tr>
                                                            <td>
                                                                <h4>total </h4>
                                                                <h4>{{ __('translation.total')}} </h4>
                                                            </td>
                                                            <td>{{ $total_quntity }}</td>
                                                            <td> </td>
                                                            <td> {{ $total_of_fees}}</td>
                                                        </tr>


                                                        <tr>
                                                                <td>
                                                                <h4> {{ __('translation.number_order_count_out_the_clac')}}  <h4>
                                                          </td>
                                                                <td>
                                                                {{-- @dd($Cod); --}}
                                                           {{ $client->orders->whereIn('client_id' , $client->id)->whereIn('status' , ['pickup' , 'inProgress'])->where('is_collected', '0')->count() }}
                                                        </td>
                                                                <td>
                                                                   0
                                                                </td>
                                                                <td> 0</td>
                                                            </tr>
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="10">{{ __('translation.table.empty.pleaseCollect') }}</td>
                                                        </tr>
                                                    @endif
                                                    @if (count($newOrder) > 0)
                                                    <tr>
                                                        {{-- <td></td> --}}
                                                        <td colspan="2" class="text-rigth">
                                                            <h4 class="text-right">
                                                                Totol COD amount
                                                            </h4>
                                                        </td>
                                                        <td><h4 >
                                                            {{ __('translation.cod_total_sum')}}</h4></td>
                                                        <td style="background:#d7e3bd"><h4>
                                                            {{-- @dd($Cod); --}}
                                                            {{ isset($ServiceOne) ? $ServiceOne->sum('order_value') : 0}}
                                                        </h4></td>
                                                    </tr>

                                                    <tr>
                                                        {{-- <td></td> --}}
                                                        <td colspan="2" class="text-rigth">
                                                            <h4 class="text-right">
                                                                The Number Of Orders Outside The Current List
                                                            </h4>
                                                        </td>
                                                        <td><h4 >
                                                            {{ __('translation.number_order_count_out_the_clac')}}</h4></td>
                                                        <td style="background:#d7e3bd"><h4>
                                                            {{-- @dd($Cod); --}}
                                                           {{ $client->orders->whereIn('status' , ['pickup' , 'inProgress'])->where('is_collected', '0')->count() }}
                                                        </h4></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h4 class='text-right'>
                                                                Total Service Charges
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <h4>
                                                                {{ __('translation.total_fess_deserve')}}
                                                            </h4>
                                                        </td>
                                                        <td style='background:#d7e3bd'><h4>{{ $total_of_fees }}</h4></td>
                                                    </tr>

                                                    <tr class="d-none" >
                                                        {{-- <td></td> --}}
                                                        <td colspan="2" class="text-rigth">
                                                            <h4 class="text-right">
                                                                TAX
                                                            </h4>
                                                        </td>
                                                        <td><h4 >
                                                            {{ __('translation.tax')}}</h4></td>
                                                        <td style="background:#d7e3bd"><h4>
                                                            {{-- @dd($Cod); --}}
                                                            @php
                                                            $tax_value=
                                                            $client_tax_value = 0;
                                                                if(isset($ServiceOne)){
                                                                $client_tax_value =  $client_tax_value = $total_of_fees  * 0;
                                                                }
                                                                echo $client_tax_value;
                                                            @endphp
                                                        </h4></td>
                                                    </tr>


                                                    <tr>
                                                        {{-- <td colspan="2"></td> --}}
                                                        {{-- <td></td> --}}
                                                        {{-- @dd($Cod->sum('total_fees')); --}}
                                                        <td colspan="2"><h4 class='text-right'> net. Total </h4></td>
                                                        <td>
                                                            <h4>
                                                            {{ __('translation.free_total')}}
                                                            </h4>
                                                        </td>
                                                        <td style="background:#d7e3bd">
                                                        <h4>
                                                            {{  (( isset($ServiceOne) ? $ServiceOne->sum('order_value'): 0) - $client_tax_value) - $total_of_fees}}
                                                        </h4>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- {!! $data->links() !!} --}}
                </section>
            </div>
            <button class="btn btn-primary" wire:click='ExportIssueToClientWithCheckBoxs()'>
                {{ __('translation.issue') }}
            </button>
        @else
            <div class="card p-5">
                @include('includes.dashboard.notifications')
                <div class="d-flex align-items-center justify-content-center ">
                    <div>
                        <svg style="width:240px;height:240px" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M20 17H22V15H20V17M20 7V13H22V7H20M11 9H16.5L11 3.5V9M4 2H12L18 8V20C18 21.11 17.11 22 16 22H4C2.89 22 2 21.1 2 20V4C2 2.89 2.89 2 4 2M13 18V16H4V18H13M16 14V12H4V14H16Z" />
                        </svg>
                        <h3>{{ __('translation.no_order_need_issue') }} !!</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

@push('scripts')
    <script>
        //reinitiate select2 on every request
        window.livewire.on("select2", function() {
            $('.select2').select2();
            $('.datatable').DataTable({
                dom: 'B',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print',
                ]
                $('.select2').select2();
                // change select2 value
                $('.select2').on('change', function(e) {
                    @this.set('client_id', e.target.value);
                });
            });
        })
    </script>
@endpush
