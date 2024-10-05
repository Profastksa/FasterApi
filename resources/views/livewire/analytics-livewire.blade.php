@push('styles')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 660px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endpush

<div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">تحليل طلبات المنطقة                </h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('orders') }}
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
            </div>
        </div>
<div>
    {{-- <div class='mx-1'>
        <div class="card col-xl-12 py-3">
            <div class="card-content">
                <div class="col-md-12 row p-0 m-0">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('translation.FromDate') }}</label>
                            <input type="date" class="form-control" name="start_date" wire:model='StartDate'
                                id="" aria-describedby="helpId" placeholder="">
                            @error('start_date')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('translation.end_date') }}</label>
                            <input type="date" class="form-control" name="end_date" wire:model='endDate'
                                id="" aria-describedby="helpId" placeholder="">
                            @error('end_date')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card overflow-hidden mx-1">
        <div class="card-content">
            <div class="card-body cleartfix">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group posision-relative">
                            <label>{{ __('translation.from_date') }} </label>
                            <input placeholder="{{__('translation.search')}}" wire:model="from_date"
                                type="date" class="form-control"  id="from_date">
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group posision-relative">
                            <label>{{ __('translation.to_date') }} </label>
                            <input placeholder="{{__('translation.search')}}" wire:model="to_date"
                                 type="date" class="form-control" id="search">
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-info mx-1">
        <div class="card-header">
            <div class="card-title">
                تحليل طلبات المنطقة
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body card-dashboard table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>اسم المنطقة</th>
                            <th>توصيل الطلبات للمتاجر</th>
                            <th>شحن الطلبات للمتاجر</th>
                            <th>الشحن الدولي</th>
                            <th>استرجاع الطلبات من العميل</th>
                            <th>استرجاع الطلبات بعد محاولة التسليم</th>
                            <th>إجمالي الطلبات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($OrederanlyticaData) > 0)
                            @foreach ($OrederanlyticaData as $data)
                                <tr>
                                    <td>{{ $data->AreaName }}</td>
                                    <td>{{ $data->{"توصيل الطلبات للمتاجر"} }}</td>
                                    <td>{{ $data->{"شحن الطلبات للمتاجر"} }}</td>
                                    <td>{{ $data->{"الشحن الدولي"} }}</td>
                                    <td>{{ $data->{"استرجاع الطلبات من العميل"} }}</td>
                                    <td>{{ $data->{"استرجاع الطلبات بعد محاولة التسليم"} }}</td>
                                    <td>{{ $data->TotalOrders }}</td>
                                </tr>
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

                </div>

            </div>
        </div>
    </div>




    <div class="col-xl-12">
        <figure class="highcharts-figure-lines">
            <div id="container-lines"></div>
            <p class="highcharts-description">
            </p>
        </figure>
    </div>
</div>



</div>
</div>
</div>
</div>



@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const data1 = @json($DailyOrders);
        LineOrder(data1);

        function LineOrder(data1) {
            try {
                console.log(data1);
                const labels = data1.map(item => item.label);
                const CartData = {
                    labels: labels,
                    datasets: [{
                        label: '{{ __('translation.order_weekly_chart_for_last_tow_month') }}',
                        backgroundColor: 'rgb(20, 59, 100)',
                        borderColor: 'rgb(20, 59, 100)',
                        data: data1.map(item => item.Data),
                    }]
                };

                const config = {
                    type: 'line',
                    data: CartData,
                    options: {
                        lineTension: .5,
                    }
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
                window.myChart = myChart;
            } catch (e) {

            }
        }
    </script>
    <script>
        var data = @json($orders);

        // Define translations for order statuses
        var statusTranslations = {
            'pending': {
                'ar': 'جديد',
                'en': 'Pending'
            },
            'pickup': {
                'ar': 'في انتظار الاستلام',
                'en': 'Pickup'
            },
            'inProgress': {
                'ar': 'قيد التنفيذ',
                'en': 'In Progress'
            },
            'delivered': {
                'ar': 'تم التسليم',
                'en': 'Delivered'
            },
            'completed': {
                'ar': 'مكتمل',
                'en': 'Completed'
            },
            'returned': {
                'ar': 'تم الاسترجاع',
                'en': 'Returned'
            },
            'canceled': {
                'ar': 'ملغى',
                'en': 'Canceled'
            }
        };

        // Modify data to include status names in Arabic and English
        var modifiedData = data.map(function(item) {
            return {
                name: statusTranslations[item.status]['ar'], // Arabic translation of status
                y: item.y // Order count
            };
        });

        PieChart(modifiedData);

        function PieChart(data) {
            console.log(data);
            try {
                Highcharts.chart('container', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: "{{ __('translation.order_status_pie_chart') }}"
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Order Status', // Static name for the series
                        colorByPoint: true,
                        data: data
                    }]
                });
            } catch (e) {
                console.log(e);
            }
        }
    </script>






    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('updatedCharts', function(val, val2) {
                console.log(val, val2);
                window.myChart?.destroy();
                PieChart(val2);
                LineOrder(val);
                LinesCharts(areaJson);
            });
        });
    </script>



    <script class="last-script">
        areaJson = {!! json_encode($areaChart) !!};
        area = {!! json_encode($area) !!};
        console.log(areaJson);
        console.log(area);
        getCountFromData();

        function getCountFromData() {
            let months = [];
            // Extract unique months from the data
            for (let month in areaJson) {
                if (areaJson.hasOwnProperty(month)) {
                    months.push(month);
                }
            }

            // Call LinesCharts with the extracted months
            LinesCharts(months);
        }

        function LinesCharts(months) {
            let OuterMapResult = area.map(function(el) {
                let initDataArray = months.map(function(monthname) {
                    let data = getCountFromData(monthname, el.id);
                    return (typeof data === 'undefined') ? 0 : data;
                });
                const sericeChild = {
                    "name": el.name,
                    'data': initDataArray,
                };
                return sericeChild;
            });

            Highcharts.chart('container-lines', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'إحصائيات الطلبات في المناطق',
                },
                subtitle: {
                    text: ' '
                },
                xAxis: {
                    categories: months, // Use extracted months as categories
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'عدد الطلبات'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: OuterMapResult,
            });

            function getCountFromData(month, id) {
                let data = areaJson[month].find(el => el.sendid == id);
                return data ? data.c : 0;
            }
        }
    </script>
@endpush
