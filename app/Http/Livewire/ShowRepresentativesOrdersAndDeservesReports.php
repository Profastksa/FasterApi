<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Representative;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class ShowRepresentativesOrdersAndDeservesReports extends Component
{

    public $from_date, $to_date, $representative_id;
    public $overall_total = 0;


    private function getFilteredOrders()
    {

        $isFirst = true;
        $SubQC = "";
        $MQC = "";
        // $M

        //representative_id =  1
        if ($this->representative_id) {

            if ($isFirst) {
                $MQC .= " where ";
                $isFirst = FALSE;
            } else {
                $MQC .= " and ";
            }
            $MQC .= " representative_id = " . $this->representative_id;
        }

        if ($this->from_date) {
            $SubQC =  "AND order_date >= '" . $this->from_date . " 00:00:00'";
            if ($isFirst) {
                $MQC .= " where ";
                $isFirst = FALSE;
            } else {
                $MQC .= " and ";
            }

            $MQC .=  " order_date >= '" . $this->from_date . " 00:00:00'";
        }

        if ($this->to_date) {
            $SubQC .= "AND order_date <= '" . $this->to_date . " 23:59:59'";
            if ($isFirst) {
                $MQC .= " where ";
                $isFirst = FALSE;
            } else {
                $MQC .= " and ";
            }
            $MQC .= " order_date <= '" . $this->to_date . " 23:59:59'";
        }

        $query = "SELECT representatives.fullname, COUNT(o.id) AS total_orders_number,
(SELECT COUNT(id) FROM orders WHERE status = 'completed' AND representative_id =  o.representative_id $SubQC) AS total_completed,
(SELECT COUNT(id) FROM orders WHERE status != 'completed' AND status != 'canceled' AND representative_id =   o.representative_id $SubQC ) AS total_uncompleted,
(SELECT COUNT(id) FROM orders WHERE status = 'canceled' AND representative_id =   o.representative_id $SubQC  ) AS total_canceled,
(SELECT SUM(representative_deserves) FROM orders WHERE  status != 'canceled'  AND representative_id =   o.representative_id  $SubQC ) AS total_deserves

FROM orders o INNER JOIN representatives ON o.representative_id = representatives.id $MQC GROUP BY representative_id";

        $data = DB::select($query);

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->overall_total += $value->total_deserves;
            }
        }
        return $data;
    }


    public function render()
    {
        $this->emit('init');
        return view('livewire.show-representatives-orders-and-deserves-reports', [
            "data" => $this->getFilteredOrders(),
            'representatives' => Representative::all()
        ]);
    }
}
