<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowOrdersInOutAreaReports extends Component
{
    public $from_date;
    public $to_date;

    private function getFilteredOrders()
    {
        if ($this->from_date && $this->to_date) {
            $data = DB::select("SELECT sum(orders.order_value) as area_total_fees, orders.sender_area_id as area_id, areas.name AS area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id = sender_area_id AND sender_area_id = area_id AND order_date >= ? AND order_date <= ?) AS inside_area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id != sender_area_id AND sender_area_id = area_id AND order_date >= ? AND order_date <= ?) AS outside_area, COUNT(orders.id)  as total_orders FROM orders INNER JOIN areas on orders.sender_area_id = areas.id WHERE order_date >= ? AND order_date <= ? GROUP BY area_id ", [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59", $this->from_date . " 00:00:00", $this->to_date . " 23:59:59", $this->from_date . " 00:00:00", $this->to_date . " 23:59:59"]);

            return $data;
        } else if ($this->from_date && $this->to_date == null) {
            $data = DB::select("SELECT sum(orders.order_value) as area_total_fees, orders.sender_area_id as area_id, areas.name AS area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id = sender_area_id AND sender_area_id = area_id AND order_date >= ?  ) AS inside_area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id != sender_area_id AND sender_area_id = area_id AND order_date >= ?  ) AS outside_area, COUNT(orders.id)  as total_orders FROM orders INNER JOIN areas on orders.sender_area_id = areas.id WHERE order_date >= ?   GROUP BY area_id ", [$this->from_date . " 00:00:00", $this->from_date . " 00:00:00", $this->from_date . " 00:00:00"]);

            return $data;
        } else if ($this->from_date == null && $this->to_date) {
            $data = DB::select("SELECT sum(orders.order_value) as area_total_fees, orders.sender_area_id as area_id, areas.name AS area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id = sender_area_id AND sender_area_id = area_id AND order_date <= ?) AS inside_area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id != sender_area_id AND sender_area_id = area_id AND order_date <= ?) AS outside_area, COUNT(orders.id)  as total_orders FROM orders INNER JOIN areas on orders.sender_area_id = areas.id WHERE order_date <= ? GROUP BY area_id ", [$this->to_date . " 23:59:59", $this->to_date . " 23:59:59", $this->to_date . " 23:59:59"]);

            return $data;
        } else if ($this->from_date == null && $this->to_date == null) {
            $data = DB::select("SELECT sum(orders.order_value) as area_total_fees, orders.sender_area_id as area_id, areas.name AS area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id = sender_area_id AND sender_area_id = area_id ) AS inside_area, (SELECT COUNT(id) FROM orders WHERE receiver_area_id != sender_area_id AND sender_area_id = area_id) AS outside_area, COUNT(orders.id)  as total_orders FROM orders INNER JOIN areas on orders.sender_area_id = areas.id GROUP BY area_id ");

            return $data;
        }
        return [];
    }

    public function render()
    {
        $this->emit('init');
        return view('livewire.show-orders-in-out-area-reports', [
            "data" => $this->getFilteredOrders(),
        ]);
    }
}
