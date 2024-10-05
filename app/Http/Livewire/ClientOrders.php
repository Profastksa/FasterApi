<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Representative;
use App\Models\Service;
use App\Models\SubArea;

class ClientOrders extends Component
{
    public $orders, $order_date, $order_id, $order_id1, $order_status, $to_order_date, $receiver_phone_no, $Service, $OrederanlyticaData,$status_filter1, $status_filter,$cleint_filter,$paginatenum;

    public function mount()
    {
        $this->paginatenum = 100;
        $this->orders = Order::where('client_id', 0) //->whereNotIn('status' , ['completed'])
            ->IsDeleted()
            ->orderBy('id', 'desc')
            ->take(1000)
            ->get();
        // dd($jksa);
    }
    public function hydrate()
    {
        $this->emit('select2');
    }
    public function updatecleintfilter($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    public function updatedOrderDate($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    public function updatedOrderStatus($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    public function updatedToOrderDate($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    public function updatedToreceiver_phone_no($val)
    {
        $this->GetOrdersWithAllFilter();
    }

    // public function updatedOrderId($val)
    // {
    //     $this->validate(['order_id' => 'required|exists:orders,tracking_number']);
    //     $this->orders = Order::where(['tracking_number' => $val, 'client_id' => $this->cleint_filter])->orderBy('id', 'desc')->IsDeleted()->get();
    // }

    // public function updatedOrderId1($val)
    // {
    //     $this->validate(['order_id1' => 'required|exists:orders,receiver_phone_no']);
    //     $this->orders = Order::where(['receiver_phone_no' => $val, 'client_id' => $this->cleint_filter])->orderBy('id', 'desc')->IsDeleted()->get();
    // }

    // public function updatedService($val)
    // {
    //     if ($val == -1) {
    //         $this->orders = Order::where('client_id', $this->cleint_filter)->orderBy('id', 'desc')->get();
    //     } else {
    //         $this->validate(['Service' => 'required|exists:orders,service_id']);
    //         $this->orders = Order::where(['service_id' => $val, 'client_id' => $this->cleint_filter])->orderBy('id', 'desc')->IsDeleted()->get();
    //     }
    // }

    // public function orderDelete($order_id)
    // {
    //     $status = Order::find($order_id)->update(['is_deleted' => 1]);
    //     if ($status) {
    //         session()->flash('success', __('translation.item.deleted.successfully'));
    //         $this->render();
    //     } else {
    //         session()->flash('success', __('translation.delete.exception'));
    //     }
    //     $this->mount();
    // }

    public function GetOrdersWithAllFilter()
    {
        $query = Order::query();
        $query->StatusFilter1($this->status_filter1);

        $query->where('client_id', $this->cleint_filter);
        $query->where('is_deleted', 0);
        $query->when($this->order_date != null, function ($q) {
            return $q->where('order_date', '>', $this->order_date);
        });
        $query->when($this->to_order_date != null, function ($q) {
            return $q->where('order_date', '<', $this->to_order_date);
        });


        $query->when($this->status_filter != null, function ($q) {
            return $q->where('status', $this->status_filter);
        });

       // dd($query->get());
        $this->orders = $query->take($this->paginatenum)->get();
    }

    public function getOrders()
    {
        return $order = Order::where('client_id', $this->cleint_filter)
            ->select(
                DB::raw('
            SUM(order_value) as transaction_amount,
            SUM(delivery_fees) as delivery_amount,
            COUNT(id) as id_count'),
            )
            ->paginate(1000);
    }

    public function render()
    {
        //$data = $this->getOrders();
        $data = $this->getOrders();
        $this->GetOrdersWithAllFilter();
        $this->OrederanlyticaData = DB::table('orders as o')
            ->join('services as s', 'o.service_id', '=', 's.id')
            ->select(DB::raw("SUM(CASE WHEN s.name = 'توصيل الطلبات للمتاجر' THEN 1 ELSE 0 END) AS 'توصيل الطلبات للمتاجر'"), DB::raw("SUM(CASE WHEN s.name = 'شحن الطلبات للمتاجر' THEN 1 ELSE 0 END) AS 'شحن الطلبات للمتاجر'"), DB::raw("SUM(CASE WHEN s.name = 'استرجاع الطلبات من العميل' THEN 1 ELSE 0 END) AS 'استرجاع الطلبات من العميل'"), DB::raw("SUM(CASE WHEN s.name = 'استرجاع الطلبات بعد محاولة التسليم' THEN 1 ELSE 0 END) AS 'استرجاع الطلبات بعد محاولة التسليم'"), DB::raw("SUM(CASE WHEN s.name = 'الشحن الدولي' THEN 1 ELSE 0 END) AS 'الشحن الدولي'"), DB::raw("SUM(CASE WHEN s.name IN ('توصيل الطلبات للمتاجر', 'شحن الطلبات للمتاجر', 'استرجاع الطلبات من العميل', 'استرجاع الطلبات بعد محاولة التسليم', 'الشحن الدولي') THEN 1 ELSE 0 END) AS TotalOrders"))
            ->where('o.client_id', $this->cleint_filter)
            ->where('o.is_deleted', '!=', 1)
            ->when($this->order_date != null, function ($q) {
                return $q->where('order_date', '>', $this->order_date);
            })
            ->when($this->to_order_date != null, function ($q) {
                return $q->where('order_date', '<', $this->to_order_date);
            })
            ->when($this->order_status != null, function ($q) {
                return $q->where('status', $this->order_status);
            })
            ->get();

          //  dd($this->OrederanlyticaData);

        // }
        $pendingOrder = Order::where('client_id', $this->cleint_filter)
            ->where('is_collected', '0')
            ->where(function ($q) {
                $q->where('status', '!=', 'completed')->Where('status', '!=', 'delivered')->Where('status', '!=', 'pending');
            })
            ->select(DB::raw('COUNT(id) as id_count'))
            ->get();

        return view('livewire.Client-orders', [
            'data' => $data,
            'pendingOrder' => $pendingOrder,
            'Orders' => $this->orders,
            'OrederanlyticaData' => $this->OrederanlyticaData,
            'services' => Service::orderBy('id', 'desc')->get(),
            'sub_areas' => SubArea::orderBy('id', 'desc')->get(),
            'clients' => Client::orderBy('id', 'desc')->get(),
            'representatives' => Representative::orderBy('id', 'desc')->get(),
        ])->layout('layouts.master');
    }
}
