<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class ShowOrdersReports extends Component
{
    public $from_date, $to_date;
    public $representative_total = 0;
    public $company_total = 0;
    public $order_fees_total = 0;
    public $total_fees_total = 0;

    public function hydrate()
    {
        $this->emit("init");
        $this->representative_total = 0;
        $this->company_total = 0;
        $this->order_fees_total = 0;
        $this->total_fees_total = 0;
    }

    private function getFilteredOrders()
    {
        if ($this->from_date && $this->to_date) {
            $data = Order::whereBetween('order_date', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])->get();
            foreach ($data as $key => $value) {
                $this->representative_total += (int) $value->representative_deserves;
                $this->company_total += (int) $value->company_deserves;
                $this->order_fees_total += (int) $value->order_fees;
                $this->total_fees_total += (int) $value->total_fees;
            }
            return $data;
        } else if ($this->from_date && $this->to_date == null) {
            $data = Order::where('order_date', ">=", $this->from_date . " 00:00:00")->get();
            foreach ($data as $key => $value) {
                $this->representative_total += (int) $value->representative_deserves;
                $this->company_total += (int) $value->company_deserves;
                $this->order_fees_total += (int) $value->order_fees;
                $this->total_fees_total += (int) $value->total_fees;
            }
            return $data;
        } else if ($this->from_date == null && $this->to_date) {
            $data = Order::where('order_date', "<=", $this->to_date . " 23:59:59")->get();
            foreach ($data as $key => $value) {
                $this->representative_total += (int) $value->representative_deserves;
                $this->company_total += (int) $value->company_deserves;
                $this->order_fees_total += (int) $value->order_fees;
                $this->total_fees_total += (int) $value->total_fees;
            }
            return $data;
        } else if ($this->from_date == null && $this->to_date == null) {
            return [];
        }
        return [];
    }


    public function render()
    {

        return view('livewire.show-orders-reports', [
            "data" => $this->getFilteredOrders(),
        ]);
    }
}
