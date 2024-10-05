<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use DB;

class ReprestiveOrderSearch extends Component
{
    public $client, $all_toggler = false, $json_ids, $user_id = null, $from_date, $status_filter, $to_date, $ids = [], $searchTerm;

    public function uppendToids($value)
    {
        // dd($value);
        if ($this->user_id == null) {
            $this->emit('ErrorException', __('translation.no_user_is_selected'));
        }
        // dd($this->ids);
        if ($value == 'all') {
            // dd('Heelo ');
            $this->all_toggler = !$this->all_toggler;
            if ($this->all_toggler) {
                $orders = $this->getOrders();
                $ids = $orders->pluck('id')->toArray();
                $this->ids = array_merge($this->ids, $ids);
            } else {
                $this->ids = [];
            }
        } else {

            if (!in_array($value, $this->ids)) {
                array_push($this->ids, $value);
                $this->json_ids = encrypt($this->ids);
            } else {
                $this->ids  = array_filter($this->ids, fn ($el) => $el != $value);
                $this->json_ids = encrypt($this->ids);
            }
        }
    }

    public function getOrders()
    {
        // if ($this->user_id) dd($this->user_id);
        // $searchTerm = '%' . $this->searchTerm . '%';
        return  Order::with('Shipping')
        
            ->when(
                $this->user_id != null,
                function ($query, $user_id) {
                    $query->where('representative_id', $this->user_id);

                    
                },
                function ($query, $user_id) {
                    $query->where('representative_id', 1);
                }
            )
            
            ->ToDate($this->to_date)
            ->FromDate($this->from_date)
            ->StatusFilter($this->status_filter)
            ->IsDeleted()
            ->orderBy('id', 'desc')
            ->paginate(1000);
    }


    public function getOrders1()
    {
        // if ($this->user_id) dd($this->user_id);
        // $searchTerm = '%' . $this->searchTerm . '%';
        return  Order::with('Shipping')
        
            ->when(
                $this->user_id != null,
                function ($query, $user_id) {
                    $query->where('representative_id', $this->user_id);

                    
                },
                function ($query, $user_id) {
                    'order_fees';
                    'total_fees';
                   
                   // DB::pluck("SUM(total_fees) as total");
                 //  $sum = Order::sum('order_fees');
                    $query->where('representative_id', 1);
                }
            )
            ->select(DB::raw('
            SUM(order_value) as transaction_amount,
            COUNT(id) as id_count'))
            ->ToDate($this->to_date)
            ->FromDate($this->from_date)
            ->StatusFilter($this->status_filter)
            ->IsDeleted()
            ->orderBy('id', 'desc')
            ->paginate(1000);
    }



    public function getStatusStatics()
    {
        // $this->status_filter = 'pending';
        $statics = Order::select(
            'status',
            // DB::raw('sum(order_fees) as su'),
            'order_fees',
            'total_fees',
            'payment_method'
        )->where('representative_id', 1)
            ->ToDate($this->to_date)
            ->FromDate($this->from_date)
            ->StatusFilter($this->status_filter)
            ->IsDeleted() 
            // ->groupBy('status')
            ->get()
            ->groupBy('status');
        // dd($statics);
        return ($statics);
    }
    public function render()
    {

        $data = $this->getOrders();
        $orders_status = $this->getStatusStatics();
        $orders_status1 = $this->getOrders1();
        // dd($orders_status);
        return view(
            'livewire.represtive-order-search',
            [
                'data' => $data,
                'order_status' => $orders_status,
                'order_status1' => $orders_status1,
            ]
        )
            ->layout('layouts.master');
    }
}
