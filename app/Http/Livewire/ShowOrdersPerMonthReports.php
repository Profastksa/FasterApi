<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowOrdersPerMonthReports extends Component
{
    public $year = "2021";
    public $year_total_fees = 0;

    public function updatedYear()
    {
        $this->year_total_fees = 0;
    }

    public function hydrate()
    {
    }

    public function render()
    {
        $data = DB::select("SELECT DATE_FORMAT(`order_date`, '%M') as month, SUM(order_fees) as order_fees, SUM(total_fees) AS total_fees, COUNT(id) AS total_orders_number , (SELECT COUNT(id) FROM orders WHERE status = 'completed' AND year(`order_date`) = ? AND DATE_FORMAT(`order_date`, '%M') = month) AS total_completed ,(SELECT COUNT(id) FROM orders WHERE status != 'completed' AND status != 'canceled' AND year(`order_date`) = ? AND DATE_FORMAT(`order_date`, '%M') = month) AS total_uncompleted , (SELECT COUNT(id) FROM orders WHERE status = 'canceled' AND year(`order_date`) = ? AND DATE_FORMAT(`order_date`, '%M') = month) AS total_canceled  FROM orders WHERE year(`order_date`) = ? GROUP BY DATE_FORMAT(`order_date`, '%M')", [$this->year, $this->year, $this->year, $this->year]);
        foreach ($data as $key => $value) {
            $this->year_total_fees +=  $value->total_fees;
        }
        foreach ($data as $key => $value) {
            $value->month_percentage =  ($value->total_fees / $this->year_total_fees) * 100;
        }
        if ($data) {
            $this->emit('init');
        }
        // dd($data);
        return view('livewire.show-orders-per-month-reports', [
            "data" => $data,
        ]);
    }
}
