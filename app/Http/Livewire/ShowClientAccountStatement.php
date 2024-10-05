<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Order;
use App\Models\Transaction;
use Livewire\Component;
use DB;

class ShowClientAccountStatement extends Component
{
    public $client_id;
    public $from_date;
    public $to_date;
    public $total_amount_in = 0;
    public $total_amount_out = 0;
    public $client_current_account_balance = 0;

    public function hydrate()
    {
        $this->emit("select2");
        $this->total_amount_in = 0;
        $this->total_amount_out = 0;
    }

    public function updatedClientId()
    {
        $this->client_current_account_balance = Client::find($this->client_id)->account_balance;
    }

    private function getFilteredClientAccountStatement()
    {
        if ($this->client_id != null) {
            if ($this->from_date && $this->to_date) {
                $data = DB::select("select * from ( SELECT transactions.trans_sn, transactions.date, SUM(orders.order_fees) as amountin , '-' as amountout FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.client_id = ? GROUP BY orders.transaction_id UNION SELECT transactions.trans_sn, transactions.date, '-' as amountin , transactions.amount as amountout from transactions where transactions.client_id= ?) as a WHERE a.date >= ? AND a.date <= ? order by a.date
            ", [$this->client_id, $this->client_id, $this->from_date . " 00:00:00", $this->to_date . " 23:59:59"]);
                foreach ($data as $key => $value) {
                    $this->total_amount_in += (int) $value->amountin;
                    $this->total_amount_out += (int) $value->amountout;
                }
                return $data;
            } else if ($this->from_date && $this->to_date == null) {
                $data = DB::select("select * from ( SELECT transactions.trans_sn, transactions.date, SUM(orders.order_fees) as amountin , '-' as amountout FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.client_id = ? GROUP BY orders.transaction_id UNION SELECT transactions.trans_sn, transactions.date, '-' as amountin , transactions.amount as amountout from transactions where transactions.client_id= ?) as a WHERE a.date >= ? order by a.date
            ", [$this->client_id, $this->client_id, $this->from_date . " 00:00:00"]);
                foreach ($data as $key => $value) {
                    $this->total_amount_in += (int) $value->amountin;
                    $this->total_amount_out += (int) $value->amountout;
                }
                return $data;
            } else if ($this->from_date == null && $this->to_date) {
                $data = DB::select("select * from ( SELECT transactions.trans_sn, transactions.date, SUM(orders.order_fees) as amountin , '-' as amountout FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.client_id = ? GROUP BY orders.transaction_id UNION SELECT transactions.trans_sn, transactions.date, '-' as amountin , transactions.amount as amountout from transactions where transactions.client_id= ?) as a WHERE a.date <= ? order by a.date
            ", [$this->client_id, $this->client_id, $this->to_date . " 23:59:59"]);
                foreach ($data as $key => $value) {
                    $this->total_amount_in += (int) $value->amountin;
                    $this->total_amount_out += (int) $value->amountout;
                }
                return $data;
            } else if ($this->from_date == null && $this->to_date == null) {
                $data = DB::select("select * from ( SELECT transactions.trans_sn, transactions.date, SUM(orders.order_fees) as amountin , '-' as amountout FROM orders INNER JOIN transactions ON orders.transaction_id = transactions.id WHERE orders.client_id = ? GROUP BY orders.transaction_id UNION SELECT transactions.trans_sn, transactions.date, '-' as amountin , transactions.amount as amountout from transactions where transactions.client_id= ?) as a order by a.date
            ", [$this->client_id, $this->client_id]);
                // dd($data);
                foreach ($data as $key => $value) {
                    $this->total_amount_in += (int) $value->amountin;
                    $this->total_amount_out += (int) $value->amountout;
                }
                return $data;
            }
        }
        return [];
    }

    public function render()
    {
        return view('livewire.show-client-account-statement', [
            "data" => $this->getFilteredClientAccountStatement(),
            "clients" => Client::all(),
        ]);
    }
}
