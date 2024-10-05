<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\SubArea;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;


class AnalyticsLivewire extends Component
{
    public $orders, $DailyOrders, $StartDate, $endDate, $areaChart, $area, $OrederanlyticaData,$selectedClientId =1;
    public $from_date, $to_date;

    public function hydrate(){
        $this->loadData();
    }

    public function mount()
    {
        $this->loadData();
    }
    public function loadData()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;

        $this->OrederanlyticaData = DB::table('orders as o')
    ->join('sub_areas as a', 'o.receiver_sub_area_id', '=', 'a.id')
    ->join('services as s', 'o.service_id', '=', 's.id')
    ->select(
        'a.name AS AreaName',
        DB::raw("SUM(CASE WHEN s.name = 'توصيل الطلبات للمتاجر' THEN 1 ELSE 0 END) AS 'توصيل الطلبات للمتاجر'"),
        DB::raw("SUM(CASE WHEN s.name = 'شحن الطلبات للمتاجر' THEN 1 ELSE 0 END) AS 'شحن الطلبات للمتاجر'"),
        DB::raw("SUM(CASE WHEN s.name = 'استرجاع الطلبات من العميل' THEN 1 ELSE 0 END) AS 'استرجاع الطلبات من العميل'"),
        DB::raw("SUM(CASE WHEN s.name = 'استرجاع الطلبات بعد محاولة التسليم' THEN 1 ELSE 0 END) AS 'استرجاع الطلبات بعد محاولة التسليم'"),
        DB::raw("SUM(CASE WHEN s.name = 'الشحن الدولي' THEN 1 ELSE 0 END) AS 'الشحن الدولي'"),
        DB::raw("SUM(CASE WHEN s.name IN ('توصيل الطلبات للمتاجر', 'شحن الطلبات للمتاجر', 'استرجاع الطلبات من العميل', 'استرجاع الطلبات بعد محاولة التسليم', 'الشحن الدولي') THEN 1 ELSE 0 END) AS TotalOrders")
    )
    ->when($from_date, function ($query) use ($from_date) {
        return $query->where('o.created_at', '>=', $from_date);
    })
    ->when($to_date, function ($query) use ($to_date) {
        return $query->where('o.created_at', '<=', $to_date);
    })
    ->groupBy('a.name')
    ->havingRaw('TotalOrders > 0')
    ->orderBy(DB::raw('TotalOrders'), 'DESC')
    ->get();
    }

    public function render()
    {

        return view(
            'livewire.analytics-livewire',
            [
                'OrederanlyticaData' => $this->OrederanlyticaData,
            ]
            )->layout('layouts.master');;
    }
}
