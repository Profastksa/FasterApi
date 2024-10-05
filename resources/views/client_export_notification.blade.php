@extends('layouts.master')

@section('links')
<style>
    h4{
        font-weight: bold;
    }
    h2{
        margin-top:50px;
    }
        .content-wrapper {
            position: absolute;
            top:0;
            left:0;
        }
</style>
@endsection
@section('content')
<div>
    <div class="content-wrapper">

        <div class="card overflow-hidden">

        </div>
        @if (count($clients) > 0)
            <div class="content-body ">
                <section id="configuration">
                    <div class="row">
                        {{-- @dd($Services); --}}
                        @foreach ($clients as $item)
                        {{-- @dd($item->Orders) --}}
                            <div class="col-12">
                                <div class="card overflow-hidden">
                                    <div class="card-content">
                                        <div class="card-body cleartfix">
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
                                            <table class="table datatable table-striped table-bordered">
                                                <thead style="background:#d7e3bd">
                                                    <tr>
                                                        <th class="text-center">
                                                        <div><h4  class="">Total</h4></div>
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
                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="10">{{ __('translation.table.empty') }}</td>
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
                                                                TAX
                                                            </h4>
                                                        </td>
                                                        <td><h4 >
                                                            {{ __('translation.tax')}}</h4></td>
                                                        <td style="background:#d7e3bd"><h4>
                                                            {{-- @dd($Cod); --}}
                                                            @php
                                                            $client_tax_value = 0;
                                                                if(isset($ServiceOne)){
                                                                $client_tax_value = $ServiceOne->sum('order_value') * ($tax_value / 100);
                                                                }
                                                                echo $client_tax_value;
                                                            @endphp
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
                                                           {{ $item->orders->whereIn('status' , ['pending' , 'pickup' , 'inProgress'])->where('is_collected', '0')->count() }}
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
                                                            {{ $total_of_fees - (( isset($ServiceOne) ? $ServiceOne->sum('order_value'): 0)  + $client_tax_value)}}
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
            <button class="btn btn-primary d-none" wire:click='ExportIssueToClientWithCheckBoxs()'>
                {{ __('translation.issue') }}
            </button>
        @else
            <div class="card p-5">
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
@endsection
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

            });
        })
    </script>
@endpush
