<?php

namespace App\Http\Livewire;

use App\Models\Representative;
use App\Models\Order;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShowRepresentativeAccountStatement extends Component
{
    public $representative_id;
    public $from_date;
    public $to_date;
    public $total_amount_in = 0;
    public $total_amount_out = 0;
    public $representative_current_account_balance = 0;

    public function hydrate()
    {
        $this->emit("select2");
        $this->total_amount_in = 0;
        $this->total_amount_out = 0;
    }

    public function updatedRepresentativeId()
    {
        $this->representative_current_account_balance = Representative::find($this->representative_id)->account_balance;
    }



    private function getFilteredRepresentativeAccountStatement()
    {
        // dd($this->to_date . " 00:00:00");
        // if ($this->representative_id != null) {
        //     if ($this->from_date && $this->to_date) {
        //         $data = DB::select("select * from (
        //     SELECT transactions.trans_sn, transactions.date, SUM(orders.representative_deserves) as amountin  , '-' as amountout  FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.representative_id = ? GROUP BY orders.transaction_id
        //     UNION
        //     SELECT transactions.trans_sn, transactions.date, '-' as amountin  , transactions.amount as amountout  from transactions  where transactions.representative_id= ? and transactions.transaction_type_id = 2  ) as a where a.date >= ? AND a.date <= ? order by a.date", [$this->representative_id, $this->representative_id, $this->from_date . " 00:00:00", $this->to_date . " 23:59:59"]);
        //         foreach ($data as $key => $value) {
        //             $this->total_amount_in += (int) $value->amountin;
        //             $this->total_amount_out += (int) $value->amountout;
        //         }
        //         return $data;
        //     } else if ($this->from_date && $this->to_date == null) {
        //         $data = DB::select("select * from (
        //     SELECT transactions.trans_sn, transactions.date, SUM(orders.representative_deserves) as amountin  , '-' as amountout  FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.representative_id = ? GROUP BY orders.transaction_id
        //     UNION
        //     SELECT transactions.trans_sn, transactions.date, '-' as amountin  , transactions.amount as amountout  from transactions  where transactions.representative_id= ? and transactions.transaction_type_id = 2  ) as a where a.date >= ? order by a.date", [$this->representative_id, $this->representative_id, $this->from_date . " 00:00:00"]);
        //         foreach ($data as $key => $value) {
        //             $this->total_amount_in += (int) $value->amountin;
        //             $this->total_amount_out += (int) $value->amountout;
        //         }
        //         return $data;
        //     } else if ($this->from_date == null && $this->to_date) {
        //         $data = DB::select("select * from (
        //     SELECT transactions.trans_sn, transactions.date, SUM(orders.representative_deserves) as amountin  , '-' as amountout  FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.representative_id = ? GROUP BY orders.transaction_id
        //     UNION
        //     SELECT transactions.trans_sn, transactions.date, '-' as amountin  , transactions.amount as amountout  from transactions  where transactions.representative_id= ? and transactions.transaction_type_id = 2  ) as a where a.date <= ? order by a.date", [$this->representative_id, $this->representative_id, $this->to_date . " 23:59:59"]);
        //         foreach ($data as $key => $value) {
        //             $this->total_amount_in += (int) $value->amountin;
        //             $this->total_amount_out += (int) $value->amountout;
        //         }
        //         return $data;
        //     } else if ($this->from_date == null && $this->to_date == null) {
        //         $data = DB::select("select * from (
        //     SELECT transactions.trans_sn, transactions.date, SUM(orders.representative_deserves) as amountin  , '-' as amountout  FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.representative_id = ? GROUP BY orders.transaction_id
        //     UNION
        //     SELECT transactions.trans_sn, transactions.date, '-' as amountin  , transactions.amount as amountout  from transactions  where transactions.representative_id= ? and transactions.transaction_type_id = 2  ) as a order by a.date", [$this->representative_id, $this->representative_id]);
        //         // dd($data);
        //         foreach ($data as $key => $value) {
        //             $this->total_amount_in += (int) $value->amountin;
        //             $this->total_amount_out += (int) $value->amountout;
        //         }
        //         return $data;
        //     }
        // }
        if ($this->representative_id) {
            $query = DB::table('representative_orders_per_days')
                // ->join('orders', 'orders.id', "=", "representative_orders_percentages.order_id")
                ->leftJoin('transactions', 'transactions.id', "=", "representative_orders_per_days.transaction_id")
                
                ->when($this->from_date, function ($query) {
                    $query->where('representative_orders_per_days.Date', ">=", $this->from_date . " 00:00:00");
                })
                ->when($this->to_date, function ($query) {
                    $query->where('representative_orders_per_days.Date', "<=", $this->to_date . " 23:59:59");
                })
                ->select(['representative_orders_per_days.*', 'transactions.trans_sn'])->get();
            // dd($query);
            foreach ($query as $key => $value) {
                $this->total_amount_in += (int) $value->add;
                $this->total_amount_out += (int) $value->dedection;
            }
            return $query;
        } else {
            return [];
        }
        // return [];
    }

    public function render()
    {
        return view('livewire.show-representative-account-statement', [
            "data" => $this->getFilteredRepresentativeAccountStatement(),
            "representatives" => Representative::all(),
        ]);
    }
}
